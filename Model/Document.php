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
    private $title;


    /**
     * @var string
     */
    private $content;

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
}
