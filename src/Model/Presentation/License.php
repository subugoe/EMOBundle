<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model\Presentation;

/**
 * Manifest license.
 *
 * @see https://subugoe.pages.gwdg.de/emo/text-api/page/specs/#license-object
 */
class License
{
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
}
