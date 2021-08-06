<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model\Annotation;

use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 *
 * @see https://subugoe.pages.gwdg.de/emo/text-api/page/annotation_specs/#annotation-collection
 *
 */
class AnnotationCollection
{
    /** @SerializedName("@context") */
    private string $context = 'http://www.w3.org/ns/anno.jsonld';
    private string $id;
    private string $type = 'AnnotationCollection';
    private string $label;
    private int $total;
    private string $first;
    private string $last;

    public function getContext(): string
    {
        return $this->context;
    }

    public function setContext(string $context): self
    {
        $this->context = $context;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

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

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getFirst(): string
    {
        return $this->first;
    }

    public function setFirst(string $first): self
    {
        $this->first = $first;

        return $this;
    }

    public function getLast(): string
    {
        return $this->last;
    }

    public function setLast(string $last): self
    {
        $this->last = $last;

        return $this;
    }
}
