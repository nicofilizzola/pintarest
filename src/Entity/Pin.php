<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PinRepository;
use App\Entity\Traits\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PinRepository::class)
 * @ORM\HasLifecycleCallbacks
 */

class Pin
{
    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Is there no title?")
     * @Assert\Length(min=3, minMessage="So your title has less than 3 characters... That won't work")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Is there no description?")
     * @Assert\Length(min=10, minMessage="Your pin's description must be at least 10 characters long")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imagePath;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }
}
