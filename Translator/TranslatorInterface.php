<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Translator;

use Subugoe\EMOBundle\Model\DocumentInterface;

interface TranslatorInterface
{
    public function getManifestUrlByPageId(string $pageId): string;

    public function getDocumentById(string $id): DocumentInterface;

    public function getContentsById(string $id): array;

    public function getEntity(string $entityGnd): array;

    public function getManifestTotalNumerOfAnnotations(string $id): int;

    public function getItemAnnotationsStartIndex(string $id, int $pageNumber): int;
}
