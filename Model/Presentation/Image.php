<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model\Presentation;

/**
 * Item image
 *
 * @see https://subugoe.pages.gwdg.de/emo/text-api/page/specs/#image-object
 *
 */
class Image
{
    private string $id;
    private string $manifest;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getManifest(): string
    {
        return $this->manifest;
    }

    public function setManifest(string $manifest): self
    {
        $this->manifest = $manifest;

        return $this;
    }
}
