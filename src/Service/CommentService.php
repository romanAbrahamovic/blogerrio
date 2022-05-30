<?php


namespace App\Service;

use App\Entity\Comment;
use App\Entity\User;
use App\Exception\ResourceNotFoundException;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;

/**
 * Class CommentService
 * @package App\Service
 */
class CommentService
{
    private CommentRepository $commentRepository;
    private ArticleService $articleService;
    private EntityManagerInterface $entityManager;

    /**
     * CommentService constructor.
     * @param CommentRepository $commentRepository
     * @param ArticleService $articleService
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        CommentRepository $commentRepository,
        ArticleService $articleService,
        EntityManagerInterface $entityManager
    ) {
        $this->commentRepository = $commentRepository;
        $this->articleService = $articleService;
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $user
     * @param string $commentText
     * @param int|null $parentId
     */
    public function addNewComment(User $user, string $commentText, int $parentId = null): void
    {
        $article = $this->articleService->getActiveArticle();

        $comment = new Comment();
        $comment->setUser($user);
        $comment->setArticle($article);
        $comment->setText($commentText);
        $comment->setDepth(Comment::DEFAULT_DEPTH);

        if (!empty($parentId)) {
            try {
                $parentComment = $this->entityManager->getReference(Comment::class, $parentId);
                $comment->setParent($parentComment);
                $comment->setDepth($this->getChildCommentDepth($parentComment->getId()));
            } catch (ORMException $e) {
            }
        }
        $this->commentRepository->add($comment, true);
    }

    /**
     * @param int $commentId
     * @param string $commentText
     * @return void
     */
    public function editTextComment(int $commentId, string $commentText): void
    {
        try {
            $comment = $this->entityManager->getReference(Comment::class, $commentId);
            $comment->setText($commentText);
            $this->commentRepository->add($comment, true);
        } catch (ORMException $e) {
            throw new ResourceNotFoundException('Comment not found');
        }
    }

    /**
     * @param int $commentId
     */
    public function removeComment(int $commentId): void
    {
        try {
            $comment = $this->entityManager->getReference(Comment::class, $commentId);
            $this->commentRepository->remove($comment, true);
        } catch (ORMException $e) {
            throw new ResourceNotFoundException('Comment not found');
        }
    }

    /**
     * @param int $articleId
     * @return array
     */
    public function getCommentsByArticle(int $articleId): array
    {
        return $this->commentRepository->getCommentsByArticle($articleId);
    }

    /**
     * @return array
     */
    public function getAllComments(): array
    {
        return $this->commentRepository->getAllComments();
    }

    /**
     * @param int $commentId
     * @return int
     */
    private function getChildCommentDepth(int $commentId): int
    {
        $parentDepth = $this->commentRepository->getCommentDepth($commentId);
        $childDepth = Comment::DEFAULT_DEPTH;

        if ($parentDepth == Comment::MAX_DEPTH) {
            $childDepth = Comment::MAX_DEPTH;
        }

        if (($parentDepth + 1) <= Comment::MAX_DEPTH) {
            $childDepth = $parentDepth + 1;
        }
        return $childDepth;
    }

}