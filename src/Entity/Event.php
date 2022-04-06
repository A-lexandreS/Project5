<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\Table(name : "events")]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 50)]
    private $picture;

    #[ORM\Column(type: 'datetime_immutable')]
    private $eventDate;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'datetime_immutable')]
    private $startedAt;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(propertyPath:'startedAt')]
    #[ORM\Column(type: 'datetime_immutable')]
    private $endedAt;

    #[Assert\NotBlank]
    #[Assert\Positive]
    #[Assert\Length(min:2, max:4)]
    #[ORM\Column(type: 'integer')]
    private $maxRegistration;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Registration::class)]
    private $registrations;

    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(
        value: 10,
    )]
    #[Assert\Length(min:1, max:3)]
    #[Assert\Positive]
    #[ORM\Column(type: 'integer')]
    #[Assert\Regex('/^\d*\.?\d*$/')]
    private $price;

    #[Assert\NotBlank]
    #[Assert\Regex('/^\w+/')]
    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Comment::class)]
    private $comments;

    public function __construct()
    {
        $this->registrations = new ArrayCollection();
        $date = new \DateTime('now');
        $this->eventDate = DateTimeImmutable::createFromMutable($date);
        $this->comments = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getEventDate(): ?\DateTimeInterface
    {
        return $this->eventDate;
    }

    public function setEventDate(\DateTimeInterface $eventDate): self
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeInterface $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeInterface
    {
        return $this->endedAt;
    }

    public function setEndedAt(\DateTimeInterface $endedAt): self
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    public function getMaxRegistration(): ?int
    {
        return $this->maxRegistration;
    }

    public function setMaxRegistration(int $maxRegistration): self
    {
        $this->maxRegistration = $maxRegistration;

        return $this;
    }

    /**
     * @return Collection<int, Registration>
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

    public function addRegistration(Registration $registration): self
    {
        if (!$this->registrations->contains($registration)) {
            $this->registrations[] = $registration;
            $registration->setEvent($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): self
    {
        if ($this->registrations->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getEvent() === $this) {
                $registration->setEvent(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setEvent($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getEvent() === $this) {
                $comment->setEvent(null);
            }
        }

        return $this;
    }
}