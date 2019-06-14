<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Model\Presentation;

/**
 * Manifest support
 *
 * @see https://subugoe.pages.gwdg.de/emo/text-api/page/specs/#support-object
 */
class Support
{
    /**
     * @var string
     */
    private $type = 'css';

    /**
     * @var string
     */
    private $mime = 'text/css';

    /**
     * @var string
     */
    private $url;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Support
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getMime(): string
    {
        return $this->mime;
    }

    /**
     * @param string $mime
     *
     * @return Support
     */
    public function setMime(string $mime): self
    {
        $this->mime = $mime;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Support
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
