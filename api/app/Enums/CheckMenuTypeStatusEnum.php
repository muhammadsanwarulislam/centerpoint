<?php
namespace App\Enums;

class CheckMenuTypeStatusEnum
{
    const PARENT = 'Parent';
    const CHILD = 'Child';

    public static function toArray(): array
    {
        return [
            self::PARENT,
            self::CHILD,
        ];
    }
}
