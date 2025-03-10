<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $first_name = null;

    #[ORM\Column(length: 100)]
    private ?string $last_name = null;

    /**
     * @var Collection<int, ClassificationStudent>
     */
    #[ORM\OneToMany(targetEntity: ClassificationStudent::class, mappedBy: 'student', orphanRemoval: true)]
    private Collection $classificationStudents;

    public function __construct()
    {
        $this->classificationStudents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * @return Collection<int, ClassificationStudent>
     */
    public function getClassificationStudents(): Collection
    {
        return $this->classificationStudents;
    }

    public function addClassificationStudent(ClassificationStudent $classificationStudent): static
    {
        if (!$this->classificationStudents->contains($classificationStudent)) {
            $this->classificationStudents->add($classificationStudent);
            $classificationStudent->setStudent($this);
        }

        return $this;
    }

    public function removeClassificationStudent(ClassificationStudent $classificationStudent): static
    {
        if ($this->classificationStudents->removeElement($classificationStudent)) {
            // set the owning side to null (unless already changed)
            if ($classificationStudent->getStudent() === $this) {
                $classificationStudent->setStudent(null);
            }
        }

        return $this;
    }
}
