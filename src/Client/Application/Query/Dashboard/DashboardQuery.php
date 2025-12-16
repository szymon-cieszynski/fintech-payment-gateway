<?php

namespace App\Client\Application\Query\Dashboard;

final class DashboardQuery
{
    public function __construct(
        public readonly int $clientID
    )
    {}
}
