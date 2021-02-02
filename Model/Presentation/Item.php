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
    private string $textapi = '3.1.1';
    /**
     * @var Title
     */
    private $title;
    private string $type;
    private ?string $n = null;
    private array $lang;
    private string $content;
    private string $content_type = 'text/html';

    /**
     * @var Image
     */
    private $image;

    public function getTextapi(): string
    {
        return $this->textapi;
    }

    public function setTextapi(string $textapi): self
    {
        $this->textapi = $textapi;

        return $this;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function setTitle(Title $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }



    public function getN(): ?string
    {
        return $this->n;
    }

    public function setN(?string $n): self
    {
        $this->n = $n;

        return $this;
    }


    public function getLang(): array
    {
        return $this->lang;
    }

    public function setLang(array $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    public function getContentType(): string
    {
        return $this->content_type;
    }

    public function setContentType(string $content_type): self
    {
        $this->content_type = $content_type;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    public function setImage(Image $image): self
    {
        $this->image = $image;

        return $this;
    }
}
