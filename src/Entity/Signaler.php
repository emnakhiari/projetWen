<?php

namespace App\Entity;

use App\Repository\SignalerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SignalerRepository::class)]
class Signaler
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $userAction = null;

    #[ORM\Column]
    private ?int $userProp = null;

    #[ORM\ManyToOne(inversedBy: 'signalers')]
    private ?Commentaire $commentaire = null;

    #[ORM\Column(length: 255)]
    private ?string $Cause = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserAction(): ?int
    {
        return $this->userAction;
    }

    public function setUserAction(int $userAction): self
    {
        $this->userAction = $userAction;

        return $this;
    }

    public function getUserProp(): ?int
    {
        return $this->userProp;
    }

    public function setUserProp(int $userProp): self
    {
        $this->userProp = $userProp;

        return $this;
    }

    public function getCommentaire(): ?Commentaire
    {
        return $this->commentaire;
    }

    public function setCommentaire(?Commentaire $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getCause(): ?string
    {
        return $this->Cause;
    }

    public function setCause(string $Cause): self
    {
        $this->Cause = $Cause;

        return $this;
    }
}
