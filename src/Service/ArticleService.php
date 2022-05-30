<?php

namespace App\Service;

use App\Entity\Article;
use App\Repository\ArticleRepository;

/**
 * Class ArticleService
 * @package App\Service
 */
class ArticleService
{
    /** @var ArticleRepository $articleRepository */
    private ArticleRepository $articleRepository;

    /**
     * ArticleService constructor.
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @return Article
     */
    public function getActiveArticle(): Article
    {
        return $this->articleRepository->findAll()[0];
    }

    /**
     * @return array
     */
    public function getArticles(): array
    {
        return $this->articleRepository->getArticles();
    }

}
