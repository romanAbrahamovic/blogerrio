<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Comment
{
    public const MAX_DEPTH = 4;
    public const DEFAULT_DEPTH = 0;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Article::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private $article;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user;

    #[ORM\Column(type: 'text')]
    private $text;

    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private $depth;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private $parent;

    #[ORM\Column(type: 'datetime')]
    private $dateAdd;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateUpd;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Article|null
     */
    public function getArticle(): ?Article
    {
        return $this->article;
    }

    /**
     * @param Article|null $article
     * @return $this
     */
    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getDepth(): ?int
    {
        return $this->depth;
    }

    /**
     * @param int $depth
     * @return $this
     */
    public function setDepth(int $depth): self
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * @return $this|null
     */
    public function getParent(): ?self
    {
        return $this->parent;
    }

    /**
     * @param Comment|null $parent
     * @return $this
     */
    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->dateAdd;
    }

    /**
     * @return $this
     */
    #[ORM\PrePersist]
    public function setDateAdd(): self
    {
        $this->dateAdd = new \DateTime();

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateUpd(): ?\DateTimeInterface
    {
        return $this->dateUpd;
    }

    #[ORM\PreUpdate]
    public function setDateUpd(): self
    {
        $this->dateUpd = new \DateTime();

        return $this;
    }
}
