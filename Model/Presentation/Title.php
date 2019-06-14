<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model\Presentation;

/**
 * Item title
 *
 * @see https://subugoe.pages.gwdg.de/emo/text-api/page/specs/#title-object
 *
 */
class Title
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $type = 'main';

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
     * @return Title
     */
    public function setTitle(string $title): self
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
     * @return Title
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
