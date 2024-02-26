<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="NUMEROCAT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numerocat;

    /**
     * @var string
     *
     * @ORM\Column(name="LIBELE", type="string", length=100, nullable=false)
     */
    private $libele;

    public function getNumerocat(): ?int
    {
        return $this->numerocat;
    }

    public function getLibele(): ?string
    {
        return $this->libele;
    }

    public function setLibele(string $libele): static
    {
        $this->libele = $libele;

        return $this;
    }


}
