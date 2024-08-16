<?php

declare(strict_types=1);

namespace App\Doctrine\Orm\NamingStrategy;

use Doctrine\Inflector\InflectorFactory;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use function sprintf;
use function str_contains;
use function str_replace;
use function strrpos;
use function substr;

final class UnderscorePluralNamingStrategy extends UnderscoreNamingStrategy
{
    public function classToTableName(string $className): string
    {
        if (str_contains($className, 'Entity\\')) {
            $className = substr($className, strrpos($className, 'Entity\\') + 7);
            $className = str_replace('\\', '_', $className);
        }

        $name = parent::classToTableName($className);

        return InflectorFactory::create()->build()->pluralize($name);
    }

    public function joinKeyColumnName(string $entityName, ?string $referencedColumnName = null): string
    {
        return sprintf(
            '%s_%s',
            $this->classToTableName($entityName),
            $referencedColumnName ?: $this->referenceColumnName(),
        );
    }
}
