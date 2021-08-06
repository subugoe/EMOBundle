<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model\Annotation;

/**
 *
 * @see https://subugoe.pages.gwdg.de/emo/text-api/page/annotation_specs/#target-object
 *
 */
class Target
{
    private string $id;
    private string $format;
    private string $language;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguag(string $language): self
    {
        $this->language = $language;

        return $this;
    }
}
