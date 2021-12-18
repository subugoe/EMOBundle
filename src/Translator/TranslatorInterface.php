<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Translator;

use Subugoe\EMOBundle\Model\DocumentInterface;

interface TranslatorInterface
{
    public function getContentsById(string $id): array;

    public function getDocumentById(string $id): DocumentInterface;

    public function getEntity(string $entityGnd): ?array;

    public function getItemAnnotationsStartIndex(string $id, int $pageNumber): int;

    public function getManifestTotalNumberOfAnnotations(string $id): int;

    public function getManifestUrlByPageId(string $pageId): string;
}
