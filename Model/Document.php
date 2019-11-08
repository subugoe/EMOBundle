<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model;

/**
 * Document for holding generic data.
 */
class Document implements DocumentInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $recipient;

    /**
     * @var string
     */
    private $originPlace;

    /**
     * @var string
     */
    private $destinationPlace;

    /**
     * @var string
     */
    private $originDate;

    /**
     * @var array
     */
    private $metadata;

    /**
     * @var string
     */
    private $license;

    /**
     * @var array
     */
    private $language;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return DocumentInterface
     */
    public function setId(string $id): DocumentInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     *
     * @return DocumentInterface
     */
    public function setTitle(?string $title): DocumentInterface
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return DocumentInterface
     */
    public function setContent(string $content): DocumentInterface
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param string|null $author
     *
     * @return DocumentInterface
     */
    public function setAuthor(?string $author): DocumentInterface
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRecipient(): ?string
    {
        return $this->recipient;
    }

    /**
     * @param string|null $recipient
     *
     * @return DocumentInterface
     */
    public function setRecipient(?string $recipient): DocumentInterface
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOriginPlace(): ?string
    {
        return $this->originPlace;
    }

    /**
     * @param string|null $originPlace
     *
     * @return DocumentInterface
     */
    public function setOriginPlace(?string $originPlace): DocumentInterface
    {
        $this->originPlace = $originPlace;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDestinationPlace(): ?string
    {
        return $this->destinationPlace;
    }

    /**
     * @param string|null $destinationPlace
     *
     * @return DocumentInterface
     */
    public function setDestinationPlace(?string $destinationPlace): DocumentInterface
    {
        $this->destinationPlace = $destinationPlace;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOriginDate(): ?string
    {
        return $this->originDate;
    }

    /**
     * @param string|null $originDate
     *
     * @return DocumentInterface
     */
    public function setOriginDate(?string $originDate): DocumentInterface
    {
        $this->originDate = $originDate;

        return $this;
    }

    /**
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * @param array $metadata
     *
     * @return Document
     */
    public function setMetadata(array $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @param string|null $license
     *
     * @return DocumentInterface
     */
    public function setLicense(?string $license): DocumentInterface
    {
        $this->license = $license;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLicense(): ?string
    {
        return $this->license;
    }

    /**
     * @param array|null $language
     *
     * @return DocumentInterface
     */
    public function setLanguage(?array $language): DocumentInterface
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getLanguage(): ?array
    {
        return $this->language;
    }
}
