<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?User $manager = null;

    #[ORM\OneToOne(mappedBy: 'comment', cascade: ['persist', 'remove'])]
    private ?Application $application = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getManager(): ?User
    {
        return $this->manager;
    }

    public function setManager(?User $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    public function getApplication(): ?Application
    {
        return $this->application;
    }

    public function setApplication(?Application $application): self
    {
        // unset the owning side of the relation if necessary
        if ($application === null && $this->application !== null) {
            $this->application->setComment(null);
        }

        // set the owning side of the relation if necessary
        if ($application !== null && $application->getComment() !== $this) {
            $application->setComment($this);
        }

        $this->application = $application;

        return $this;
    }
}
