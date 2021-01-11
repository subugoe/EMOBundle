<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model\Presentation;

/**
 * Item title
 *
 * @see https://subugoe.pages.gwdg.de/emo/text-api/page/specs/#image-object
 *
 */
class Image
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $manifest;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Image
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getManifest(): string
    {
        return $this->manifest;
    }

    /**
     * @param string $manifest
     *
     * @return Image
     */
    public function setManifest(string $manifest): self
    {
        $this->manifest = $manifest;

        return $this;
    }
}
