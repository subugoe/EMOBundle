<?php

namespace Subugoe\EMOBundle\Model;

/**
 * Document for holding generic data.
 */
interface DocumentInterface
{
    public function getAnnotationIds(): ?array;

    public function getArticleId(): ?string;

    public function getArticleTitle(): ?string;

    public function getAuthor(): ?string;

    public function getContent(): string;

    public function getDestinationPlace(): ?string;

    public function getEntities(): ?array;

    public function getFreeKeywords(): ?array;

    public function getGndKeywords(): ?array;

    public function getId(): ?string;

    public function getImageUrl(): ?string;

    public function getInstitution(): ?string;

    public function getLanguage(): ?array;

    public function getLicense(): ?string;

    public function getMetadata(): array;

    public function getOriginDate(): ?string;

    public function getOriginPlace(): ?string;

    public function getPageDates(): ?array;

    public function getPageDatesIds(): ?array;

    public function getPageNotes(): ?array;

    public function getPageNotesIds(): ?array;

    public function getPageNotesAbstracts(): ?array;

    public function getPageNotesAbstractsIds(): ?array;

    public function getPageWorks(): ?array;

    public function getPageWorksIds(): ?array;

    public function getPageEntities(): ?array;

    public function getPageEntitiesIds(): ?array;

    public function getPageEntitiesTypes(): ?array;

    public function getPageNumber(): ?string;

    public function getPageFoliant(): ?string;

    public function getPageAllAnnotationIds(): ?array;

    public function getPrintSource(): ?string;

    public function getPublishDate(): ?string;

    public function getRecipient(): ?string;

    public function getReferences(): ?array;

    public function getRelatedItems(): ?array;

    public function getResponses(): ?array;

    public function getScriptSource(): ?string;

    public function getShelfmark(): ?string;

    public function getTitle(): ?string;

    public function getWriter(): ?array;

    public function setAnnotationIds(?array $annotationIds): DocumentInterface;

    public function setArticleId(?string $articleId): DocumentInterface;

    public function setArticleTitle(?string $articleTitle): DocumentInterface;

    public function setAuthor(?string $author): DocumentInterface;

    public function setContent(string $content): DocumentInterface;

    public function setDestinationPlace(?string $destinationPlace): DocumentInterface;

    public function setEntities(?array $entities): DocumentInterface;

    public function setFreeKeywords(?array $freeKeywords): DocumentInterface;

    public function setGndKeywords(?array $gndKeywords): DocumentInterface;

    public function setId(string $id): DocumentInterface;

    public function setImageUrl(?string $imageUrl): DocumentInterface;

    public function setInstitution(?string $institution): DocumentInterface;

    public function setLanguage(?array $language): DocumentInterface;

    public function setLicense(?string $license): DocumentInterface;

    public function setMetadata(array $metadata): DocumentInterface;

    public function setOriginDate(?string $originDate): DocumentInterface;

    public function setOriginPlace(?string $originPlace): DocumentInterface;

    public function setPageDates(?array $pageDates): DocumentInterface;

    public function setPageDatesIds(?array $pageDatesIds): DocumentInterface;

    public function setPageNotes(?array $pageNotes): DocumentInterface;

    public function setPageNotesIds(?array $pageNotesIds): DocumentInterface;

    public function setPageNotesAbstracts(?array $pageNotesAbstract): DocumentInterface;

    public function setPageNotesAbstractsIds(?array $pageNotesAbstractId): DocumentInterface;

    public function setPageWorks(?array $pageWorks): DocumentInterface;

    public function setPageWorksIds(?array $pageWorksIds): DocumentInterface;

    public function setPageEntities(?array $pageEntities): DocumentInterface;

    public function setPageEntitiesIds(?array $pageEntitiesIds): DocumentInterface;

    public function setPageEntitiesTypes(?array $pageEntitiesTypes): DocumentInterface;
    
    public function setPageNumber(?string $pageNumber): DocumentInterface;

    public function setPageFoliant(?string $pageFoliant): DocumentInterface;

    public function setPageAllAnnotationIds(?array $pageAllAnnotationIds): DocumentInterface;

    public function setPublishDate(?string $originDate): DocumentInterface;

    public function setPrintSource(?string $printSource): DocumentInterface;

    public function setRecipient(?string $recipient): DocumentInterface;

    public function setReferences(?array $reference): DocumentInterface;

    public function setRelatedItems(?array $related_items): DocumentInterface;

    public function setResponses(?array $response): DocumentInterface;

    public function setScriptSource(?string $script_source): DocumentInterface;

    public function setShelfmark(?string $shelfmark): DocumentInterface;

    public function setTitle(?string $title): DocumentInterface;

    public function setWriter(?array $writer): DocumentInterface;
}
