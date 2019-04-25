<?php

namespace Subugoe\EMOBundle\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController as Controller;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Subugoe\EMOBundle\Service\PresentationService;
use Subugoe\EMOBundle\Translator\TranslatorInterface;
use Symfony\Component\HttpFoundation\Response;

class PresentationController extends Controller
{
    /**
     * @var PresentationService
     */
    private $presentationService;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * PresentationController constructor.
     *
     * @param PresentationService $presentationService
     */
    public function __construct(PresentationService $presentationService, TranslatorInterface $translator)
    {
        $this->presentationService = $presentationService;
        $this->translator = $translator;
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="EMO text API item resource",
     *  requirements={
     *      {"name"="id", "dataType"="string", "required"=true, "description"="work identifier"}
     *  }
     * )
     */
    public function itemAction(string $id)
    {
        $document = $this->translator->getDocumentById($id);

        return $this->view($this->presentationService->getItem($document), Response::HTTP_OK);
    }
}
