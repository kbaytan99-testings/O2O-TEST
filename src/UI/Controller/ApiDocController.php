<?php

declare(strict_types=1);

namespace App\UI\Controller;

use Nelmio\ApiDocBundle\ApiDocGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/doc", name="api_doc_")
 */
class ApiDocController extends AbstractController
{
    private ApiDocGenerator $apiDocGenerator;

    public function __construct(ApiDocGenerator $apiDocGenerator)
    {
        $this->apiDocGenerator = $apiDocGenerator;
    }

    /**
     * @Route("", name="swagger_ui", methods={"GET"})
     */
    public function swaggerUi(): Response
    {
        return $this->render('api_doc/swagger_ui.html.twig');
    }

    /**
     * @Route(".json", name="swagger_json", methods={"GET"})
     */
    public function swaggerJson(): JsonResponse
    {
        $spec = $this->apiDocGenerator->generate()->toArray();
        return new JsonResponse($spec);
    }
}
