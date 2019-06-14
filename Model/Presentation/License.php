<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model\Presentation;

/**
 * Manifest license
 *
 * @see https://subugoe.pages.gwdg.de/emo/text-api/page/specs/#license-object
 */
class License
{
    /**
     * @var string
     */
    private $id = 'CC-BY-NC-SA-4.0';

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
     * @return License
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
}
