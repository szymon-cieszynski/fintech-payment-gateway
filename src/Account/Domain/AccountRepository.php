<?php

namespace App\Account\Domain;

interface AccountRepository
{
    public function save(Account $account): void;
}
