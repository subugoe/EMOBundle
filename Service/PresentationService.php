<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Service;

use Subugoe\EMOBundle\Model\Presentation\License;
use Subugoe\EMOBundle\Model\Presentation\Manifest;
use Subugoe\EMOBundle\Model\Presentation\Item;
use Subugoe\EMOBundle\Model\Presentation\Sequence;
use Subugoe\EMOBundle\Model\Presentation\Support;
use Subugoe\EMOBundle\Model\Presentation\Title;
use Symfony\Component\Routing\RouterInterface;
use Subugoe\EMOBundle\Model\DocumentInterface;
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
     * PresentationService constructor.
     *
     * @param RouterInterface $router
     * @param TranslatorInterface $translator
     */
    public function __construct(RouterInterface $router, TranslatorInterface $translator, RequestStack $requestStack, Packages $assetsManager)
    {
        $this->router = $router;
        $this->translator = $translator;
        $this->request = $requestStack;
        $this->assetsManager = $assetsManager;
    }

    /**
     * @param DocumentInterface $document
     *
     * @return Item
     */
    public function getItem(DocumentInterface $document): Item
    {
        $item = new Item();
        $item->setTitle($this->getTitle($document->getTitle()));
        $item->setContent($document->getContent());

        return $item;
    }

    /**
     * @param DocumentInterface $document
     *
     * @return Manifest
     */
    public function getManifest(DocumentInterface $document): Manifest
    {
        $manifest = new Manifest();
        $manifest->setId($this->router->generate('subugoe_emo_manifest', ['id' => $document->getId()], RouterInterface::ABSOLUTE_URL));
        $manifest->setLabel($document->getTitle());
        $manifest->setMetadata($this->getMetadata($document));
        $manifest->setSequence($this->getSequence($document));
        $manifest->setSupport($this->getSupport());
        $manifest->setLicense($this->getLicense());

        return $manifest;
    }

    /**
     * @return array
     */
    private function getLicense(): array
    {
        $licenses = [];
        $license = new License();
        $licenses[] = $license;

        return $licenses;
    }

    /**
     * @return array
     */
    private function getSupport(): array
    {
        $supports = [];
        $support = new Support();
        $supports[] = $support->setUrl($this->request->getCurrentRequest()->getUriForPath($this->assetsManager->getUrl('build/support.css')));

        return $supports;
    }

    /**
     * @param DocumentInterface $document
     *
     * @return array
     */
    private function getSequence(DocumentInterface $document): array
    {
        $sequences = [];
        $sequence = new Sequence();
        $sequences[] = $sequence->setId($this->router->generate('subugoe_emo_item', ['id' => $document->getId()], RouterInterface::ABSOLUTE_URL));

        return $sequences;
    }

    /**
     * @param DocumentInterface $document
     *
     * @return array
     */
    private function getMetadata(DocumentInterface $document): array
    {
        $metadata[$this->translator->trans('Author', [], 'messages')] = $document->getAuthor() ?? null;
        $metadata[$this->translator->trans('Recipient', [], 'messages')] = $document->getRecipient() ?? null;
        $metadata[$this->translator->trans('Origin_Place', [], 'messages')] = $document->getOriginPlace() ?? null;
        $metadata[$this->translator->trans('Destination_Place', [], 'messages')] = $document->getDestinationPlace() ?? null;
        $metadata[$this->translator->trans('Date', [], 'messages')] = $document->getOriginDate() ?? null;

        return $metadata;
    }

    /**
     * @param string $titleStr
     *
     * @return Title
     */
    public function getTitle(string $titleStr): Title
    {
        $title = new Title();
        $title->setTitle($titleStr);

        return $title;
    }
}
