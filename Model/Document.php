<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model;

/**
 * Document for holding generic data.
 */
class Document implements DocumentInterface
{
    private string $id;
    private ?string $title = Null;
    private string $content;
    private string $editedText;
    private string $transcriptedText;
    private ?string $author = Null;
    private ?string $recipient = Null;
    private ?string $originPlace = Null;
    private ?string $destinationPlace = Null;
    private ?string $publishDate = Null;
    private ?string $originDate = Null;
    private array $metadata;
    private ?string $license = Null;
    private ?array $language = Null;
    private ?string $imageUrl = Null;
    private ?string $articleId = Null;
    private ?string $pageNumber = Null;
    private ?string $articleTitle = Null;
    private ?array $gndKeywords = Null;
    private ?array $freeKeywords = Null;
    private ?string $institution = Null;
    private ?string $shelfmark = Null;
    private ?string $script_source = Null;
    private ?array $writer = Null;
    private ?string $reference = Null;
    private ?string $response = Null;
    private ?array $related_items = Null;
    private ?array $entities = Null;
    private ?array $annotationIds = Null;
    private ?array $pageNotes = Null;
    private ?array $pageNotesIds = Null;
    private ?array $pageSegs = Null;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): DocumentInterface
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): DocumentInterface
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): DocumentInterface
    {
        $this->content = $content;

        return $this;
    }

    public function getEditedText(): string
    {
        return $this->editedText;
    }

    public function setEditedText(string $editedText): DocumentInterface
    {
        $this->editedText = $editedText;

        return $this;
    }

    public function getTranscriptedText(): string
    {
        return $this->transcriptedText;
    }

    public function setTranscriptedText(string $transcriptedText): DocumentInterface
    {
        $this->transcriptedText = $transcriptedText;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): DocumentInterface
    {
        $this->author = $author;

        return $this;
    }

    public function getRecipient(): ?string
    {
        return $this->recipient;
    }

    public function setRecipient(?string $recipient): DocumentInterface
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getOriginPlace(): ?string
    {
        return $this->originPlace;
    }

    public function setOriginPlace(?string $originPlace): DocumentInterface
    {
        $this->originPlace = $originPlace;

        return $this;
    }

    public function getDestinationPlace(): ?string
    {
        return $this->destinationPlace;
    }

    public function setDestinationPlace(?string $destinationPlace): DocumentInterface
    {
        $this->destinationPlace = $destinationPlace;

        return $this;
    }

    public function getPublishDate(): ?string
    {
        return $this->publishDate;
    }

    public function setPublishDate(?string $publishDate): DocumentInterface
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function getOriginDate(): ?string
    {
        return $this->originDate;
    }

    public function setOriginDate(?string $originDate): DocumentInterface
    {
        $this->originDate = $originDate;

        return $this;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function setMetadata(array $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function setLicense(?string $license): DocumentInterface
    {
        $this->license = $license;

        return $this;
    }

    public function getLicense(): ?string
    {
        return $this->license;
    }

    public function setLanguage(?array $language): DocumentInterface
    {
        $this->language = $language;

        return $this;
    }

    public function getLanguage(): ?array
    {
        return $this->language;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): DocumentInterface
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getArticleId(): ?string
    {
        return $this->articleId;
    }

    public function setArticleId(?string $articleId): DocumentInterface
    {
        $this->articleId = $articleId;

        return $this;
    }

    public function getPageNumber(): ?string
    {
        return $this->pageNumber;
    }

    public function setPageNumber(?string $pageNumber): DocumentInterface
    {
        $this->pageNumber = $pageNumber;

        return $this;
    }

    public function getArticleTitle(): ?string
    {
        return $this->articleTitle;
    }

    public function setArticleTitle(?string $articleTitle): DocumentInterface
    {
        $this->articleTitle = $articleTitle;

        return $this;
    }

    public function setGndKeywords(?array $gndKeywords): DocumentInterface
    {
        $this->gndKeywords = $gndKeywords;

        return $this;
    }

    public function getGndKeywords(): ?array
    {
        return $this->gndKeywords;
    }

    public function setFreeKeywords(?array $freeKeywords): DocumentInterface
    {
        $this->freeKeywords = $freeKeywords;

        return $this;
    }

    public function getFreeKeywords(): ?array
    {
        return $this->freeKeywords;
    }

    public function getInstitution(): ?string
    {
        return $this->institution;
    }

    public function setInstitution(?string $institution): DocumentInterface
    {
        $this->institution = $institution;

        return $this;
    }

    public function getShelfmark(): ?string
    {
        return $this->shelfmark;
    }

    public function setShelfmark(?string $shelfmark): DocumentInterface
    {
        $this->shelfmark = $shelfmark;

        return $this;
    }

    public function getScriptSource(): ?string
    {
        return $this->script_source;
    }

    public function setScriptSource(?string $script_source): DocumentInterface
    {
        $this->script_source = $script_source;

        return $this;
    }

    public function getWriter(): ?array
    {
        return $this->writer;
    }

    public function setWriter(?array $writer): DocumentInterface
    {
        $this->writer = $writer;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): DocumentInterface
    {
        $this->reference = $reference;

        return $this;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(?string $response): DocumentInterface
    {
        $this->response = $response;

        return $this;
    }

    public function getRelatedItems(): ?array
    {
        return $this->related_items;
    }

    public function setRelatedItems(?array $related_items): DocumentInterface
    {
        $this->related_items = $related_items;

        return $this;
    }

    public function getEntities(): ?array
    {
        return $this->entities;
    }

    public function setEntities(?array $entities): DocumentInterface
    {
        $this->entities = $entities;

        return $this;
    }

    public function getAnnotationIds(): ?array
    {
        return $this->annotationIds;
    }

    public function setAnnotationIds(?array $annotationIds): DocumentInterface
    {
        $this->annotationIds = $annotationIds;

        return $this;
    }

    public function getPageNotes(): ?array
    {
        return $this->pageNotes;
    }

    public function setPageNotes(?array $pageNotes): DocumentInterface
    {
        $this->pageNotes = $pageNotes;

        return $this;
    }

    public function getPageNotesIds(): ?array
    {
        return $this->pageNotesIds;
    }

    public function setPageNotesIds(?array $pageNotesIds): DocumentInterface
    {
        $this->pageNotesIds = $pageNotesIds;

        return $this;
    }

    public function getPageSegs(): ?array
    {
        return $this->pageSegs;
    }

    public function setPageSegs(?array $pageSegs): DocumentInterface
    {
        $this->pageSegs = $pageSegs;

        return $this;
    }
}
