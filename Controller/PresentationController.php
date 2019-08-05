<?php

namespace Subugoe\EMOBundle\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController as Controller;
use FOS\RestBundle\View\View;
use GuzzleHttp\Psr7\Request as Guzzle;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Subugoe\EMOBundle\Service\PresentationService;
use Subugoe\EMOBundle\Translator\TranslatorInterface;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerInterface;

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
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * PresentationController constructor.
     *
     * @param PresentationService $presentationService
     */
    public function __construct(PresentationService $presentationService, TranslatorInterface $translator, SerializerInterface $serializer)
    {
        $this->presentationService = $presentationService;
        $this->translator = $translator;
        $this->serializer = $serializer;
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="EMO text API item page resource",
     *  requirements={
     *      {"name"="id", "dataType"="string", "required"=true, "description"="work identifier"}
     *  }
     * )
     */
    public function itemAction(string $id): View
    {
        $document = $this->translator->getDocumentById($id);

        return $this->view($this->presentationService->getItem($document), Response::HTTP_OK);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="EMO text API item full resource",
     *  requirements={
     *      {"name"="id", "dataType"="string", "required"=true, "description"="work identifier"}
     *  }
     * )
     */
    public function fullAction(string $id): View
    {
        $document = $this->translator->getDocumentById($id);

        return $this->view($this->presentationService->getFull($document), Response::HTTP_OK);
    }


    /**
     * @ApiDoc(
     *  resource=true,
     *  description="EMO text API full content resource",
     *  requirements={
     *      {"name"="id", "dataType"="string", "required"=true, "description"="work identifier"}
     *  }
     * )
     */
    public function contentAction(string $id): Response
    {
        $document = $this->translator->getDocumentById($id);
        $response = new Response($document->getContent());
        $response->headers->set('Content-Type', 'text/html');

        return $response;
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="EMO text API manifest resource",
     *  requirements={
     *      {"name"="id", "dataType"="string", "required"=true, "description"="work identifier"}
     *  }
     * )
     */
    public function manifestAction(string $id): View
    {
        $document = $this->translator->getDocumentById($id);
        $manifest = $this->presentationService->getManifest($document);

        return $this->view($manifest, Response::HTTP_OK);
    }
}
