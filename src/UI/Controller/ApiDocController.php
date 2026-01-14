<?php

declare(strict_types=1);

namespace App\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/doc", name="api_doc_")
 */
class ApiDocController extends AbstractController
{
    /**
     * @Route("", name="swagger_ui", methods={"GET"})
     */
    public function swaggerUi(): Response
    {
        return $this->render('api_doc/swagger_ui.html.twig');
    }
}
