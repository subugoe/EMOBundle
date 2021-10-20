<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Translator;

use Solarium\Client;
use Solarium\QueryType\Select\Result\Document as Result;
use Subugoe\EMOBundle\Model\Document;
use Subugoe\EMOBundle\Model\DocumentInterface;

class SubugoeTranslator implements TranslatorInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getContentsById(string $id): array
    {
        $query = $this->client->createSelect()
            ->setQuery(sprintf('article_id:%s AND doctype:page', $id));

        $rows = $this->client->execute($query)->getData()['response']['numFound'];
        $query->setRows($rows);
        $select = $this->client->select($query);
        $count = $select->count();

        if (0 === $count) {
            throw new \InvalidArgumentException(sprintf('No contents found for the Document %s', $id));
        }

        return $select->getDocuments();
    }

    public function getDocumentById(string $id): DocumentInterface
    {
        $document = new Document();
        $solrDocument = $this->getDocument($id);

        $document
            ->setId($solrDocument['id'])
            ->setTitle($solrDocument['short_title'] ?? null)
            ->setEditedText($solrDocument['edited_text'] ?? '')
            ->setTranscriptedText($solrDocument['transcripted_text'] ?? '');

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

        if (isset($solrDocument['article_pub_date']) && !empty($solrDocument['article_pub_date'])) {
            $document->setPublishDate($solrDocument['article_pub_date']);
        }

        if (isset($solrDocument['response']) && !empty($solrDocument['response'])) {
            $document->setResponse($solrDocument['response']);
        }

        if (isset($solrDocument['entities']) && !empty($solrDocument['entities'])) {
            $document->setEntities($solrDocument['entities']);
        }

        if (isset($solrDocument['annotation_ids']) && !empty($solrDocument['annotation_ids'])) {
            $document->setAnnotationIds($solrDocument['annotation_ids']);
        }

        if (isset($solrDocument['page_segs']) && !empty($solrDocument['page_segs'])) {
            $document->setPageSegs($solrDocument['page_segs']);
        }

        if (isset($solrDocument['page_notes']) && !empty($solrDocument['page_notes'])) {
            $document->setPageNotes($solrDocument['page_notes']);
        }

        if (isset($solrDocument['page_notes_ids']) && !empty($solrDocument['page_notes_ids'])) {
            $document->setPageNotesIds($solrDocument['page_notes_ids']);
        }

        if (isset($solrDocument['page_sics']) && !empty($solrDocument['page_sics'])) {
            $document->setPageSics($solrDocument['page_sics']);
        }

        if (isset($solrDocument['page_sics_ids']) && !empty($solrDocument['page_sics_ids'])) {
            $document->setPageSicsIds($solrDocument['page_sics_ids']);
        }

        if (isset($solrDocument['page_dates']) && !empty($solrDocument['page_dates'])) {
            $document->setPageDates($solrDocument['page_dates']);
        }

        if (isset($solrDocument['page_dates_ids']) && !empty($solrDocument['page_dates_ids'])) {
            $document->setPageDatesIds($solrDocument['page_dates_ids']);
        }

        $document
            ->setLicense($solrDocument['license'])
            ->setLanguage($solrDocument['language'])
            ->setImageUrl($solrDocument['image_url'])
            ->setArticleId($solrDocument['article_id'])
            ->setPageNumber((string) ($solrDocument['number_of_pages'] ?: $solrDocument['page_number']))
            ->setArticleTitle($solrDocument['article_title'])
            ->setGndKeywords($solrDocument['gnd_keyword'])
            ->setfreeKeywords($solrDocument['free_keyword'])
            ->setInstitution($solrDocument['institution'])
            ->setShelfmark($solrDocument['shelfmark'])
            ->setScriptSource($solrDocument['script_source'])
            ->setWriter($solrDocument['writer'])
            ->setReference($solrDocument['reference'])
            ->setRelatedItems($solrDocument['related_items']);

        return $document;
    }

    public function getEntity(string $entityGnd): array
    {
        $query = $this->client->createSelect()
            ->setQuery(sprintf('id:%s', $entityGnd));
        $select = $this->client->select($query);
        $count = $select->count();

        if (0 === $count) {
            throw new \InvalidArgumentException(sprintf('No entity found for the GND %s', $entityGnd));
        }

        return $select->getDocuments()[0]->getFields();
    }

    public function getItemAnnotationsStartIndex(string $id, int $pageNumber): int
    {
        $query = $this->client->createSelect()
            ->setFields(['entities'])
            ->setQuery(sprintf('article_id:%s', $id));
        $select = $this->client->select($query);
        $numFound = $select->getNumFound();
        $query->setRows($numFound);
        $select = $this->client->select($query);
        $count = $select->count();

        if (0 === $count) {
            throw new \InvalidArgumentException(sprintf('No entity found for the document %s', $id));
        }

        $startIndex = 0;
        foreach ($select->getDocuments() as $key => $entitySet) {
            if (($key < ($pageNumber - 1)) && isset($entitySet->getFields()['entities'])) {
                $startIndex += count($entitySet->getFields()['entities']);
            }
        }

        return $startIndex + 1;
    }

    public function getManifestTotalNumberOfAnnotations(string $id): int
    {
        $query = $this->client->createSelect()
            ->setFields(['entities'])
            ->setQuery(sprintf('article_id:%s', $id));
        $select = $this->client->select($query);
        $numFound = $select->getNumFound();
        $query->setRows($numFound);
        $select = $this->client->select($query);
        $count = $select->count();

        if (0 === $count) {
            throw new \InvalidArgumentException(sprintf('No entity found for the document %s', $id));
        }

        $total = 0;
        foreach ($select->getDocuments() as $entitySet) {
            if (isset($entitySet->getFields()['entities'])) {
                $total += count($entitySet->getFields()['entities']);
            }
        }

        return $total;
    }

    public function getManifestUrlByPageId(string $pageId): string
    {
        $solrDocument = $this->getDocument($pageId);

        return $solrDocument['article_id'];
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

        return $select->getDocuments()[0];
    }
}
