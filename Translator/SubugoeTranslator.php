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
            ->setTitle($solrDocument['title'])
            ->setContent($solrDocument['fulltext_html'])
            ->setAuthor($solrDocument['author'])
            ->setRecipient($solrDocument['recipient'])
            ->setOriginPlace($solrDocument['origin_place'])
            ->setDestinationPlace($solrDocument['destination_place'])
            ->setOriginDate(date("d.m.Y", strtotime($solrDocument['origin_date'])));

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
}
