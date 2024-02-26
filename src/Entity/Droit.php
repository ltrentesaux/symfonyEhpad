<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Droit
 *
 * @ORM\Table(name="droit")
 * @ORM\Entity(repositoryClass="App\Repository\DroitRepository")
 */
class Droit
{
    /**
     * @var int
     *
     * @ORM\Column(name="NUMDROIT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numdroit;

    /**
     * @var string
     *
     * @ORM\Column(name="LIBELE", type="string", length=50, nullable=false)
     */
    private $libele;

    public function getNumdroit(): ?int
    {
        return $this->numdroit;
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
