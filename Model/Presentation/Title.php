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
    private string $title;
    private string $type;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
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
}
