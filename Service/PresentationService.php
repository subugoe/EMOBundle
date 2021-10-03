<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Service;

use Subugoe\EMOBundle\Model\Annotation\AnnotationCollection;
use Subugoe\EMOBundle\Model\Annotation\AnnotationPage;
use Subugoe\EMOBundle\Model\Annotation\Body;
use Subugoe\EMOBundle\Model\Annotation\PartOf;
use Subugoe\EMOBundle\Model\Annotation\Target;
use Subugoe\EMOBundle\Model\Presentation\Content;
use Subugoe\EMOBundle\Model\Presentation\Image;
use Subugoe\EMOBundle\Model\Presentation\License;
use Subugoe\EMOBundle\Model\Presentation\Manifest;
use Subugoe\EMOBundle\Model\Presentation\Item;
use Subugoe\EMOBundle\Model\Presentation\Sequence;
use Subugoe\EMOBundle\Model\Presentation\Support;
use Subugoe\EMOBundle\Model\Presentation\Title;
use Symfony\Component\Routing\RouterInterface;
use Subugoe\EMOBundle\Model\DocumentInterface;
use Subugoe\EMOBundle\Translator\TranslatorInterface as emoTranslator;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Asset\Packages;
use Subugoe\EMOBundle\Model\Annotation\Item as AnnotationItem;

class PresentationService
{
    private RouterInterface $router;
    private TranslatorInterface $translator;
    protected RequestStack $request;
    private Packages $assetsManager;
    private emoTranslator $emoTranslator;
    private string $mainDomain;

    public function __construct(RouterInterface $router, TranslatorInterface $translator, RequestStack $requestStack, Packages $assetsManager, emoTranslator $emoTranslator)
    {
        $this->router = $router;
        $this->translator = $translator;
        $this->request = $requestStack;
        $this->assetsManager = $assetsManager;
        $this->emoTranslator = $emoTranslator;
    }

