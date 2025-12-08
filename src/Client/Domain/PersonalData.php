<?php

namespace App\Client\Domain;

use Symfony\Component\Validator\Constraints as Assert;

class PersonalData
{
    public function __construct(
        public readonly string $firstname,
        public readonly string $surname
    ){
//        if ($this->firstname === null) {
//            throw new \InvalidArgumentException('Firstname is required for personal clients.');
//        }
//
//        if ($this->surname === null) {
//            throw new \InvalidArgumentException('Surname is required for personal clients.');
//        }
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }
    public function getFullname(): string
    {
        return $this->firstname . ' ' . $this->surname;
    }
    public function getSurname(): string
    {
        return $this->surname;
    }

}
