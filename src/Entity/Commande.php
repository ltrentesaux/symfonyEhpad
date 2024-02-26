<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="LOGIN", columns={"LOGIN"})})
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="NOCOMMANDE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nocommande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="TOTAL", type="float", precision=10, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $total = 0.00;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="LOGIN", referencedColumnName="LOGIN")
     * })
     */
    private $login;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Service", mappedBy="nocommande")
     */
    private $reference = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reference = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date= new \DateTime('now');
    }

    public function getNocommande(): ?int
    {
        return $this->nocommande;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getLogin(): ?Client
    {
        return $this->login;
    }

    public function setLogin(?Client $login): static
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getReference(): Collection
    {
        return $this->reference;
    }

    public function addReference(Service $reference): static
    {
        if (!$this->reference->contains($reference)) {
            $this->reference->add($reference);
            $reference->addNocommande($this);
        }

        return $this;
    }

    public function removeReference(Service $reference): static
    {
        if ($this->reference->removeElement($reference)) {
            $reference->removeNocommande($this);
        }

        return $this;
    }

}
