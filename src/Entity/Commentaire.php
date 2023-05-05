<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
   /**
     * @ORM\Column(length=65535, nullable=true)
     * 
     */
    //#[Assert\NotBlank(message:"le champ est vide")]
   /* #[Assert\Length(
        min: 5,
        max: 50,
        minMessage: 'Votre commentaire doit contenir plus que 5 caractéres ',
        maxMessage: 'Votre commentaire a depassé 50 caractéres',
    )]*/
    private ?string $commentaire = null;

      /**
     * @var int|null
     *
     * @ORM\Column(name="idUtilisateur", type="integer", nullable=true, options={"default"="NULL"})
     */
   // #[Assert\NotBlank(message:"le champ est vide")]
    private ?int $idUtilisateur = null;

  
    //#[ORM\Column(type: Types::DATETIME_MUTABLE)]
     /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private ?\DateTimeInterface $date = null;
    
    //#[ORM\Column]
     /**
     * @var int|null
     *
     * @ORM\Column(name="idproduit", type="integer", nullable=true, options={"default"="NULL"})
     */
    private ?int $idproduit = null;

 


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getIdUtilisateur(): ?int
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(int $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdproduit(): ?int
    {
        return $this->idproduit;
    }

    public function setIdproduit(int $idproduit): self
    {
        $this->idproduit = $idproduit;

        return $this;
    }




    
}
