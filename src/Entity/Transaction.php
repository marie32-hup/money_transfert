<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomexp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomeexp;

    /**
     * @ORM\Column(type="integer")
     */
    private $telexp;

    /**
     * @ORM\Column(type="integer")
     */
    private $pieceexp;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateenvoi;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenombeneficiaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombeneficiare;

    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $telbeneficiare;

    /**
     * @ORM\Column(type="integer")
     */
    private $piecebeneficiaire;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateretrait;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="float")
     */
    private $frais;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transactions")
     */
    private $userretrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userenvoi")
     */
    private $transactions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transactions")
     */
    private $compteretrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transaction")
     * @ORM\JoinColumn(nullable=false)
     */
    private $compteenvoi;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenomexp(): ?string
    {
        return $this->prenomexp;
    }

    public function setPrenomexp(string $prenomexp): self
    {
        $this->prenomexp = $prenomexp;

        return $this;
    }

    public function getNomeexp(): ?string
    {
        return $this->nomeexp;
    }

    public function setNomeexp(string $nomeexp): self
    {
        $this->nomeexp = $nomeexp;

        return $this;
    }

    public function getTelexp(): ?int
    {
        return $this->telexp;
    }

    public function setTelexp(int $telexp): self
    {
        $this->telexp = $telexp;

        return $this;
    }

    public function getPieceexp(): ?int
    {
        return $this->pieceexp;
    }

    public function setPieceexp(int $pieceexp): self
    {
        $this->pieceexp = $pieceexp;

        return $this;
    }

    public function getDateenvoi(): ?\DateTimeInterface
    {
        return $this->dateenvoi;
    }

    public function setDateenvoi(\DateTimeInterface $dateenvoi): self
    {
        $this->dateenvoi = $dateenvoi;

        return $this;
    }

    public function getPrenombeneficiaire(): ?string
    {
        return $this->prenombeneficiaire;
    }

    public function setPrenombeneficiaire(string $prenombeneficiaire): self
    {
        $this->prenombeneficiaire = $prenombeneficiaire;

        return $this;
    }

    public function getNombeneficiare(): ?string
    {
        return $this->nombeneficiare;
    }

    public function setNombeneficiare(string $nombeneficiare): self
    {
        $this->nombeneficiare = $nombeneficiare;

        return $this;
    }

    public function getTelbeneficiare(): ?string
    {
        return $this->telbeneficiare;
    }

    public function setTelbeneficiare(string $telbeneficiare): self
    {
        $this->telbeneficiare = $telbeneficiare;

        return $this;
    }

    public function getPiecebeneficiaire(): ?int
    {
        return $this->piecebeneficiaire;
    }

    public function setPiecebeneficiaire(int $piecebeneficiaire): self
    {
        $this->piecebeneficiaire = $piecebeneficiaire;

        return $this;
    }

    public function getDateretrait(): ?\DateTimeInterface
    {
        return $this->dateretrait;
    }

    public function setDateretrait(\DateTimeInterface $dateretrait): self
    {
        $this->dateretrait = $dateretrait;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getFrais(): ?float
    {
        return $this->frais;
    }

    public function setFrais(float $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getUserretrait(): ?User
    {
        return $this->userretrait;
    }

    public function setUserretrait(?User $userretrait): self
    {
        $this->userretrait = $userretrait;

        return $this;
    }

    public function getTransactions(): ?User
    {
        return $this->transactions;
    }

    public function setTransactions(?User $transactions): self
    {
        $this->transactions = $transactions;

        return $this;
    }

    public function getCompteretrait(): ?Compte
    {
        return $this->compteretrait;
    }

    public function setCompteretrait(?Compte $compteretrait): self
    {
        $this->compteretrait = $compteretrait;

        return $this;
    }

    public function getCompteenvoi(): ?Compte
    {
        return $this->compteenvoi;
    }

    public function setCompteenvoi(?Compte $compteenvoi): self
    {
        $this->compteenvoi = $compteenvoi;

        return $this;
    }
}
