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
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var RequestStack
     */
    protected $request;

    /**
     * @var Packages
     */
    private $assetsManager;

    /**
     * @var emoTranslator
     */
    private $emoTranslator;

    public function __construct(RouterInterface $router, TranslatorInterface $translator, RequestStack $requestStack, Packages $assetsManager, emoTranslator $emoTranslator)
    {
        $this->router = $router;
        $this->translator = $translator;
        $this->request = $requestStack;
        $this->assetsManager = $assetsManager;
        $this->emoTranslator = $emoTranslator;
    }

    public function getItem(DocumentInterface $document): Item
    {
        $item = new Item();

        if ($document->getImageUrl()) {
            [$graph, $archiveName, $documentName, $image] = explode('/', $document->getImageUrl());
            $pageName = explode('.', $image)[0];

            if ((isset($graph) && 'Graph' === $graph) && (isset($archiveName) && !empty($archiveName)) && (isset($documentName) && !empty($documentName)) && (isset($pageName) && !empty($pageName))) {
                $imageUrl = $this->router->generate('_image', ['archive' => $archiveName, 'document' => $documentName, 'page_id' => $pageName], RouterInterface::ABSOLUTE_URL);
                $articleId = $this->emoTranslator->getManifestUrlByPageId($document->getId());
                $manifestUrl = $this->router->generate('subugoe_emo_manifest', ['id' => $articleId], RouterInterface::ABSOLUTE_URL);
                $item->setImage($this->getImage($imageUrl, $manifestUrl));
            }
        }

        if (!empty($document->getTitle())) {
            $item->setTitle($this->getTitle($document->getTitle(), 'main'));
        }

        if (!empty($document->getLanguage())) {
            $item->setLanguage($document->getLanguage());
        }

        $item->setType('page');
        $item->setContent($this->router->generate('subugoe_emo_content', ['id' => $document->getId()], RouterInterface::ABSOLUTE_URL));

        return $item;
    }

    public function getFull(DocumentInterface $document): Item
    {
        $item = new Item();

        if (!empty($document->getTitle())) {
            $item->setTitle($this->getTitle($document->getTitle(), 'main'));
        }

        if (!empty($document->getLanguage())) {
            $item->setLanguage($document->getLanguage());
        }

        $item->setType('full');
        $item->setContent($this->router->generate('subugoe_emo_content', ['id' => $document->getId()], RouterInterface::ABSOLUTE_URL));

        return $item;
    }

    public function getManifest(DocumentInterface $document): Manifest
    {
        $manifest = new Manifest();
        $manifest->setId($this->router->generate('subugoe_emo_manifest', ['id' => $document->getId()], RouterInterface::ABSOLUTE_URL));
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
        $supports[] = $support->setUrl($this->request->getCurrentRequest()->getSchemeAndHttpHost().$this->assetsManager->getUrl('build/support.css'));

        return $supports;
    }

    private function getSequence(DocumentInterface $document): array
    {
        $sequences = [];

        $sequence = new Sequence();
        $sequences[] = $sequence->setId($this->router->generate('subugoe_emo_item_full', ['id' => $document->getId()], RouterInterface::ABSOLUTE_URL));

        $contents = $this->emoTranslator->getContentsById($document->getId());

        foreach ($contents as $content) {
            $sequence = new Sequence();
            $sequences[] = $sequence->setId($this->router->generate('subugoe_emo_item_page', ['id' => $content->getFields()['id']], RouterInterface::ABSOLUTE_URL));
        }

        return $sequences;
    }

    private function getMetadata(DocumentInterface $document): array
    {
        if (null !== $document->getAuthor()) {
            $metadata[] = ['key' => $this->translator->trans('Author', [], 'messages'), 'value' => $document->getAuthor()];
        }

        if (null !== $document->getRecipient()) {
            $metadata[] = [$this->translator->trans('Recipient', [], 'messages') => $document->getRecipient() ?? null];
        }

        if (null !== $document->getOriginPlace()) {
            $metadata[] = ['key' => $this->translator->trans('Origin_Place', [], 'messages'), 'value' => $document->getOriginPlace() ?? null];
        }

        if (null !== $document->getDestinationPlace()) {
            $metadata[] = [$this->translator->trans('Destination_Place', [], 'messages') => $document->getDestinationPlace() ?? null];
        }

        if (null !== $document->getOriginDate()) {
            $metadata[] = [$this->translator->trans('Date', [], 'messages') => $document->getOriginDate() ?? null];
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
