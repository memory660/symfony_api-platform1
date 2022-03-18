<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['lessonList']],
    denormalizationContext: ['groups' => ['lessonCreate']],    
    itemOperations: [
        'get',      // get specific element
        'put',      // update element 
    ],
)]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["lessonList", "lessonCreate"])]        
    private $name;

    #[ORM\OneToMany(mappedBy: 'lesson', targetEntity: Flashcard::class, cascade: ["persist", "remove"])]
    #[ApiSubresource]    
    private $flashcards;

    #[ORM\ManyToOne(targetEntity: Subject::class, inversedBy: 'lessons')]
    #[Groups(["lessonCreate"])]          
    private $subject;

    public function __construct()
    {
        $this->flashcards = new ArrayCollection();
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
     * @return Collection<int, Flashcard>
     */
    public function getFlashcards(): Collection
    {
        return $this->flashcards;
    }

    public function addFlashcard(Flashcard $flashcard): self
    {
        if (!$this->flashcards->contains($flashcard)) {
            $this->flashcards[] = $flashcard;
            $flashcard->setLesson($this);
        }

        return $this;
    }

    public function removeFlashcard(Flashcard $flashcard): self
    {
        if ($this->flashcards->removeElement($flashcard)) {
            // set the owning side to null (unless already changed)
            if ($flashcard->getLesson() === $this) {
                $flashcard->setLesson(null);
            }
        }

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }
}
