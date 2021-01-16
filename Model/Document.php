<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model;

/**
 * Document for holding generic data.
 */
class Document implements DocumentInterface
{
    private string $id;
    private ?string $title;
    private string $content;
    private ?string $author;
    private ?string $recipient;
    private ?string $originPlace;
    private ?string $destinationPlace;
    private ?string $originDate;
    private array $metadata;
    private ?string $license;
    private ?array $language;
    private ?string $imageUrl;

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
}
