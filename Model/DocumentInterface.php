<?php

namespace Subugoe\EMOBundle\Model;

/**
 * Document for holding generic data.
 */
interface DocumentInterface
{
    public function getId(): ?string;
    public function setId(string $id): DocumentInterface;
    public function getTitle(): ?string;
    public function setTitle(?string $title): DocumentInterface;
    public function getContent(): string;
    public function setContent(string $content): DocumentInterface;
    public function getAuthor(): ?string;
    public function setAuthor(?string $author): DocumentInterface;
    public function getRecipient(): ?string;
    public function setRecipient(?string $recipient): DocumentInterface;
    public function getOriginPlace(): ?string;
    public function setOriginPlace(?string $originPlace): DocumentInterface;
    public function getDestinationPlace(): ?string;
    public function setDestinationPlace(?string $destinationPlace): DocumentInterface;
    public function getOriginDate(): ?string;
    public function setOriginDate(?string $originDate): DocumentInterface;
    public function getMetadata(): array;
    public function setMetadata(array $metadata): DocumentInterface;
    public function getLicense(): ?string;
    public function setLicense(?string $license): DocumentInterface;
    public function getLanguage(): ?array;
    public function setLanguage(?array $language): DocumentInterface;
    public function getImageUrl(): ?string;
    public function setImageUrl(?string $imageUrl): DocumentInterface;
    public function getArticleId(): ?string;
    public function setArticleId(?string $articleId): DocumentInterface;
    public function getPageNumber(): ?string;
    public function setPageNumber(?string $pageNumber): DocumentInterface;
    public function getArticleTitle(): ?string;
    public function setArticleTitle(?string $articleTitle): DocumentInterface;
    public function getGndKeywords(): ?array;
    public function setGndKeywords(?array $gndKeywords): DocumentInterface;
    public function getFreeKeywords(): ?array;
    public function setFreeKeywords(?array $freeKeywords): DocumentInterface;
}
