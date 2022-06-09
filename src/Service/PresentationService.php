<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Service;

use Subugoe\EMOBundle\Model\Annotation\AnnotationCollection;
use Subugoe\EMOBundle\Model\Annotation\AnnotationPage;
use Subugoe\EMOBundle\Model\Annotation\Body;
use Subugoe\EMOBundle\Model\Annotation\Item as AnnotationItem;
use Subugoe\EMOBundle\Model\Annotation\PartOf;
use Subugoe\EMOBundle\Model\Annotation\Selector;
use Subugoe\EMOBundle\Model\Annotation\Target;
use Subugoe\EMOBundle\Model\DocumentInterface;
use Subugoe\EMOBundle\Model\Presentation\Content;
use Subugoe\EMOBundle\Model\Presentation\Image;
use Subugoe\EMOBundle\Model\Presentation\Item;
use Subugoe\EMOBundle\Model\Presentation\License;
use Subugoe\EMOBundle\Model\Presentation\Manifest;
use Subugoe\EMOBundle\Model\Presentation\Sequence;
use Subugoe\EMOBundle\Model\Presentation\Support;
use Subugoe\EMOBundle\Model\Presentation\Title;
use Subugoe\EMOBundle\Translator\TranslatorInterface as emoTranslator;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class PresentationService
{
    protected RequestStack $request;

    private Packages $assetsManager;

    private emoTranslator $emoTranslator;

    private string $mainDomain;

    private RouterInterface $router;

    private TranslatorInterface $translator;

    public function __construct(RouterInterface $router, TranslatorInterface $translator, RequestStack $requestStack, Packages $assetsManager, emoTranslator $emoTranslator)
    {
        $this->router = $router;
        $this->translator = $translator;
        $this->request = $requestStack;
        $this->assetsManager = $assetsManager;
        $this->emoTranslator = $emoTranslator;
    }

    public function getAnnotationCollection(DocumentInterface $document, string $type): array
    {
        $annotationCollection = new AnnotationCollection();

        if ('manifest' === $type) {
            $pages = $this->emoTranslator->getContentsById($document->getId());
            $firstPage = $pages[0]['id'];
            $lastPage = $pages[count($pages) - 1]['id'];
            $id = $document->getId();
            $title = $document->getTitle();
            $annotationCollection->setId($this->mainDomain.$this->router->generate('subugoe_tido_annotation_collection', ['id' => $document->getId()]));
        } else {
            $id = $document->getArticleId();
            $firstPage = $document->getId();
            $title = $document->getArticleTitle();
            $annotationCollection->setId($this->mainDomain.$this->router->generate('subugoe_tido_page_annotation_collection', ['id' => $id, 'page' => $firstPage]));
        }

        $annotationCollection->setLabel($title);
        $annotationCollection->setTotal($this->emoTranslator->getManifestTotalNumberOfAnnotations($id));
        $annotationCollection->setFirst($this->mainDomain.$this->router->generate('subugoe_tido_annotation_page', ['id' => $id, 'page' => $firstPage]));

        if ('manifest' === $type) {
            $annotationCollection->setLast($this->mainDomain.$this->router->generate('subugoe_tido_annotation_page', ['id' => $document->getId(), 'page' => $lastPage]));
        }

        return ['annotationCollection' => $annotationCollection];
    }

    public function getAnnotationPage(DocumentInterface $document, DocumentInterface $page): array
    {
        $annotationPage = new AnnotationPage();
        $annotationPage->setId($this->mainDomain.$this->router->generate('subugoe_tido_annotation_page', ['id' => $document->getId(), 'page' => $page->getId()]));
        $annotationPage->setPartOf($this->getPartOf($document));

        $nextPageNumber = $page->getPageNumber() + 1;

        if ($nextPageNumber <= (int) $document->getPageNumber()) {
            $pattern = 'page'.$page->getPageNumber();
            $replace = 'page'.$nextPageNumber;
            $nextPageId = str_replace($pattern, $replace, $page->getId());
            $next = $this->mainDomain.$this->router->generate('subugoe_tido_annotation_page', ['id' => $document->getId(), 'page' => $nextPageId]);
        }

        $annotationPage->setNext($next ?? null);

        if ($page->getPageNumber() >= 2) {
            $prevPageNumber = $page->getPageNumber() - 1;
            $pattern = 'page'.$page->getPageNumber();
            $replace = 'page'.$prevPageNumber;
            $prevPageId = str_replace($pattern, $replace, $page->getId());
            $prev = $this->mainDomain.$this->router->generate('subugoe_tido_annotation_page', ['id' => $document->getId(), 'page' => $prevPageId]);
        }

        $annotationPage->setPrev($prev ?? null);

        if (1 === (int) $page->getPageNumber()) {
            $startIndex = 0;
        } else {
            $startIndex = $this->emoTranslator->getItemAnnotationsStartIndex($document->getId(), (int) $page->getPageNumber());
        }

        $annotationPage->setStartIndex($startIndex);
        $annotationPage->setItems($this->getItems($page));

        return ['annotationPage' => $annotationPage];
    }

    public function getFull(DocumentInterface $document): Item
    {
        $item = new Item();

        if (!empty($document->getTitle())) {
            $item->setTitle($this->getTitle($document->getTitle(), 'main'));
        }

        if (!empty($document->getLanguage())) {
            $item->setLang($document->getLanguage());
        }

        $item->setType('full');
        $item->setContent($this->mainDomain.$this->router->generate('subugoe_tido_content', ['id' => $document->getId()]));

        return $item;
    }

    public function getImage(string $imageUrl, string $manifestUrl, string $imageLicense, string $imageLicenseLink): Image
    {
        $image = new Image();
        $image->setId($imageUrl);
        $image->setManifest($manifestUrl);
        $license = new License();
        $license->setId($imageLicense.' ('.$imageLicenseLink.')');
        $image->setLicense($license);

        return $image;
    }

    public function getItem(DocumentInterface $document): Item
    {
        $item = new Item();

        if ($document->getImageUrl()) {
            $imageUrl = explode('/', $document->getImageUrl());

            if (isset($imageUrl[0])) {
                $graph = $imageUrl[0];
            }

            if (isset($imageUrl[1])) {
                $archiveName = $imageUrl[1];
            }

            if (isset($imageUrl[2])) {
                $documentName = $imageUrl[2];
            }

            if (isset($imageUrl[3])) {
                $pageName = explode('.', $imageUrl[3])[0];
            }

            if (isset($graph, $archiveName, $documentName, $pageName) && 'Graph' === $graph && !empty($archiveName) && !empty($documentName) && !empty($pageName)) {
                $imageUrl = $this->mainDomain.$this->router->generate('_image', ['archive' => $archiveName, 'document' => $documentName, 'page_id' => $pageName]);
                $manifestUrl = $this->mainDomain.$this->router->generate('subugoe_tido_manifest', ['id' => $document->getArticleId()]);
                $item->setImage($this->getImage($imageUrl, $manifestUrl, $document->getImageLicense(), $document->getImageLicenseLink()));
            }
        }

        if (!empty($document->getArticleTitle())) {
            $title = new Title();
            $title->setTitle($document->getArticleTitle());
            $title->setType('main');
            $item->setTitle($title);
        }

        if (!empty($document->getLanguage())) {
            $item->setLang($document->getLanguage());
        }

        $item->setType('page');
        $item->setN($document->getPageNumber());
        $item->setContent($this->getContents($document->getId()));

        $item->setAnnotationCollection($this->mainDomain.$this->router->generate('subugoe_tido_page_annotation_collection', ['id' => 'Z_1822-06-21_k', 'page' => $document->getId()]));

        return $item;
    }

    public function getManifest(DocumentInterface $document): Manifest
    {
        $manifest = new Manifest();
        $manifest->setId($this->mainDomain.$this->router->generate('subugoe_tido_manifest', ['id' => $document->getId()]));
        $manifest->setLabel($document->getTitle());
        $manifest->setMetadata($this->getMetadata($document));
        $manifest->setSequence($this->getSequence($document));
        $manifest->setSupport($this->getSupport());
        $manifest->setLicense($this->getLicense($document));
        $manifest->setAnnotationCollection($this->mainDomain.$this->router->generate('subugoe_tido_annotation_collection', ['id' => $document->getId()]));

        return $manifest;
    }

    public function getTitle(?string $titleStr, ?string $type): Title
    {
        $title = new Title();

        if (!empty($titleStr)) {
            $title->setTitle($titleStr);
            $title->setType($type);
        }

        return $title;
    }

    public function setMainDomain(string $mainDomain): void
    {
        $this->mainDomain = $mainDomain;
    }

    private function getBody(string $value, string $type): Body
    {
        $body = new Body();
        $body->setValue($value);
        $body->setXContentType($type);

        return $body;
    }

    private function getContents(string $id): array
    {
        $contents = [];
        $content = new Content();
        $content->setUrl($this->mainDomain.$this->router->generate('subugoe_tido_content', ['id' => $id, 'flag' => '1']));
        $content->setType('text/html;type=Transkription');
        $contents[] = $content;

        $content = new Content();
        $content->setUrl($this->mainDomain.$this->router->generate('subugoe_tido_content', ['id' => $id]));
        $content->setType('text/html;type=Edierter Text');
        $contents[] = $content;

        return $contents;
    }

    private function getDateAnnotationBody(string $pageDate): Body
    {
        $body = new Body();
        $body->setValue($pageDate);
        $body->setXContentType('Date');

        return $body;
    }

    private function getAbstractAnnotationBody(string $pageAbstract): Body
    {
        $body = new Body();
        $body->setValue($pageAbstract);
        $body->setXContentType('Abstract');

        return $body;
    }

    private function getWorksAnnotationBody(string $pageWork): Body
    {
        $body = new Body();
        $body->setValue($pageWork);
        $body->setXContentType('Work');

        return $body;
    }

    private function getItems(DocumentInterface $document): array
    {
        $items = [];

        if (!empty($document->getPageNotesAbstracts())) {
            foreach ($document->getPageNotesAbstracts() as $key => $pageAbstract) {
                if (isset($document->getPageNotesAbstractsIds()[$key]) && !empty($document->getPageNotesAbstractsIds()[$key])) {
                    $item = new AnnotationItem();
                    $item->setBody($this->getAbstractAnnotationBody($pageAbstract));
                    $item->setTarget($this->getAbstractAnnotationTarget($document->getPageNotesAbstractsIds()[$key], $document->getId()));
                    $id = $this->createAnnotationId($document->getId(), $document->getPageNotesAbstractsIds()[$key]);
                    $item->setId($id);
                    $items[] = $item;
                }
            }
        }

        if (!empty($document->getPageEntities())) {
            foreach ($document->getPageEntities() as $key => $pageEntity) {
                $item = new AnnotationItem();
                $item->setBody($this->getBody($pageEntity, $document->getPageEntitiesTypes()[$key]));
                $item->setTarget($this->getTarget($document->getPageEntitiesIds()[$key], $document->getId()));
                $id = $this->createAnnotationId($document->getId(), $document->getAnnotationIds()[$key]);
                $item->setId($id);
                $items[] = $item;
            }
        }

        if (!empty($document->getPageNotes())) {
            foreach ($document->getPageNotes() as $key => $pageNote) {
                if (isset($document->getPageNotesIds()[$key]) && !empty($document->getPageNotesIds()[$key])) {
                    $item = new AnnotationItem();
                    $item->setBody($this->getNoteAnnotationBody($pageNote, $document->getPageNotes()[$key]));
                    $item->setTarget($this->getNoteAnnotationTarget($document->getPageNotesIds()[$key], $document->getId()));
                    $id = $this->createAnnotationId($document->getId(), $document->getPageNotesIds()[$key]);
                    $item->setId($id);
                    $items[] = $item;
                }
            }
        }

        if (!empty($document->getPageDates())) {
            foreach ($document->getPageDates() as $key => $pageDate) {
                if (isset($document->getPageDatesIds()[$key]) && !empty($document->getPageDatesIds()[$key])) {
                    $item = new AnnotationItem();
                    $item->setBody($this->getDateAnnotationBody($pageDate));
                    $item->setTarget($this->getTarget($document->getPageDatesIds()[$key], $document->getId()));
                    $id = $this->createAnnotationId($document->getId(), $document->getPageDatesIds()[$key]);
                    $item->setId($id);
                    $items[] = $item;
                }
            }
        }

        if (!empty($document->getPageWorks())) {
            foreach ($document->getPageWorks() as $key => $pageWork) {
                if (isset($document->getPageWorksIds()[$key]) && !empty($document->getPageWorksIds()[$key])) {
                    $item = new AnnotationItem();
                    $item->setBody($this->getWorksAnnotationBody($pageWork));
                    $item->setTarget($this->getTarget($document->getPageWorksIds()[$key], $document->getId()));
                    $id = $this->createAnnotationId($document->getId(), $document->getPageWorksIds()[$key]);
                    $item->setId($id);
                    $items[] = $item;
                }
            }
        }

        // Sort items according to page_all_annotation_ids
        uasort($items, function (AnnotationItem $a, AnnotationItem $b) use ($document) {
            $sortingIndexA = 0;
            $sortingIndexB = 0;
            foreach ($document->getPageAllAnnotationIds() as $index => $solrId) {
                $tempAnnotationId = $this->createAnnotationId($document->getId(), $solrId);

                if ($a->getId() === $tempAnnotationId) {
                    $sortingIndexA = $index;
                } elseif($b->getId() === $tempAnnotationId) {
                    $sortingIndexB = $index;
                }
            }

            if ($sortingIndexA < $sortingIndexB) {
                return -1;
            } else {
                return 1;
            }
        });

        // uasort doesn't set the correct index keys, so we  have to fix this
        $items = array_values($items);

        return $items;
    }


    private function createAnnotationId(string $documentId, string $solrId) {
        return $this->mainDomain.'/'.$documentId.'/'.$solrId;
    }

    private function getLicense(DocumentInterface $document): array
    {
        $licenses = [];
        $license = new License();
        $licenses[] = $license->setId($document->getLicense());

        return $licenses;
    }

    private function getMetadata(DocumentInterface $document): array
    {
        if (null !== $document->getAuthor()) {
            $metadata[] = ['key' => $this->translator->trans('Author', [], 'messages'), 'value' => $document->getAuthor()];
        }

        if (null !== $document->getPublishDate()) {
            $metadata[] = ['key' => $this->translator->trans('Publish_Date', [], 'messages'), 'value' => $document->getPublishDate()];
        }

        if (null !== $document->getOriginPlace()) {
            $metadata[] = ['key' => $this->translator->trans('Origin_Place', [], 'messages'), 'value' => $document->getOriginPlace()];
        }

        if (null !== $document->getRecipient()) {
            $metadata[] = ['key' => $this->translator->trans('Recipient', [], 'messages'), 'value' => $document->getRecipient()];
        }

        if (null !== $document->getDestinationPlace()) {
            $metadata[] = ['key' => $this->translator->trans('Destination_Place', [], 'messages'), 'value' => $document->getDestinationPlace()];
        }

        if (null !== $document->getInstitution()) {
            $metadata[] = ['key' => $this->translator->trans('Institution', [], 'messages'), 'value' => $document->getInstitution()];
        }

        if (null !== $document->getShelfmark()) {
            $metadata[] = ['key' => $this->translator->trans('Shelfmark', [], 'messages'), 'value' => $document->getShelfmark()];
        }

        if (null !== $document->getScriptSource()) {
            $metadata[] = ['key' => $this->translator->trans('Script_Source', [], 'messages'), 'value' => $document->getScriptSource()];
        }

        if (null !== $document->getWriter()) {
            if (is_array($document->getWriter()) && !empty($document->getWriter())) {
                $writers = implode('<br> ', $document->getWriter());
            }

            $metadata[] = ['key' => $this->translator->trans('Writer', [], 'messages'), 'value' => $writers];
        }

        if (null !== $document->getReferences()) {
            $metadata[] = [
                'key' => $this->translator->trans('Reference', [], 'messages'),
                'value' => '',
                'metadata' => array_map(function ($item) {
                    return json_decode($item);
                }, $document->getReferences())
            ];
        }

        if (null !== $document->getResponses()) {
            $metadata[] = [
                'key' => $this->translator->trans('Response', [], 'messages'),
                'value' => '',
                'metadata' => array_map(function ($item) {
                    return json_decode($item);
                }, $document->getResponses())
            ];
        }

        if (null !== $document->getRelatedItems()) {
            $metadata[] = [
                'key' => $this->translator->trans('Related_Items', [], 'messages'),
                'value' => '',
                'metadata' => array_map(function ($item) {
                    return json_decode($item);
                }, $document->getRelatedItems())
            ];
        }

        if (null !== $document->getGndKeywords()) {
            $metadata[] = ['key' => $this->translator->trans('Keywords_gnd', [], 'messages'), 'value' => implode('; ', $document->getGndKeywords())];
        }

        if (null !== $document->getFreeKeywords()) {
            $metadata[] = ['key' => $this->translator->trans('Keywords_free', [], 'messages'), 'value' => implode('; ', $document->getFreeKeywords())];
        }

        $teiDocumentLink = $this->mainDomain.$this->router->generate('_teifile', ['filename' => $document->getId()]);
        $metadata[] = ['key' => $this->translator->trans('TEI document', [], 'messages'), 'value' => 'via REST ('.$teiDocumentLink.')'];

        return $metadata;
    }

    private function getNoteAnnotationBody(string $pageNote): Body
    {
        $body = new Body();
        $body->setValue($pageNote);
        $body->setXContentType('Editorial Comment');

        return $body;
    }

    private function getNoteAnnotationTarget($annotationId, $documentId): Target
    {
        $target = new Target();
        $id = $this->mainDomain.'/'.$documentId.'/'.$annotationId;
        $target->setId($id);

        $selector = new Selector();
        $selector->setType('CssSelector');
        $selector->setValue('#'.$annotationId);
        $target->setSelector($selector);

        $target->setFormat('text/xml');
        $target->setLanguag('ger');

        return $target;
    }

    private function getPartOf(DocumentInterface $document): PartOf
    {
        $partOf = new PartOf();
        $partOf->setId($this->mainDomain.$this->router->generate('subugoe_tido_annotation_collection', ['id' => $document->getId()]));
        $partOf->setLabel('Annotations for GFL '.$document->getId().': '.$document->getTitle());
        $partOf->setTotal($this->emoTranslator->getManifestTotalNumberOfAnnotations($document->getId()));

        return $partOf;
    }

    private function getSequence(DocumentInterface $document): array
    {
        $sequences = [];
        $contents = $this->emoTranslator->getContentsById($document->getId());

        foreach ($contents as $content) {
            $sequence = new Sequence();
            $sequences[] = $sequence->setId($this->mainDomain.$this->router->generate('subugoe_tido_item_page', ['id' => $content->getFields()['id']]));
        }

        return $sequences;
    }

    private function getSupport(): array
    {
        $supports = [];
        $support = new Support();
        $supports[] = $support->setUrl($this->mainDomain.$this->assetsManager->getUrl('build/support.css'));

        return $supports;
    }

    private function getAbstractAnnotationTarget($annotationId, $documentId): Target
    {
        $target = new Target();

        $target->setId($this->mainDomain.'/'.$documentId.'/'.$annotationId);

        $target->setFormat('text/xml');
        $target->setLanguag('ger');

        return $target;
    }

    private function getTarget($annotationId, $documentId): Target
    {
        $target = new Target();

        $target->setId($this->mainDomain.'/'.$documentId.'/'.$annotationId);

        $selector = new Selector();
        $selector->setType('CssSelector');
        $selector->setValue('#'.$annotationId);
        $target->setSelector($selector);

        $target->setFormat('text/xml');
        $target->setLanguag('ger');

        return $target;
    }
}
