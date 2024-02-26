<?php

namespace App\Security;

use App\Repository\PersonneRepository;
use App\Entity\Personne;


use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private $username;

    private $roles = [];

    private ?Personne $personne=null;

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): self
    {
        $this->personne=$personne;

        if($personne->getNumDroit()->getNumDroit()==1) {
            $roles->$this->roles;
            $roles[] = 'ROLE_ADMIN';
            $this->setRoles($roles);
        } else {
            $this->getRoles();
        }

        $this->password=$personne->getMdp();

        return $this;
    }

    public function verifierPersonne(PersonneRepository $personneRepository): ?bool
    {
        $leUser=$personneRepository->findOneBy(['login'=>$this->username]);

        if(null!=$leUser) {
            $this->setPersonne($leUser);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @var string The hashed password
     */
    private $password;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
