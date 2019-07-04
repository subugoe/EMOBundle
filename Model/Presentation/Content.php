<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model\Presentation;

/**
 * Item content
 *
 * @see https://subugoe.pages.gwdg.de/emo/text-api/page/specs/#item-object
 */
class Content
{
    /**
     * @var string
     */
    private $content;

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
     * @return Content
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
