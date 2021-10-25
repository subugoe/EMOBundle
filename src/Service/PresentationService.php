<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Service;

use Subugoe\EMOBundle\Model\Annotation\AnnotationCollection;
use Subugoe\EMOBundle\Model\Annotation\AnnotationPage;
use Subugoe\EMOBundle\Model\Annotation\Body;
use Subugoe\EMOBundle\Model\Annotation\Item as AnnotationItem;
use Subugoe\EMOBundle\Model\Annotation\PartOf;
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

    private string $mainDomain = '';

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
        $lastPage = 0;
        if ('manifest' === $type) {
            $pages = $this->emoTranslator->getContentsById((string) $document->getId());
            $firstPage = $pages[0]['id'];
            $lastPage = $pages[count($pages) - 1]['id'];
            $id = (string) $document->getId();
            $title = $document->getTitle();
            $annotationCollection->setId($this->mainDomain.$this->router->generate('subugoe_tido_annotation_collection', ['id' => $document->getId()]));
        } else {
            $id = (string) $document->getArticleId();
            $firstPage = $document->getId();
            $title = $document->getArticleTitle();
            $annotationCollection->setId($this->mainDomain.$this->router->generate('subugoe_tido_page_annotation_collection', ['id' => $id, 'page' => $firstPage]));
        }

        $annotationCollection->setLabel((string) $title);
        $annotationCollection->setTotal($this->emoTranslator->getManifestTotalNumberOfAnnotations($id));
        $annotationCollection->setFirst($this->mainDomain.$this->router->generate('subugoe_tido_annotation_page', ['id' => $id, 'page' => $firstPage]));

        if ('manifest' === $type) {
            $annotationCollection->setLast($this->mainDomain.$this->router->generate(
                'subugoe_tido_annotation_page',
                [
                    'id' => $document->getId(),
                    'page' => $lastPage,
                ]));
        }

        return ['annotationCollection' => $annotationCollection];
    }

    public function getAnnotationPage(DocumentInterface $document, DocumentInterface $page): array
    {
        $id = (string) $document->getId();
        $pageId = (string) $page->getId();
        $pageNumber = (int) $page->getPageNumber();
        $annotationPage = new AnnotationPage();
        $annotationPage->setId($this->mainDomain.$this->router->generate('subugoe_tido_annotation_page', ['id' => $id, 'page' => $page->getId()]));
        $annotationPage->setPartOf($this->getPartOf($document));

        $nextPageNumber = $pageNumber + 1;

        if ($nextPageNumber <= $pageNumber) {
            $pattern = 'page'.$pageNumber;
            $replace = 'page'.$nextPageNumber;
            $nextPageId = str_replace($pattern, $replace, $pageId);
            $next = $this->mainDomain.$this->router->generate('subugoe_tido_annotation_page', ['id' => $id, 'page' => $nextPageId]);
        }

        $annotationPage->setNext($next ?? null);

        if ($page->getPageNumber() >= 2) {
            $prevPageNumber = $pageNumber - 1;
            $pattern = 'page'.$pageNumber;
            $replace = 'page'.$prevPageNumber;
            $prevPageId = str_replace($pattern, $replace, $pageId);
            $prev = $this->mainDomain.$this->router->generate('subugoe_tido_annotation_page', ['id' => $id, 'page' => $prevPageId]);
        }

        $annotationPage->setPrev($prev ?? null);

        if (1 === $pageNumber) {
            $startIndex = 0;
        } else {
            $startIndex = $this->emoTranslator->getItemAnnotationsStartIndex($id, $pageNumber);
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

        $documentLangugage = $document->getLanguage();
        if (null !== $documentLangugage) {
            $item->setLang($documentLangugage);
        }

        $item->setType('full');
        $item->setContent([$this->mainDomain.$this->router->generate('subugoe_tido_content', ['id' => $document->getId()])]);

        return $item;
    }

    public function getImage(string $imageUrl, string $manifestUrl): Image
    {
        $image = new Image();
        $image->setId($imageUrl);
        $image->setManifest($manifestUrl);

        return $image;
    }

    public function getItem(DocumentInterface $document): Item
    {
        $item = new Item();

        $documentImageUrl = $document->getImageUrl();

        if (null !== $documentImageUrl) {
            $imageUrl = explode('/', $documentImageUrl);

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
                $item->setImage($this->getImage($imageUrl, $manifestUrl));
            }
        }

        $documentArticleTitle = $document->getArticleTitle();
        if (null !== $documentArticleTitle) {
            $title = new Title();
            $title->setTitle($documentArticleTitle);
            $title->setType('main');
            $item->setTitle($title);
        }

        $documentLanguage = $document->getLanguage();
        if (null !== $documentLanguage) {
            $item->setLang($documentLanguage);
        }

        $item->setType('page');
        $item->setN($document->getPageNumber());
        $item->setContent($this->getContents((string) $document->getId()));

        $item->setAnnotationCollection($this->mainDomain.$this->router->generate('subugoe_tido_page_annotation_collection', ['id' => 'Z_1822-06-21_k', 'page' => $document->getId()]));

        return $item;
    }

    public function getManifest(DocumentInterface $document): Manifest
    {
        $manifest = new Manifest();
        $manifest->setId($this->mainDomain.$this->router->generate('subugoe_tido_manifest', ['id' => $document->getId()]));
        $manifest->setLabel((string) $document->getTitle());
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
            $title->setType($type ?? '');
        }

        return $title;
    }

    public function setMainDomain(string $mainDomain): void
    {
        $this->mainDomain = $mainDomain;
    }

    private function addPageSicAnnotationItems(DocumentInterface $document, string $documentId, array $items): array
    {
        $pageSics = $document->getPageSics();
        $pageSicsIds = $document->getPageSicsIds();

        if (null !== $pageSics && null !== $pageSicsIds) {
            foreach ($pageSics as $key => $pageSic) {
                if (array_key_exists($key, $pageSicsIds)) {
                    $pageSicsId = $pageSicsIds[$key];
                    if (isset($pageSicsId) && !empty($pageSicsId)) {
                        $item = new AnnotationItem();
                        $item->setBody($this->getSicAnnotationBody($pageSic));
                        $item->setTarget($this->getSicAnnotationTarget($pageSicsId, $documentId));
                        $id = $this->mainDomain.'/'.$documentId.'/annotation-'.$pageSicsId;
                        $item->setId($id);
                        $items[] = $item;
                    }
                }
            }
        }

        return $items;
    }

    private function getBody(string $entityGnd): Body
    {
        $entity = $this->emoTranslator->getEntity($entityGnd);

        $body = new Body();
        $body->setValue($entity['mostly_used_name']);
        $body->setXContentType(ucfirst($entity['entitytype']));

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

    private function getEntityAnnotationItems(DocumentInterface $document, string $documentId, array $items): array
    {
        $documentEntities = $document->getEntities();

        if (null !== $documentEntities) {
            $annotationIds = $document->getAnnotationIds();

            if (null !== $annotationIds) {
                foreach ($documentEntities as $key => $entityGnd) {
                    $item = new AnnotationItem();
                    $item->setBody($this->getBody($entityGnd));
                    $item->setTarget($this->getTarget($annotationIds[$key], $documentId));
                    $id = $this->mainDomain.'/'.$documentId.'/annotation-'.$annotationIds[$key];
                    $item->setId($id);
                    $items[] = $item;
                }
            }
        }

        return $items;
    }

    private function getItems(DocumentInterface $document): array
    {
        $items = [];
        $documentId = (string) $document->getId();

        $items = $this->getEntityAnnotationItems($document, $documentId, $items);
        $items = $this->getPageNotesAnnotationItems($document, $documentId, $items);
        $items = $this->addPageSicAnnotationItems($document, $documentId, $items);

        return $this->getPageDatesAnnotationItems($document, $documentId, $items);
    }

    private function getLemmatizedNote(string $note, string $pageSeg): string
    {
        $noteAnnotation = $pageSeg;
        $wordsCountInPageSeg = explode(' ', $pageSeg);

        if ('' !== $note && 2 < count($wordsCountInPageSeg)) {
            $firstWord = $wordsCountInPageSeg[0];
            $lastWord = array_reverse($wordsCountInPageSeg)[0];
            $noteAnnotation = $firstWord.' ... '.$lastWord;
        }

        if (!empty(trim($note))) {
            $noteAnnotation .= '] '.$note;
        }

        return $noteAnnotation;
    }

    private function getLicense(DocumentInterface $document): array
    {
        $licenses = [];
        $license = new License();
        $licenses[] = $license->setId((string) $document->getLicense());

        return $licenses;
    }

    private function getMetadata(DocumentInterface $document): array
    {
        $metadata = [];

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
            $writers = $document->getWriter();
            if (is_array($writers) && !empty($writers)) {
                $writers = implode('; ', $writers);
            }

            $metadata[] = ['key' => $this->translator->trans('Writer', [], 'messages'), 'value' => $writers];
        }

        if (null !== $document->getReference()) {
            $metadata[] = ['key' => $this->translator->trans('Reference', [], 'messages'), 'value' => $document->getReference()];
        }

        if (null !== $document->getResponse()) {
            $metadata[] = ['key' => $this->translator->trans('Response', [], 'messages'), 'value' => $document->getResponse()];
        }

        if (null !== $document->getRelatedItems()) {
            $relatedItems = $document->getRelatedItems();
            if (is_array($document->getRelatedItems()) && !empty($document->getRelatedItems())) {
                $relatedItems = implode('; ', $document->getRelatedItems() ?? []);
            }

            $metadata[] = ['key' => $this->translator->trans('Related_Items', [], 'messages'), 'value' => $relatedItems];
        }

        if (null !== $document->getGndKeywords()) {
            $metadata[] = ['key' => $this->translator->trans('Keywords_gnd', [], 'messages'), 'value' => implode('; ', $document->getGndKeywords() ?? [])];
        }

        if (null !== $document->getFreeKeywords()) {
            $metadata[] = ['key' => $this->translator->trans('Keywords_free', [], 'messages'), 'value' => implode('; ', $document->getFreeKeywords() ?? [])];
        }

        return $metadata;
    }

    private function getNoteAnnotationBody(string $pageNote, string $pageSeg): Body
    {
        $body = new Body();
        $body->setValue($this->getLemmatizedNote($pageNote, $pageSeg));
        $body->setXContentType('Editorial Comment');

        return $body;
    }

    private function getNoteAnnotationTarget(string $annotationId, string $documentId): Target
    {
        $target = new Target();
        $id = $this->mainDomain.'/'.$documentId.'/'.$annotationId;
        $target->setId($id);
        $target->setFormat('text/xml');
        $target->setLanguag('ger');

        return $target;
    }

    private function getPageDatesAnnotationItems(DocumentInterface $document, string $documentId, array $items): array
    {
        $pageDates = $document->getPageDates();
        if (null !== $pageDates) {
            foreach ($pageDates as $key => $pageDate) {
                $documentPageDateIds = $document->getPageDatesIds() ?? [];
                if (array_key_exists($key, $documentPageDateIds)) {
                    $pageDateId = $documentPageDateIds[$key];
                    if (isset($pageDateId) && !empty($pageDateId)) {
                        $item = new AnnotationItem();
                        $item->setBody($this->getDateAnnotationBody($pageDate));
                        $item->setTarget($this->getTarget($pageDateId, $documentId));
                        $id = $this->mainDomain.'/'.$documentId.'/annotation-'.$pageDateId;
                        $item->setId($id);
                        $items[] = $item;
                    }
                }
            }
        }

        return $items;
    }

    private function getPageNotesAnnotationItems(DocumentInterface $document, string $documentId, array $items): array
    {
        $pageNotes = $document->getPageNotes();
        if (null !== $pageNotes) {
            foreach ($pageNotes as $key => $pageNote) {
                $pageNoteIds = $document->getPageNotesIds() ?? [];
                if (array_key_exists($key, $pageNoteIds)) {
                    $pageNoteId = $pageNoteIds[$key];

                    if (isset($pageNoteId) && !empty($pageNoteId)) {
                        $item = new AnnotationItem();
                        $item->setBody($this->getNoteAnnotationBody($pageNote, $document->getPageSegs()[$key] ?? ''));
                        $item->setTarget($this->getNoteAnnotationTarget($pageNoteId, $documentId));
                        $id = $this->mainDomain.'/'.$documentId.'/annotation-'.$pageNoteId;
                        $item->setId($id);
                        $items[] = $item;
                    }
                }
            }
        }

        return $items;
    }

    private function getPartOf(DocumentInterface $document): PartOf
    {
        $documentId = (string) $document->getId();
        $partOf = new PartOf();
        $partOf->setId($this->mainDomain.$this->router->generate('subugoe_tido_annotation_collection', ['id' => $documentId]));
        // @TODO remove reference to GFL
        $partOf->setLabel('Annotations for GFL '.$documentId.': '.$document->getTitle());
        $partOf->setTotal($this->emoTranslator->getManifestTotalNumberOfAnnotations($documentId));

        return $partOf;
    }

    private function getSequence(DocumentInterface $document): array
    {
        $sequences = [];
        $contents = $this->emoTranslator->getContentsById((string) $document->getId());

        foreach ($contents as $content) {
            $sequence = new Sequence();
            $sequences[] = $sequence->setId($this->mainDomain.$this->router->generate('subugoe_tido_item_page', ['id' => $content->getFields()['id']]));
        }

        return $sequences;
    }

    private function getSicAnnotationBody(string $pageSic): Body
    {
        $body = new Body();
        $body->setValue($pageSic);
        $body->setXContentType('Editorial Comment');

        return $body;
    }

    private function getSicAnnotationTarget(string $annotationId, string $documentId): Target
    {
        $target = new Target();
        $id = $this->mainDomain.'/'.$documentId.'/'.$annotationId;
        $target->setId($id);
        $target->setFormat('text/xml');
        $target->setLanguag('ger');

        return $target;
    }

    private function getSupport(): array
    {
        $supports = [];
        $support = new Support();
        $supports[] = $support->setUrl($this->mainDomain.$this->assetsManager->getUrl('build/support.css'));

        return $supports;
    }

    private function getTarget(string $annotationId, string $documentId): Target
    {
        $target = new Target();
        $id = $this->mainDomain.'/'.$documentId.'/'.$annotationId;
        $target->setId($id);
        $target->setFormat('text/xml');
        $target->setLanguag('ger');

        return $target;
    }
}