    public function setMainDomain(string $mainDomain)
    {
        $this->mainDomain = $mainDomain;
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

            if ((isset($graph) && 'Graph' === $graph) && (isset($archiveName) && !empty($archiveName)) && (isset($documentName) && !empty($documentName)) && (isset($pageName) && !empty($pageName))) {
                $imageUrl = $this->mainDomain.$this->router->generate('_image', ['archive' => $archiveName, 'document' => $documentName, 'page_id' => $pageName]);
                $manifestUrl = $this->mainDomain.$this->router->generate('subugoe_tido_manifest', ['id' => $document->getArticleId()]);
                $item->setImage($this->getImage($imageUrl, $manifestUrl));
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

    private function getLicense(DocumentInterface $document): array
    {
        $licenses = [];
        $license = new License();
        $licenses[] = $license->setId($document->getLicense());

        return $licenses;
    }

    private function getSupport(): array
    {
        $supports = [];
        $support = new Support();
        $supports[] = $support->setUrl($this->mainDomain.$this->assetsManager->getUrl('build/support.css'));

        return $supports;
    }

    private function getSequence(DocumentInterface $document): array
    {
        $sequences = [];
        $contents = $this->emoTranslator->getContentsById($document->getId());

        foreach ($contents as $content) {
            $sequence = new Sequence();
            $sequences[] = $sequence->setId($this->mainDomain . $this->router->generate('subugoe_tido_item_page', ['id' => $content->getFields()['id']]));
        }

        return $sequences;
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
                $writers = implode('; ', $document->getWriter());
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
            if (is_array($document->getRelatedItems()) && !empty($document->getRelatedItems())) {
                $relatedItems = implode('; ', $document->getRelatedItems());
            }

            $metadata[] = ['key' => $this->translator->trans('Related_Items', [], 'messages'), 'value' => $relatedItems];
        }

        if (null !== $document->getGndKeywords()) {
            $metadata[] = ['key' => $this->translator->trans('Keywords_gnd', [], 'messages'), 'value' => implode('; ', $document->getGndKeywords())];
        }

        if (null !== $document->getFreeKeywords()) {
            $metadata[] = ['key' => $this->translator->trans('Keywords_free', [], 'messages'), 'value' => implode('; ', $document->getFreeKeywords())];
        }

        return $metadata;
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

    public function getImage(string $imageUrl, string $manifestUrl): Image
    {
        $image = new Image();
        $image->setId($imageUrl);
        $image->setManifest($manifestUrl);

        return $image;
    }

    public function getAnnotationCollection(DocumentInterface $document, string $type): array
    {
        $annotationCollection = new AnnotationCollection();

        if ('manifest' === $type) {
            $pages = $this->emoTranslator->getContentsById($document->getId());
            $firstPage = $pages[0]['id'];
            $lastPage = $pages[count($pages)-1]['id'];
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
        $annotationCollection->setTotal($this->emoTranslator->getManifestTotalNumerOfAnnotations($id));
        $annotationCollection->setFirst($this->mainDomain.$this->router->generate('subugoe_tido_annotation_page', ['id' => $id, 'page' => $firstPage]));

        if ('manifest' === $type) {
            $annotationCollection->setLast($this->mainDomain . $this->router->generate('subugoe_tido_annotation_page', ['id' => $document->getId(), 'page' => $lastPage]));
        }

        return ['annotationCollection' => $annotationCollection];
    }

    public function getAnnotationPage(DocumentInterface $document, DocumentInterface $page): array
    {
        $annotationPage = new AnnotationPage();
        $annotationPage->setId($this->mainDomain.$this->router->generate('subugoe_tido_annotation_page', ['id' => $document->getId(), 'page' => $page->getId()]));
        $annotationPage->setPartOf($this->getPartOf($document));

        $nextPageNumber = $page->getPageNumber() + 1;

        if ($nextPageNumber <= intval($document->getPageNumber())) {
            $pattern = 'page'.$page->getPageNumber();
            $replace = 'page'.$nextPageNumber;
            $nextPageId = str_replace($pattern, $replace, $page->getId());
            $next = $this->mainDomain.$this->router->generate('subugoe_tido_annotation_page', ['id' => $document->getId(), 'page' => $nextPageId]);
        }

        $annotationPage->setNext(isset($next) ? $next:null);

        if ($page->getPageNumber() >= 2) {
            $prevPageNumber = $page->getPageNumber() - 1;
            $pattern = 'page'.$page->getPageNumber();
            $replace = 'page'.$prevPageNumber;
            $prevPageId = str_replace($pattern, $replace, $page->getId());
            $prev = $this->mainDomain.$this->router->generate('subugoe_tido_annotation_page', ['id' => $document->getId(), 'page' => $prevPageId]);
        }

        $annotationPage->setPrev(isset($prev) ? $prev:null);

        if (1 == $page->getPageNumber()) {
            $startIndex = 0;
        } else {
            $startIndex = $this->emoTranslator->getItemAnnotationsStartIndex($document->getId(), intval($page->getPageNumber()));
        }

        $annotationPage->setStartIndex($startIndex);
        $annotationPage->setItems($this->getItems($page));

        return ['annotationPage' => $annotationPage];
    }

    private function getPartOf(DocumentInterface $document)
    {
        $partOf = new PartOf();
        $partOf->setId($this->mainDomain.$this->router->generate('subugoe_tido_annotation_collection', ['id' => $document->getId()]));
        $partOf->setLabel('Annotations for GFL '.$document->getId().': '.$document->getTitle());
        $partOf->setTotal($this->emoTranslator->getManifestTotalNumerOfAnnotations($document->getId()));

        return $partOf;
    }

    private function getItems(DocumentInterface $document)
    {
        $items = [];

        if (!empty($document->getEntities())) {
            foreach ($document->getEntities() as $key => $entityGnd) {
                $item = new AnnotationItem();
                $item->setBody($this->getBody($entityGnd));
                $item->setTarget($this->getTarget($document->getAnnotationIds()[$key], $document->getId()));
                $id = $this->mainDomain . '/' . $document->getId() . '/annotation-' . $document->getAnnotationIds()[$key];
                $item->setId($id);
                $items[] = $item;
            }
        }

        if (!empty($document->getPageNotes())) {
            foreach ($document->getPageNotes() as $key => $pageNote) {
                if (!empty($pageNote) && (isset($document->getPageNotesIds()[$key]) && !empty($document->getPageNotesIds()[$key]))) {
                    $item = new AnnotationItem();
                    $item->setBody($this->getNoteAnnotationBody($pageNote, $document->getPageSegs()[$key]));
                    $item->setTarget($this->getNoteAnnotationTarget($document->getPageNotesIds()[$key], $document->getId() ));
                    $id = $this->mainDomain . '/' . $document->getId() . '/annotation-' . $document->getPageNotesIds()[$key];
                    $item->setId($id);
                    $items[] = $item;
                }
            }
        }

        return $items;
    }

    private function getNoteAnnotationBody(string $pageNote, string $pageSeg): Body
    {
        $body = new Body();
        $body->setValue($this->getLemmatizedNote($pageNote, $pageSeg));
        $body->setXContentType('Editorial Comment');

        return $body;
    }

    private function getNoteAnnotationTarget($annotationId, $documentId): Target
    {
        $target = new Target();
        $id = $this->mainDomain . '/' . $documentId . '/' . $annotationId;
        $target->setId($id);
        $target->setFormat('text/xml');
        $target->setLanguag('ger');

        return $target;
    }

    private function getBody(string $entityGnd): Body
    {
        $entity = $this->emoTranslator->getEntity($entityGnd);

        $body = new Body();
        $body->setValue($entity['mostly_used_name']);
        $body->setXContentType(ucfirst($entity['entitytype']));

        return $body;
    }

    private function getTarget($annotationId, $documentId): Target
    {
        $target = new Target();
        $id = $this->mainDomain.'/'.$documentId.'/'.$annotationId;
        $target->setId($id);
        $target->setFormat('text/xml');
        $target->setLanguag('ger');

        return $target;
    }

    private function getLemmatizedNote(string $note, string $pageSeg): string
    {
        $noteAnnotation = $pageSeg;
        $wordsCountInPageSeg = explode(' ', $pageSeg);

        if (!empty($wordsCountInPageSeg) && 2 < count($wordsCountInPageSeg)) {
            $firstWord = $wordsCountInPageSeg[0];
            $lastWord = array_reverse($wordsCountInPageSeg)[0];
            $noteAnnotation = $firstWord.' ... '.$lastWord;
        }

        $noteAnnotation = $noteAnnotation.']'.' '.$note;

        return $noteAnnotation;
    }
}
