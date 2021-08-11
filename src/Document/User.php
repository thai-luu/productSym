<?php

namespace App\Document;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(collection="users")
 * @MongoDBUnique(fields="email")
 */
class User implements UserInterface,PasswordAuthenticatedUserInterface
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    protected $password;
    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    protected $Username;
    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    protected $roles;

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    // stupid simple encryption (please don't copy it!)
    public function setPassword($password)
    {
        $this->password = $password;
    }
    /**
     * @see UserInterface
     */
    
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function getRoles(): ?string
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    public function getUsername(){
        return $this->Username;
    }
    public function setUsername($Username){
      $this->Username = $Username;
    }
}
