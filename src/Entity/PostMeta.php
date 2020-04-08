<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostMetaRepository")
 */
class PostMeta
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $views = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $comments = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $likes = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $status = 1;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getViews(): ?string
    {
        return $this->views;
    }

    public function setViews(string $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getLikes(): ?string
    {
        return $this->likes;
    }

    public function setLikes(string $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
