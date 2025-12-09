<?php

namespace App\Tests\Client\Domain;

use App\Client\Domain\PersonalData;
use PHPUnit\Framework\TestCase;

class PersonalDataTest extends TestCase
{
    public function testThrowsExceptionWhenFirstnameIsEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new PersonalData('', 'Doe');
    }

    public function testThrowsExceptionWhenSurnameIsEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new PersonalData('John', '');
    }
}
