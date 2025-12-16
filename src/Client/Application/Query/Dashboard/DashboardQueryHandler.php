<?php

namespace App\Client\Application\Query\Dashboard;

use Doctrine\DBAL\Connection;

final class DashboardQueryHandler
{
    public function __construct(
        private Connection $connection
    )
    {}

    public function __invoke(DashboardQuery $query): DashboardView
    {
        $client = $this->connection->fetchAssociative('SELECT client_type, personal_data_firstname, business_data_company_name
             FROM client WHERE id = :id',
            ['id' => $query->clientID]
        );

        $accounts = $this->connection->fetchAllAssociative(
            'SELECT id, currency, balance, status, iban
             FROM accounts WHERE client_id = :id',
            ['id' => $query->clientID]
        );

        $clientName = $client['client_type'] === 'BUSINESS'
            ? $client['business_data_company_name']
            : $client['personal_data_firstname'];

        $accountViews = [];

        foreach ($accounts as $a) {
            $accountViews[] = new AccountView(
                $a['id'],
                $a['currency'],
                (int) $a['balance'],
                $a['status'],
                $a['iban']
            );
        }
        return new DashboardView($clientName, $accountViews);

    }
}
