<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table(name="service", indexes={@ORM\Index(name="NUMEROCAT", columns={"NUMEROCAT"})})
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{
    /**
     * @var int
     *
     * @ORM\Column(name="REFERENCE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="TITRE", type="string", length=100, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="RESUME", type="string", length=255, nullable=false)
     */
    private $resume;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PRIX", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="PHOTO", type="string", length=255, nullable=false)
     */
    private $photo;

    /**
     * @var int
     *
     * @ORM\Column(name="STOCK", type="integer", nullable=false)
     */
    private $stock;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="NUMEROCAT", referencedColumnName="NUMEROCAT")
     * })
     */
    private $numerocat;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Commande", inversedBy="reference")
     * @ORM\JoinTable(name="lignecommande",
     *   joinColumns={
     *     @ORM\JoinColumn(name="REFERENCE", referencedColumnName="REFERENCE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="NOCOMMANDE", referencedColumnName="NOCOMMANDE")
     *   }
     * )
     */
    private $nocommande = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->nocommande = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getReference(): ?int
    {
        return $this->reference;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): static
    {
        $this->resume = $resume;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(?string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getNumerocat(): ?Categorie
    {
        return $this->numerocat;
    }

    public function setNumerocat(?Categorie $numerocat): static
    {
        $this->numerocat = $numerocat;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getNocommande(): Collection
    {
        return $this->nocommande;
    }

    public function addNocommande(Commande $nocommande): static
    {
        if (!$this->nocommande->contains($nocommande)) {
            $this->nocommande->add($nocommande);
        }

        return $this;
    }

    public function removeNocommande(Commande $nocommande): static
    {
        $this->nocommande->removeElement($nocommande);

        return $this;
    }

}
