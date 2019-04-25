<?php

declare(strict_types=1);

namespace Subugoe\EMOBundle\Service;

use Subugoe\EMOBundle\Model\Presentation\Item;
use Subugoe\EMOBundle\Model\Presentation\Title;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouterInterface;
use Subugoe\EMOBundle\Model\DocumentInterface;

class PresentationService
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * PresentationService constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
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
     * @param $titleStr
     *
     * @return Title
     */
    public function getTitle($titleStr): Title
    {
        $title = new Title();

        $title->setTitle($titleStr);

        return $title;
    }
}
