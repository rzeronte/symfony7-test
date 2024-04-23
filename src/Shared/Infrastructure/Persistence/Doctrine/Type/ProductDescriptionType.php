<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Type;

use App\SuDespacho\Domain\Product\ValueObject\ProductDescription;
use Assert\AssertionFailedException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class ProductDescriptionType extends StringType
{
    private const string FIELD_ID = 'description';

    /** @throws AssertionFailedException */
    public function convertToPHPValue($value, AbstractPlatform $platform): ProductDescription
    {
        return ProductDescription::from((string) $value);
    }

    public function getName(): string
    {
        return self::FIELD_ID;
    }
}
