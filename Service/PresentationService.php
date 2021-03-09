<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Service;

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
                $manifestUrl = $this->mainDomain.$this->router->generate('subugoe_emo_manifest', ['id' => $document->getArticleId()]);
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

        $item->setContent($this->mainDomain.$this->router->generate('subugoe_emo_content', ['id' => $document->getId()]));

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
        $item->setContent($this->mainDomain.$this->router->generate('subugoe_emo_content', ['id' => $document->getId()]));

        return $item;
    }

    public function getManifest(DocumentInterface $document): Manifest
    {
        $manifest = new Manifest();
        $manifest->setId($this->mainDomain.$this->router->generate('subugoe_emo_manifest', ['id' => $document->getId()]));
        $manifest->setLabel($document->getTitle());
        $manifest->setMetadata($this->getMetadata($document));
        $manifest->setSequence($this->getSequence($document));
        $manifest->setSupport($this->getSupport());
        $manifest->setLicense($this->getLicense($document));

        return $manifest;
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
            $sequences[] = $sequence->setId($this->mainDomain.$this->router->generate('subugoe_emo_item_page', ['id' => $content->getFields()['id']]));
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
}
