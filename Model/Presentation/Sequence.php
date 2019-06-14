<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model\Presentation;

/**
 * Manifest sequence
 *
 * @see https://subugoe.pages.gwdg.de/emo/text-api/page/specs/#sequence-object
 */
class Sequence
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $type = 'item';

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
     * @return Sequence
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
}
