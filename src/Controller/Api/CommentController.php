<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Exception\InvalidParamsException;
use App\Service\CommentService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CommentController
 * @package App\Controller\Api
 */
#[Route('/api/comment')]
class CommentController extends AbstractController
{
    /**
     * @param CommentService $commentService
     * @return Response
     */
    #[Route('/get', name: 'app_api_comment_get', methods: ['GET'])]
    public function get(CommentService $commentService): Response
    {
        return $this->json($commentService->getAllComments());
    }

    /**
     * @param Request $request
     * @param CommentService $commentService
     * @param UserService $userService
     * @return Response
     */
    #[Route('/add', name: 'app_api_comment_add', methods: ['POST'])]
    public function add(
        Request $request,
        CommentService $commentService,
        UserService $userService
    ): Response {
        $firstname = $request->get('firstName');
        $commentText = $request->get('commentText');
        $parentId = $request->get('parentId');

        if (empty($parentId)) {
            $parentId = null;
        }

        if (empty($commentText)) {
            throw new InvalidParamsException('Required commentText for comment is missing');
        }

        if (empty($firstname)) {
            throw new InvalidParamsException('Required firstname param for user is missing');
        }

        $user = (!$this->isGranted(User::USER_ROLES['ROLE_USER']))
            ? $userService->addAnonymousUser($firstname)
            : $this->getUser();

        $commentService->addNewComment($user, $commentText, $parentId);

        return $this->json([], Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param CommentService $commentService
     * @return Response
     */
    #[Route('/edit', name: 'app_api_comment_edit', methods: ['PATCH', 'POST'])]
    public function edit(Request $request, CommentService $commentService): Response
    {
        $commentId = $request->get('commentId');
        $commentText = $request->get('commentText');

        if (empty($commentId)) {
            throw new InvalidParamsException();
        }

        $commentService->editTextComment($commentId, $commentText);

        return $this->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Request $request
     * @param CommentService $commentService
     * @return Response
     */
    #[Route('/delete', name: 'app_api_comment_delete', methods: ['DELETE'])]
    public function delete(Request $request, CommentService $commentService): Response
    {
        $commentId = $request->get('commentId');

        if (empty($commentId)) {
            throw new InvalidParamsException('Missing comment id param');
        }

        $commentService->removeComment($commentId);

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
