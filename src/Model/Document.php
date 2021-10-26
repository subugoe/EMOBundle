<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model;

/**
 * Document for holding generic data.
 */
class Document implements DocumentInterface
{
    private ?array $annotationIds = null;

    private ?string $articleId = null;

    private ?string $articleTitle = null;

    private ?string $author = null;

    private string $content;

    private ?string $destinationPlace = null;

    private string $editedText;

    private ?array $entities = null;

    private ?array $freeKeywords = null;

    private ?array $gndKeywords = null;

    private string $id;

    private ?string $imageUrl = null;

    private ?string $institution = null;

    private ?array $language = null;

    private ?string $license = null;

    private array $metadata;

    private ?string $originDate = null;

    private ?string $originPlace = null;

    private ?array $pageDates = null;

    private ?array $pageDatesIds = null;

    private ?array $pageNotes = null;

    private ?array $pageNotesIds = null;
    
    private ?array $pageAllAnnotationIds = null;

    private ?string $pageNumber = null;

    private ?array $pageSegs = null;

    private ?array $pageSics = null;

    private ?array $pageSicsIds = null;

    private ?string $publishDate = null;

    private ?string $recipient = null;

    private ?string $reference = null;

    private ?array $related_items = null;

    private ?string $response = null;

    private ?string $script_source = null;

    private ?string $shelfmark = null;

    private ?string $title = null;

    private string $transcriptedText;

    private ?array $writer = null;

    public function getAnnotationIds(): ?array
    {
        return $this->annotationIds;
    }

    public function getArticleId(): ?string
    {
        return $this->articleId;
    }

