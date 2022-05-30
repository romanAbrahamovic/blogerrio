<?php

namespace App\Controller;

use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FrontController
 * @package App\Controller
 */
class FrontController extends AbstractController
{
    /**
     * @param ArticleService $articleService
     * @return Response
     */
    #[Route('/', name: 'homepage', methods: 'GET')]
    public function index(ArticleService $articleService): Response
    {
        // NOTE: we have only one article for testing purposes
        return $this->render(
            'front/index.html.twig',
            [
                'article' => $articleService->getArticles()[0],
            ]
        );
    }


}
