<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Translator;

use Solarium\QueryType\Select\Result\DocumentInterface as Result;
use Subugoe\EMOBundle\Model\Document;
use Symfony\Component\Routing\RouterInterface;
use Solarium\Client;
use Subugoe\EMOBundle\Model\DocumentInterface;

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
            ->setTitle($solrDocument['title'])
            ->setContent($solrDocument['fulltext_html']);

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
