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
    private $license;

    /**
     * @return string
     */
    public function getLicense(): string
    {
        return $this->license;
    }

    /**
     * @param string $license
     *
     * @return License
     */
    public function setLicense(string $license): self
    {
        $this->license = $license;

        return $this;
    }
}
