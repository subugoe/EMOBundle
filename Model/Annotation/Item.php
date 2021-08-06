<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model\Annotation;

/**
 *
 * @see https://subugoe.pages.gwdg.de/emo/text-api/page/annotation_specs/#annotation-item-object
 *
 */
class Item
{
    /*
     * Body
     */
    private $body;

    /*
     * @var Target
     */
    private $target;
    private string $type = 'Annotation';
    private string $id;

    public function getBody(): Body
    {
        return $this->body;
    }

    public function setBody(Body $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getTarget(): Target
    {
        return $this->target;
    }

    public function setTarget(Target $target): self
    {
        $this->target = $target;

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

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
}
