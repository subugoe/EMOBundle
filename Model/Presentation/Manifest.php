<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model\Presentation;

/**
 *
 * @see https://subugoe.pages.gwdg.de/emo/text-api/page/specs/#manifest-json
 *
 */
class Manifest
{
    /**
     * @var string
     */
    private $textapi = '0.0.2';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $label;

    /**
     * @var array
     */
    private $metadata;

    /**
     * @var array
     */
    private $sequence;

    /**
     * @var array
     */
    private $support;

    /**
     * @var array
     */
    private $license;

    /**
     * @return string
     */
    public function getTextapi(): string
    {
        return $this->textapi;
    }

    /**
     * @param string $textapi
     *
     * @return Manifest
     */
    public function setTextapi(string $textapi): self
    {
        $this->textapi = $textapi;

        return $this;
    }

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
     * @return Manifest
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return Manifest
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * @param array $metadata
     *
     * @return Manifest
     */
    public function setMetadata(array $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @return array
     */
    public function getSequence(): array
    {
        return $this->sequence;
    }

    /**
     * @param array $sequence
     *
     * @return Manifest
     */
    public function setSequence(array $sequence): self
    {
        $this->sequence = $sequence;

        return $this;
    }

    /**
     * @return array
     */
    public function getSupport(): array
    {
        return $this->support;
    }

    /**
     * @param array $support
     *
     * @return Manifest
     */
    public function setSupport(array $support): self
    {
        $this->support = $support;

        return $this;
    }

    /**
     * @return array
     */
    public function getLicense(): array
    {
        return $this->license;
    }

    /**
     * @param array $license
     *
     * @return Manifest
     */
    public function setLicense(array $license): self
    {
        $this->license = $license;

        return $this;
    }
}
