<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['subjectList']],
    denormalizationContext: ['groups' => ['subjectCreate']],
)]
class Subject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["subjectList"])]    
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["subjectList", "subjectCreate"])]   
    #[Assert\NotBlank] 
    #[Assert\Length(255)] 
    private $name;

    #[ORM\OneToMany(mappedBy: 'subject', targetEntity: Lesson::class)]
    #[Assert\NotBlank]     
    #[ApiSubresource]        
    private $lessons;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["subjectCreate"])]       
    private $description;

    public function __construct()
    {
        $this->lessons = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Lesson>
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons[] = $lesson;
            $lesson->setSubject($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->lessons->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getSubject() === $this) {
                $lesson->setSubject(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
