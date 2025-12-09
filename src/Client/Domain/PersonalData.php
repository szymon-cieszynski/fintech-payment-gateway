<?php

namespace App\Client\Domain;

class PersonalData
{
    public function __construct(
        public readonly string $firstname,
        public readonly string $surname,
    ) {
        if (empty($this->firstname)) {
            throw new \InvalidArgumentException('Firstname is required for personal clients.');
        }

        if (empty($this->surname)) {
            throw new \InvalidArgumentException('Surname is required for personal clients.');
        }
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getFullname(): string
    {
        return $this->firstname.' '.$this->surname;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }
}
