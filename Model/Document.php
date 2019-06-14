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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return DocumentInterface
     */
    public function setTitle(string $title): DocumentInterface
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
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     *
     * @return DocumentInterface
     */
    public function setAuthor(string $author): DocumentInterface
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * @param string $recipient
     *
     * @return DocumentInterface
     */
    public function setRecipient(string $recipient): DocumentInterface
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @return string
     */
    public function getOriginPlace(): string
    {
        return $this->originPlace;
    }

    /**
     * @param string $originPlace
     *
     * @return DocumentInterface
     */
    public function setOriginPlace(string $originPlace): DocumentInterface
    {
        $this->originPlace = $originPlace;

        return $this;
    }

    /**
     * @return string
     */
    public function getDestinationPlace(): string
    {
        return $this->destinationPlace;
    }

    /**
     * @param string $destinationPlace
     *
     * @return DocumentInterface
     */
    public function setDestinationPlace(string $destinationPlace): DocumentInterface
    {
        $this->destinationPlace = $destinationPlace;

        return $this;
    }

    /**
     * @return string
     */
    public function getOriginDate(): string
    {
        return $this->originDate;
    }

    /**
     * @param string $originDate
     *
     * @return DocumentInterface
     */
    public function setOriginDate(string $originDate): DocumentInterface
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
}
