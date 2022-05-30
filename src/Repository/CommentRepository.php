<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 *
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * @param Comment $entity
     * @param bool $flush
     * @return void
     */
    public function add(Comment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Comment $entity
     * @param bool $flush
     * @return void
     */
    public function remove(Comment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return array
     */
    public function getAllComments(): array
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.article', 'a')
            ->leftJoin('c.user', 'u')
            ->leftJoin('c.parent', 'pc')
            ->select(
                'c.id',
                'c.text',
                'c.dateAdd',
                'c.dateUpd',
                'c.depth',
                'pc.id AS parentId',
            )
            ->addSelect('u.firstName AS firstname', 'u.lastName AS lastname')
            ->getQuery()
            ->getResult();
    }


    /**
     * @param int $articleId
     * @return array
     */
    public function getCommentsByArticle(int $articleId): array
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.article', 'a')
            ->leftJoin('c.user', 'u')
            ->leftJoin('c.parent', 'pc')
            ->select(
                'c.id',
                'c.text',
                'c.dateAdd',
                'c.dateUpd',
                'c.depth',
                'pc.id AS parentId',
            )
            ->addSelect('u.firstName AS firstname', 'u.lastName AS lastname')
            ->where('a.id = :articleId')
            ->setParameter('articleId', $articleId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $commentId
     * @return int
     */
    public function getCommentDepth(int $commentId): int
    {
        return $this->createQueryBuilder('c')
            ->select('c.depth')
            ->where('c.id = :commentId')
            ->setParameter('commentId', $commentId)
            ->getQuery()
            ->getSingleColumnResult()[0];
    }
}
