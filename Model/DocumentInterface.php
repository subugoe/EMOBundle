<?php

namespace Subugoe\EMOBundle\Model;

/**
 * Document for holding generic data.
 */
interface DocumentInterface
{
    /**
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * @param string|null $title
     *
     * @return DocumentInterface
     */
    public function setTitle(?string $title): DocumentInterface;

    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @param string $content
     *
     * @return DocumentInterface
     */
    public function setContent(string $content): DocumentInterface;

    /**
     * @return string|null
     */
    public function getAuthor(): ?string;

    /**
     * @param string|null $author
     *
     * @return DocumentInterface
     */
    public function setAuthor(?string $author): DocumentInterface;

    /**
     * @return string|null
     */
    public function getRecipient(): ?string;

    /**
     * @param string|null $recipient
     *
     * @return DocumentInterface
     */
    public function setRecipient(?string $recipient): DocumentInterface;
    
    /**
     * @return string|null
     */
    public function getOriginPlace(): ?string;

    /**
     * @param string|null $originPlace
     *
     * @return DocumentInterface
     */
    public function setOriginPlace(?string $originPlace): DocumentInterface;

    /**
     * @return string|null
     */
    public function getDestinationPlace(): ?string;

    /**
     * @param string|null $destinationPlace
     *
     * @return DocumentInterface
     */
    public function setDestinationPlace(?string $destinationPlace): DocumentInterface;

    /**
     * @return string|null
     */
    public function getOriginDate(): ?string;

    /**
     * @param string|null $originDate
     *
     * @return DocumentInterface
     */
    public function setOriginDate(?string $originDate): DocumentInterface;

    /**
     * @param string|null $license
     *
     * @return DocumentInterface
     */
    public function setLicense(?string $license): DocumentInterface;

    /**
     * @return string|null
     */
    public function getLicense(): ?string;

    /**
     * @param array|null $language
     *
     * @return DocumentInterface
     */
    public function setLanguage(?array $language): DocumentInterface;

    /**
     * @return array|null
     */
    public function getLanguage(): ?array;
}
