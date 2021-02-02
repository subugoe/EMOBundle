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
    private ?string $author = Null;
    private ?string $recipient = Null;
    private ?string $originPlace = Null;
    private ?string $destinationPlace = Null;
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
}
