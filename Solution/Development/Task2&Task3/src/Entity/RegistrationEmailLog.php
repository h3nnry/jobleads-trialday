<?php

namespace App\Entity;

use App\Repository\RegistrationEmailLogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegistrationEmailLogRepository::class)]
#[ORM\Table(name: 'registration_email_log')]
class RegistrationEmailLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email_address = null;

    #[ORM\Column(length: 255)]
    private ?string $email_body = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmailAddress(): ?string
    {
        return $this->email_address;
    }

    public function setEmailAddress(string $email_address): static
    {
        $this->email_address = $email_address;

        return $this;
    }

    public function getEmailBody(): ?string
    {
        return $this->email_body;
    }

    public function setEmailBody(string $email_body): static
    {
        $this->email_body = $email_body;

        return $this;
    }
}
