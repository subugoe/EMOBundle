<?php

namespace Subugoe\EMOBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Subugoe\EMOBundle\Service\PresentationService;
use Subugoe\EMOBundle\Translator\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PresentationController extends AbstractController
{
    private PresentationService $presentationService;

    private TranslatorInterface $translator;

    public function __construct(PresentationService $presentationService, TranslatorInterface $translator)
    {
        $this->presentationService = $presentationService;
        $this->translator = $translator;
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
    public function annotationCollection(string $id): Response
    {
        $document = $this->translator->getDocumentById($id);
        $annotationCollection = $this->presentationService->getAnnotationCollection($document, 'manifest');

        return new JsonResponse($annotationCollection);
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
    public function annotationPage(string $id, string $page): Response
    {
        $document = $this->translator->getDocumentById($id);
        $pageDocument = $this->translator->getDocumentById($page);
        $annotationPage = $this->presentationService->getAnnotationPage($document, $pageDocument);

        return new JsonResponse($annotationPage);
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
    public function content(string $id, Request $request): Response
    {
        $flag = $request->get('flag');
        $document = $this->translator->getDocumentById($id);

        $content = $flag ? $document->getTranscriptedText() : $document->getEditedText();

        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/html');

        return $response;
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
    public function full(string $id): Response
    {
        $document = $this->translator->getDocumentById($id);

        return new JsonResponse($this->presentationService->getFull($document));
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
    public function item(string $id): Response
    {
        $document = $this->translator->getDocumentById($id);

        return new JsonResponse($this->presentationService->getItem($document));
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
    public function manifest(string $id): Response
    {
        $document = $this->translator->getDocumentById($id);
        $manifest = $this->presentationService->getManifest($document);

        return new JsonResponse($manifest);
    }

    public function pageAnnotationCollection(string $id, string $page): Response
    {
        $document = $this->translator->getDocumentById($page);
        $annotationCollection = $this->presentationService->getAnnotationCollection($document, 'item');

        return new JsonResponse($annotationCollection);
    }
}
