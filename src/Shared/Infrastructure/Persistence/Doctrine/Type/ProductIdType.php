<?php

namespace App\Shared\Infrastructure\Persistence\Doctrine\Type;

use App\SuDespacho\Domain\Product\ValueObject\ProductId;
use Assert\AssertionFailedException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class ProductIdType extends StringType
{
    private const string FIELD_ID = 'id';

    public function getName(): string
    {
        return self::FIELD_ID;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return null === $value || is_string($value)
            ? $value
            : (string) $value->value();
    }

    /**
     * @throws AssertionFailedException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): object
    {
        return ProductId::from($value);
    }

    public function getClassName(): string
    {
        return ProductId::class;
    }
}
