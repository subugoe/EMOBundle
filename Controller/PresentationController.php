<?php

namespace Subugoe\EMOBundle\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController as Controller;
use FOS\RestBundle\View\View;
use GuzzleHttp\Psr7\Request as Guzzle;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Subugoe\EMOBundle\Service\PresentationService;
use Subugoe\EMOBundle\Translator\TranslatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

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
     *  description="Tido text API item page resource",
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
     *  description="Tido text API item full resource",
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
     *  description="Tido text API full content resource",
     *  requirements={
     *      {"name"="id", "dataType"="string", "required"=true, "description"="work identifier"}
     *  }
     * )
     */
    public function contentAction(string $id, Request $request): Response
    {
        $flag = $request->get('flag');
        $document = $this->translator->getDocumentById($id);

        if ($flag) {
            $content = $document->getTranscriptedText();
        } else {
            $content = $document->getEditedText();
        }

        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/html');

        return $response;
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Tido text API manifest resource",
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

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Tido text API annotationCollection resource",
     *  requirements={
     *      {"name"="id", "dataType"="string", "required"=true, "description"="work identifier"}
     *  }
     * )
     */
    public function annotationCollectionAction(string $id): View
    {
        $document = $this->translator->getDocumentById($id);
        $annotationCollection = $this->presentationService->getAnnotationCollection($document, 'manifest');

        return $this->view($annotationCollection, Response::HTTP_OK);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Tido text API annotationPage resource",
     *  requirements={
     *      {"name"="id", "dataType"="string", "required"=true, "description"="work identifier"}
     *      {"name"="page", "dataType"="string", "required"=true, "description"="page identifier"}
     *  }
     * )
     */
    public function annotationPageAction(string $id, string $page): View
    {
        $document = $this->translator->getDocumentById($id);
        $page = $this->translator->getDocumentById($page);
        $annotationPage = $this->presentationService->getAnnotationPage($document, $page);

        return $this->view($annotationPage, Response::HTTP_OK);
    }

    public function pageAnnotationCollectionAction(string $id, string $page): View
    {
        $document = $this->translator->getDocumentById($page);
        $annotationCollection = $this->presentationService->getAnnotationCollection($document, 'item');

        return $this->view($annotationCollection, Response::HTTP_OK);
    }
}
