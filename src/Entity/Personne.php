<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personne
 *
 * @ORM\Table(name="personne", indexes={@ORM\Index(name="NUMDROIT", columns={"NUMDROIT"})})
 * @ORM\Entity(repositoryClass="App\Repository\PersonneRepository")
 */
class Personne
{
    /**
     * @var string
     *
     * @ORM\Column(name="LOGIN", type="string", length=32, nullable=false, options={"fixed"=true})
     * @ORM\Id
     */
    private $login;

    /**
     * @var string|null
     *
     * @ORM\Column(name="MDP", type="string", length=32, nullable=true, options={"fixed"=true})
     */
    private $mdp;

    /**
     * @var \Droit
     *
     * @ORM\ManyToOne(targetEntity="Droit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="NUMDROIT", referencedColumnName="NUMDROIT")
     * })
     */
    private $numdroit;

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(?string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }
    public function getNumdroit(): ?Droit
    {
        return $this->numdroit;
    }

    public function setNumdroit(?Droit $numdroit): static
    {
        $this->numdroit = $numdroit;

        return $this;
    }

    public function setLogin(?string $login): static
    {
        $this->login = $login;

        return $this;
    }




}
