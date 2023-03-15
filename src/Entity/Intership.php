<?php

namespace App\Entity;

use App\Repository\IntershipRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Compagnies;
use App\Entity\Student;


/**
 * @ORM\Entity(repositoryClass=IntershipRepository::class)
 */
class Intership
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=student::class, inversedBy="interships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idstudent;

    /**
     * @ORM\ManyToOne(targetEntity=compagnies::class, inversedBy="interships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idcompagnies;

    /**
     * @ORM\Column(type="date")
     */
    private $startdate;

    /**
     * @ORM\Column(type="date")
     */
    private $endate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdstudent(): ?student
    {
        return $this->idstudent;
    }

    public function setIdstudent(?student $idstudent): self
    {
        $this->idstudent = $idstudent;

        return $this;
    }

    public function getIdcompagnies(): ?compagnies
    {
        return $this->idcompagnies;
    }

    public function setIdcompagnies(?compagnies $idcompagnies): self
    {
        $this->idcompagnies = $idcompagnies;

        return $this;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTimeInterface $startdate): self
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEndate(): ?\DateTimeInterface
    {
        return $this->endate;
    }

    public function setEndate(\DateTimeInterface $endate): self
    {
        $this->endate = $endate;

        return $this;
    }
}
