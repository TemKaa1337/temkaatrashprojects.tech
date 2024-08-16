<?php

declare(strict_types=1);

namespace App\Model;

use App\Enum\ErrorCode;
use App\Enum\Language;
use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

final class GithubRepo
{
    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value)]
    #[Assert\Url(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_AN_URL->value)]
    #[SerializedName('clone_url')]
    public string $cloneUrl;

    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value)]
    #[SerializedName('created_at')]
    public DateTimeImmutable $createdAt;

    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value, allowNull: true)]
    #[SerializedName('description')]
    public ?string $description;

    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value)]
    #[SerializedName('id')]
    public int $githubId;

    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value, allowNull: true)]
    #[SerializedName('language')]
    public ?Language $language;

    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value)]
    #[SerializedName('name')]
    public string $name;

    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value)]
    #[SerializedName('updated_at')]
    public DateTimeImmutable $updatedAt;

    #[Assert\NotBlank(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_BLANK->value)]
    #[Assert\Url(message: ErrorCode::VALIDATION_CONSTRAINT_NOT_AN_URL->value)]
    #[SerializedName('html_url')]
    public string $viewUrl;
}
