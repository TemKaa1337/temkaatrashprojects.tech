<?php

declare(strict_types=1);

namespace App\Trait\DependencyInjection;

use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait ValidatorTrait
{
    private readonly ValidatorInterface $validator;

    #[Required]
    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    private function validate(mixed $value): void
    {
        $errors = $this->validator->validate($value);
        if ($errors->count()) {
            throw new ValidationFailedException($value, $errors);
        }
    }
}
