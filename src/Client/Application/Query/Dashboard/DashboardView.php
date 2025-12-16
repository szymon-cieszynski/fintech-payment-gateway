<?php

namespace App\Client\Application\Query\Dashboard;

final class DashboardView
{
    public function __construct(
        public readonly string $clientName,
        /** @var AccountView[] */
        public readonly array $accounts,
    ) {}
}
