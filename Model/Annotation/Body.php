<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model\Annotation;

use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 *
 * @see https://subugoe.pages.gwdg.de/emo/text-api/page/annotation_specs/#body-object
 *
 */
class Body
{
    private string $type = 'TextualBody';
    private string $value;
    private string $format = 'text/plain';

    /** @SerializedName("x-content-type") */
    private string $xContentType;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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

    public function getXContentType(): string
    {
        return $this->xContentType;
    }

    public function setXContentType(string $xContentType): self
    {
        $this->xContentType = $xContentType;

        return $this;
    }
}
