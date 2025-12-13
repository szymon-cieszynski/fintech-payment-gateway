<?php

namespace App\Tests\Client\Domain;

use App\Client\Domain\BusinessData;
use PHPUnit\Framework\TestCase;

class BusinessDataTest extends TestCase
{
    public function testThrowsExceptionWhenNIPIsEmpty(): void
    {
        $this->expectException(\DomainException::class);
        new BusinessData('MyBeautifulCompany', '');
    }

    public function testThrowsExceptionWhenCompanyNameIsEmpty(): void
    {
        $this->expectException(\DomainException::class);
        new BusinessData('', '123456789');
    }
}
