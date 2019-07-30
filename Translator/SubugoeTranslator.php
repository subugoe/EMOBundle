<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Translator;

use Solarium\Client;
use Subugoe\EMOBundle\Model\Document;
use Subugoe\EMOBundle\Model\DocumentInterface;
use Solarium\QueryType\Select\Result\DocumentInterface as Result;

class SubugoeTranslator implements TranslatorInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * SubugoeTranslator constructor.
     *
     * @param Client $client           $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $id
     *
     * @return DocumentInterface
     */
    public function getDocumentById(string $id): DocumentInterface
    {
        $document = new Document();

        $solrDocument = $this->getDocument($id);

        $document
            ->setId($solrDocument['id'])
            ->setTitle($solrDocument['title'] ?? null)
            ->setContent($solrDocument['fulltext_html'] ?? $solrDocument['html_page'])
            ->setAuthor($solrDocument['author'] ?? null)
            ->setRecipient($solrDocument['recipient'] ?? null)
            ->setOriginPlace($solrDocument['origin_place'] ?? null)
            ->setDestinationPlace($solrDocument['destination_place'] ?? null)
            ->setOriginDate(!empty($solrDocument['origin_date']) ? date("d.m.Y", strtotime($solrDocument['origin_date'])) : null)
            ->setLicense($solrDocument['license'])
            ->setLanguage($solrDocument['language']);

        return $document;
    }

    /**
     * @param string $id
     *
     * @return Result
     */
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

    /**
     * @param string $id
     *
     * @return array
     */
    public function getContentsById(string $id): array
    {
        $query = $this->client->createSelect()
            ->setQuery(sprintf('article_id:%s', $id));
        $select = $this->client->select($query);
        $count = $select->count();

        if (0 === $count) {
            throw new \InvalidArgumentException(sprintf('No contents found for the Document %s', $id));
        }

        return $select->getDocuments();
    }
}
