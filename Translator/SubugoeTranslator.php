<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Translator;

use Solarium\Client;
use Subugoe\EMOBundle\Model\Document;
use Subugoe\EMOBundle\Model\DocumentInterface;
use Solarium\QueryType\Select\Result\Document as Result;

class SubugoeTranslator implements TranslatorInterface
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getManifestUrlByPageId(string $pageId): string
    {
        $document = new Document();

        $solrDocument = $this->getDocument($pageId);

        return $solrDocument['article_id'];
    }

    public function getDocumentById(string $id): DocumentInterface
    {
        $document = new Document();

        $solrDocument = $this->getDocument($id);

        $document
            ->setId($solrDocument['id'])
            ->setTitle($solrDocument['title'] ?? null)
            ->setContent($solrDocument['fulltext_html'] ?? $solrDocument['html_page']);

        if (isset($solrDocument['author']) && !empty($solrDocument['author'])) {
            $document->setAuthor(implode(', ', $solrDocument['author']));
        }

        if (isset($solrDocument['recipient']) && !empty($solrDocument['recipient'])) {
            $document->setRecipient(implode(', ', $solrDocument['recipient']));
        }

        if (isset($solrDocument['origin_place']) && !empty($solrDocument['origin_place'])) {
            $document->setOriginPlace(implode(', ', $solrDocument['origin_place']));
        }

        if (isset($solrDocument['destination_place']) && !empty($solrDocument['destination_place'])) {
            $document->setDestinationPlace(implode(', ', $solrDocument['destination_place']));
        }

        $document
            ->setOriginDate(!empty($solrDocument['origin_date']) ? date("d.m.Y", strtotime($solrDocument['origin_date'])) : null)
            ->setLicense($solrDocument['license'])
            ->setLanguage($solrDocument['language'])
            ->setImageUrl($solrDocument['image_url']);

        return $document;
    }

    private function getDocument(string $id): Result
    {
        $query = $this->client->createSelect()
            ->setQuery(sprintf('id:%s', $id));
        $select = $this->client->select($query);
        $count = $select->count();

        if (0 === $count) {
            throw new \InvalidArgumentException(sprintf('Document %s not found', $id));
        }

        $solrDocument = $select->getDocuments()[0];

        return $solrDocument;
    }

    public function getContentsById(string $id): array
    {
        $query = $this->client->createSelect()
            ->setQuery(sprintf('article_id:%s', $id));

        $rows = $this->client->execute($query)->getData()['response']['numFound'];
        $query->setRows($rows);
        $select = $this->client->select($query);
        $count = $select->count();

        if (0 === $count) {
            throw new \InvalidArgumentException(sprintf('No contents found for the Document %s', $id));
        }

        return $select->getDocuments();
    }
}
