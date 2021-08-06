<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model\Annotation;

use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 *
 * @see https://subugoe.pages.gwdg.de/emo/text-api/page/annotation_specs/#annotation-page
 *
 */
class AnnotationPage
{
    /** @SerializedName("@context") */
    private string $context = 'http://www.w3.org/ns/anno.jsonld';
    private string $id;
    private string $type = 'AnnotationPage';
    private PartOf $partOf;
    public ?string $next;
    private ?string $prev;
    private int $startIndex;
    private array $items;

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

    public function getPartOf(): PartOf
    {
        return $this->partOf;
    }

    public function setPartOf(PartOf $partOf): self
    {
        $this->partOf = $partOf;

        return $this;
    }

    public function getNext(): ?string
    {
        return $this->next;
    }

    public function setNext(?string $next): self
    {
        $this->next = $next;

        return $this;
    }

    public function getPrev(): ?string
    {
        return $this->prev;
    }

    public function setPrev(?string $prev): self
    {
        $this->prev = $prev;

        return $this;
    }

    public function getStartIndex(): int
    {
        return $this->startIndex;
    }

    public function setStartIndex(int $startIndex): self
    {
        $this->startIndex = $startIndex;

        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }
}
