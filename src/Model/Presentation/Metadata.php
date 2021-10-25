<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model\Presentation;

/**
 * Manifest metadata.
 *
 * @see https://subugoe.pages.gwdg.de/emo/text-api/page/specs/#metadata-object
 */
class Metadata
{
    private string $label = '';

    private string $value = '';

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
