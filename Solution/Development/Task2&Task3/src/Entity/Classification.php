<?php

namespace App\Entity;

use App\Repository\ClassificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassificationRepository::class)]
class Classification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    /**
     * @var Collection<int, ClassificationStudent>
     */
    #[ORM\OneToMany(targetEntity: ClassificationStudent::class, mappedBy: 'classification')]
    private Collection $classificationStudents;

    public function __construct()
    {
        $this->classificationStudents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $classificationStudent->setClassification($this);
        }

        return $this;
    }

    public function removeClassificationStudent(ClassificationStudent $classificationStudent): static
    {
        if ($this->classificationStudents->removeElement($classificationStudent)) {
            // set the owning side to null (unless already changed)
            if ($classificationStudent->getClassification() === $this) {
                $classificationStudent->setClassification(null);
            }
        }

        return $this;
    }
}
