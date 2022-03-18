<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['userList']],
    denormalizationContext: ['groups' => ['userCreate']],    
    itemOperations: [
        'get',
        'put',        
        'changePassword' => [
            'method' => 'PUT',
            'path' => '/users/{id}/change-password',            
            'denormalization_context' => ['groups' => ['userChangePassword']],
            'validation_groups' => ['userChangePassword'],
            'swagger_context'=> [
                'summary' => ['Change user password']
            ]
        ],
    ],
)]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["userList"])]       
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["userList", "userCreate"])]      
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["userList", "userCreate"])]      
    private $email;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private $password;

    #[ORM\Column(type: 'json', nullable: true)]
    private $roles = ['ROLE_USER'];

    #[Groups(["userChangePassword", "userCreate"])]    
    #[Assert\NotBlank(groups: ["userCreate", "userChangePassword"])]        
    #[Assert\Length(min: 8, max: 255, groups: ["userCreate", "userChangePassword"])]     
    private $plainPassword;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }


    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() {}

    /**
     * Returns the identifier for this user (e.g. its username or email address).
     */
    public function getUserIdentifier(): string {
        return $this->email;
    }    
}
