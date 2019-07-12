<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model\Presentation;

/**
 *
 * @see https://subugoe.pages.gwdg.de/emo/text-api/page/specs/#item-json
 *
 */
class Item
{
    /**
     * @var string
     */
    private $textapi = '0.0.2';

    /**
     * @var Title
     */
    private $title;

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $language;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $content_type = 'text/html';

    /**
     * @return string
     */
    public function getTextapi(): string
    {
        return $this->textapi;
    }

    /**
     * @param string $textapi
     *
     * @return Item
     */
    public function setTextapi(string $textapi): self
    {
        $this->textapi = $textapi;

        return $this;
    }

    /**
     * @return Title
     */
    public function getTitle(): Title
    {
        return $this->title;
    }

    /**
     * @param Title $title
     *
     * @return Item
     */
    public function setTitle(Title $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Item
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return array
     */
    public function getLanguage(): array
    {
        return $this->language;
    }

    /**
     * @param array $language
     *
     * @return Item
     */
    public function setLanguage(array $language): self
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->content_type;
    }

    /**
     * @param string $content_type
     *
     * @return Item
     */
    public function setContentType(string $content_type): self
    {
        $this->content_type = $content_type;

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
     * @return Item
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
