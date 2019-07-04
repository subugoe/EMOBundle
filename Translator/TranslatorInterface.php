<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Translator;

use Subugoe\EMOBundle\Model\DocumentInterface;

interface TranslatorInterface
{
    /**
     * @param string $id
     *
     * @return DocumentInterface
     */
    public function getDocumentById(string $id): DocumentInterface;

    public function getContentsById(string $id): array ;
}
