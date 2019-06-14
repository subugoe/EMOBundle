<?php

namespace Subugoe\EMOBundle\Model;

/**
 * Document for holding generic data.
 */
interface DocumentInterface
{
    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param string $title
     *
     * @return DocumentInterface
     */
    public function setTitle(string $title): DocumentInterface;

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
     * @return string
     */
    public function getAuthor(): string;

    /**
     * @param string $author
     *
     * @return DocumentInterface
     */
    public function setAuthor(string $author): DocumentInterface;

    /**
     * @return string
     */
    public function getRecipient(): string;

    /**
     * @param string $recipient
     *
     * @return DocumentInterface
     */
    public function setRecipient(string $recipient): DocumentInterface;


    /**
     * @return string
     */
    public function getOriginPlace(): string;

    /**
     * @param string $originPlace
     *
     * @return DocumentInterface
     */
    public function setOriginPlace(string $originPlace): DocumentInterface;

    /**
     * @return string
     */
    public function getDestinationPlace(): string;

    /**
     * @param string $destinationPlace
     *
     * @return DocumentInterface
     */
    public function setDestinationPlace(string $destinationPlace): DocumentInterface;

    /**
     * @return string
     */
    public function getOriginDate(): string;

    /**
     * @param string $originDate
     *
     * @return DocumentInterface
     */
    public function setOriginDate(string $originDate): DocumentInterface;
}
