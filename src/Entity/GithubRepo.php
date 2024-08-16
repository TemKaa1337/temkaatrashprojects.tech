<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\ErrorCode;
use App\Enum\Language;
use App\Repository\GithubRepoRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[Entity(repositoryClass: GithubRepoRepository::class)]
#[UniqueEntity(fields: ['githubId'])]
class GithubRepo
{
    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value)]
    #[Assert\Url(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_AN_URL->value)]
    #[ORM\Column]
    private string $cloneUrl;

    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value)]
    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value, allowNull: true)]
    #[Assert\Url(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_AN_URL->value)]
    #[ORM\Column(nullable: true)]
    private ?string $demoUrl = null;

    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value, allowNull: true)]
    #[ORM\Column(nullable: true)]
    private ?string $description;

    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value)]
    #[ORM\Column]
    private int $githubId;

    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    private int $id;

    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value, allowNull: true)]
    #[ORM\Column(nullable: true)]
    private ?Language $language;

    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value)]
    #[ORM\Column]
    private string $name;

    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value)]
    #[ORM\Column]
    private DateTimeImmutable $updatedAt;

    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value)]
    #[Assert\Url(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_AN_URL->value)]
    #[ORM\Column]
    private string $viewUrl;

    public function getCloneUrl(): string
    {
        return $this->cloneUrl;
    }

    public function setCloneUrl(string $cloneUrl): self
    {
        $this->cloneUrl = $cloneUrl;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDemoUrl(): ?string
    {
        return $this->demoUrl;
    }

    public function setDemoUrl(?string $demoUrl): self
    {
        $this->demoUrl = $demoUrl;

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

    public function getGithubId(): int
    {
        return $this->githubId;
    }

    public function setGithubId(int $githubId): self
    {
        $this->githubId = $githubId;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getViewUrl(): string
    {
        return $this->viewUrl;
    }

    public function setViewUrl(string $viewUrl): self
    {
        $this->viewUrl = $viewUrl;

        return $this;
    }
}
