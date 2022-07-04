<?php

namespace App\Entity;

use App\Repository\RegistrationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: RegistrationRepository::class)]
#[ORM\Table(name: 'registrations')]
class Registration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Event::class, inversedBy: 'registrations', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private $event;

    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '#^[a-zA-Z]#',
        htmlPattern: '^[a-zA-Z]'
    )]
    #[ORM\Column(type: 'string', length: 50)]
    private $firstName;
    
    #[Assert\Regex(
        pattern: '#^[a-zA-Z]#',
        htmlPattern: '^[a-zA-Z]'
    )]
    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 50)]
    private $lastName;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'integer')]
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, $payload)
    {
        $quantity = $this->getQuantity();
        if ($quantity > ($this->event->getMaxRegistration() - $this->event->getTotalQuantityRegistrations())) {
            $context->buildViolation('La quantité restante de place n\'est pas suffisante')
                ->atPath('quantity')
                ->addViolation()
            ;
        }
    }
}
