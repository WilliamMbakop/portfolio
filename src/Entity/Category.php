<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Techno>
     */
    #[ORM\OneToMany(targetEntity: Techno::class, mappedBy: 'category')]
    private Collection $technos;

    /**
     * @var Collection<int, Project>
     */
    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'categories')]
    private Collection $projects;

    public function __construct()
    {
        $this->technos = new ArrayCollection();
        $this->projects = new ArrayCollection();
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

    public function __toString(): string
    {
        return $this->name;  // Retourne le nom de la catégorie comme chaîne
    }

    /**
     * @return Collection<int, Techno>
     */
    public function getTechnos(): Collection
    {
        return $this->technos;
    }

    public function addTechno(Techno $techno): static
    {
        if (!$this->technos->contains($techno)) {
            $this->technos->add($techno);
            $techno->setCategory($this);
        }

        return $this;
    }

    public function removeTechno(Techno $techno): static
    {
        if ($this->technos->removeElement($techno)) {
            // set the owning side to null (unless already changed)
            if ($techno->getCategory() === $this) {
                $techno->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->addCategory($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            $project->removeCategory($this);
        }

        return $this;
    }
}
