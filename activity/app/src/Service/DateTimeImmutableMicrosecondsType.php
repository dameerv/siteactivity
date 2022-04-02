<?php

namespace App\Service;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Types\VarDateTimeImmutableType;
use DateTimeImmutable;

class DateTimeImmutableMicrosecondsType extends VarDateTimeImmutableType
{
    /**
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof DateTimeImmutable &&
            ($platform instanceof PostgreSqlPlatform || $platform instanceof MySQLPlatform)
        ) {
            $dateTimeFormat = $platform->getDateTimeFormatString();

            return $value->format("{$dateTimeFormat}.u");
        }

        return parent::convertToDatabaseValue($value, $platform);
    }
}