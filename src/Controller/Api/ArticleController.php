<?php

namespace App\Controller\Api;

use App\Exception\InvalidParamsException;
use App\Service\CommentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/article')]
class ArticleController extends AbstractController
{
    /**
     * @param Request $request
     * @param CommentService $commentService
     * @return Response
     */
    #[Route('/comment', name: 'app_api_article_comments_get', methods: ['GET'])]
    public function getComments(Request $request, CommentService $commentService): Response
    {
        $articleId = $request->get('id');

        if (empty($articleId)) {
            throw new InvalidParamsException();
        }

        return $this->json($commentService->getCommentsByArticle($articleId));
    }
}