    public function getArticleTitle(): ?string
    {
        return $this->articleTitle;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDestinationPlace(): ?string
    {
        return $this->destinationPlace;
    }

    public function getEditedText(): string
    {
        return $this->editedText;
    }

    public function getEntities(): ?array
    {
        return $this->entities;
    }

    public function getFreeKeywords(): ?array
    {
        return $this->freeKeywords;
    }

    public function getGndKeywords(): ?array
    {
        return $this->gndKeywords;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function getInstitution(): ?string
    {
        return $this->institution;
    }

    public function getLanguage(): ?array
    {
        return $this->language;
    }

    public function getLicense(): ?string
    {
        return $this->license;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function getOriginDate(): ?string
    {
        return $this->originDate;
    }

    public function getOriginPlace(): ?string
    {
        return $this->originPlace;
    }

    public function getPageDates(): ?array
    {
        return $this->pageDates;
    }

    public function getPageDatesIds(): ?array
    {
        return $this->pageDatesIds;
    }

    public function getPageNotes(): ?array
    {
        return $this->pageNotes;
    }

    public function getPageNotesIds(): ?array
    {
        return $this->pageNotesIds;
    }

    public function getPageNumber(): ?string
    {
        return $this->pageNumber;
    }

    public function getPageSegs(): ?array
    {
        return $this->pageSegs;
    }

    public function getPageSics(): ?array
    {
        return $this->pageSics;
    }

    public function getPageSicsIds(): ?array
    {
        return $this->pageSicsIds;
    }

    public function getPageAllAnnotationIds(): ?array
    {
        return $this->pageAllAnnotationIds;
    }

    public function getPublishDate(): ?string
    {
        return $this->publishDate;
    }

    public function getRecipient(): ?string
    {
        return $this->recipient;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function getRelatedItems(): ?array
    {
        return $this->related_items;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function getScriptSource(): ?string
    {
        return $this->script_source;
    }

    public function getShelfmark(): ?string
    {
        return $this->shelfmark;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getTranscriptedText(): string
    {
        return $this->transcriptedText;
    }

    public function getWriter(): ?array
    {
        return $this->writer;
    }

    public function setAnnotationIds(?array $annotationIds): DocumentInterface
    {
        $this->annotationIds = $annotationIds;

        return $this;
    }

    public function setArticleId(?string $articleId): DocumentInterface
    {
        $this->articleId = $articleId;

        return $this;
    }

    public function setArticleTitle(?string $articleTitle): DocumentInterface
    {
        $this->articleTitle = $articleTitle;

        return $this;
    }

    public function setAuthor(?string $author): DocumentInterface
    {
        $this->author = $author;

        return $this;
    }

    public function setContent(string $content): DocumentInterface
    {
        $this->content = $content;

        return $this;
    }

    public function setDestinationPlace(?string $destinationPlace): DocumentInterface
    {
        $this->destinationPlace = $destinationPlace;

        return $this;
    }

    public function setEditedText(string $editedText): DocumentInterface
    {
        $this->editedText = $editedText;

        return $this;
    }

    public function setEntities(?array $entities): DocumentInterface
    {
        $this->entities = $entities;

        return $this;
    }

    public function setFreeKeywords(?array $freeKeywords): DocumentInterface
    {
        $this->freeKeywords = $freeKeywords;

        return $this;
    }

    public function setGndKeywords(?array $gndKeywords): DocumentInterface
    {
        $this->gndKeywords = $gndKeywords;

        return $this;
    }

    public function setId(string $id): DocumentInterface
    {
        $this->id = $id;

        return $this;
    }

    public function setImageUrl(?string $imageUrl): DocumentInterface
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function setInstitution(?string $institution): DocumentInterface
    {
        $this->institution = $institution;

        return $this;
    }

    public function setLanguage(?array $language): DocumentInterface
    {
        $this->language = $language;

        return $this;
    }

    public function setLicense(?string $license): DocumentInterface
    {
        $this->license = $license;

        return $this;
    }

    public function setMetadata(array $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function setOriginDate(?string $originDate): DocumentInterface
    {
        $this->originDate = $originDate;

        return $this;
    }

    public function setOriginPlace(?string $originPlace): DocumentInterface
    {
        $this->originPlace = $originPlace;

        return $this;
    }

    public function setPageDates(?array $pageDates): DocumentInterface
    {
        $this->pageDates = $pageDates;

        return $this;
    }

    public function setPageDatesIds(?array $pageDatesIds): DocumentInterface
    {
        $this->pageDatesIds = $pageDatesIds;

        return $this;
    }

    public function setPageNotes(?array $pageNotes): DocumentInterface
    {
        $this->pageNotes = $pageNotes;

        return $this;
    }

    public function setPageNotesIds(?array $pageNotesIds): DocumentInterface
    {
        $this->pageNotesIds = $pageNotesIds;

        return $this;
    }

    public function setPageNumber(?string $pageNumber): DocumentInterface
    {
        $this->pageNumber = $pageNumber;

        return $this;
    }

    public function setPageSegs(?array $pageSegs): DocumentInterface
    {
        $this->pageSegs = $pageSegs;

        return $this;
    }

    public function setPageSics(?array $pageSics): DocumentInterface
    {
        $this->pageSics = $pageSics;

        return $this;
    }

    public function setPageSicsIds(?array $pageSicsIds): DocumentInterface
    {
        $this->pageSicsIds = $pageSicsIds;

        return $this;
    }
    
    public function setPageAllAnnotationIds(?array $pageAllAnnotationIds): DocumentInterface
    {
        $this->pageAllAnnotationIds = $pageAllAnnotationIds;
        
        return $this;
    }

    public function setPublishDate(?string $publishDate): DocumentInterface
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function setRecipient(?string $recipient): DocumentInterface
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function setReference(?string $reference): DocumentInterface
    {
        $this->reference = $reference;

        return $this;
    }

    public function setRelatedItems(?array $related_items): DocumentInterface
    {
        $this->related_items = $related_items;

        return $this;
    }

    public function setResponse(?string $response): DocumentInterface
    {
        $this->response = $response;

        return $this;
    }

    public function setScriptSource(?string $script_source): DocumentInterface
    {
        $this->script_source = $script_source;

        return $this;
    }

    public function setShelfmark(?string $shelfmark): DocumentInterface
    {
        $this->shelfmark = $shelfmark;

        return $this;
    }

    public function setTitle(?string $title): DocumentInterface
    {
        $this->title = $title;

        return $this;
    }

    public function setTranscriptedText(string $transcriptedText): DocumentInterface
    {
        $this->transcriptedText = $transcriptedText;

        return $this;
    }

    public function setWriter(?array $writer): DocumentInterface
    {
        $this->writer = $writer;

        return $this;
    }
}
