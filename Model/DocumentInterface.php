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
}
