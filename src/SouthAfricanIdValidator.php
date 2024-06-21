<?php

namespace Designbycode\SouthAfricanIdValidator;

use Carbon\Carbon;
use Designbycode\LuhnAlgorithm\LuhnAlgorithm;

class SouthAfricanIdValidator
{

    private const GENDER_MALE_MIN = 5000;
    private const GENDER_MALE_MAX = 9999;
    private const GENDER_FEMALE_MIN = 0;
    private const GENDER_FEMALE_MAX = 4999;

    /**
     * @param  mixed  $idNumber
     * @return bool
     *              Check if id is valid
     */
    public function isValid(mixed $idNumber): bool
    {
        $idNumber = $this->trimWhiteSpaces($idNumber);
        return ! (! $this->isLength13($idNumber) || ! $this->isNumber($idNumber) || ! $this->passesLuhnCheck($idNumber));
    }

    // Method to validate if the ID number has a length of 13 digits
    public function isLength13($idNumber): bool
    {
        return strlen((string) $this->trimWhiteSpaces($idNumber)) === 13;
    }

    public function isNumber($idNumber): bool
    {
        return is_numeric($this->trimWhiteSpaces($idNumber));
    }

    // Method to validate the ID number using the Luhn Algorithm
    public function passesLuhnCheck(string $idNumber): bool
    {
        return (new LuhnAlgorithm)->isValid($this->trimWhiteSpaces($idNumber));
    }

    private function extractGenderDigits(string $idNumber): int
    {
        return (int) substr($idNumber, 6, 4);
    }

    // Method to determine if the ID number is for a male
    public function isMale(string $idNumber): bool
    {
        $genderDigits = $this->extractGenderDigits($idNumber);
        return $genderDigits >= self::GENDER_MALE_MIN && $genderDigits <= self::GENDER_MALE_MAX;
    }

    // Method to determine if the ID number is for a female
    public function isFemale(string $idNumber): bool
    {
        $genderDigits = $this->extractGenderDigits($idNumber);
        return $genderDigits >= self::GENDER_FEMALE_MIN && $genderDigits <= self::GENDER_FEMALE_MAX;
    }

    // Method to determine if the person is a South African citizen
    public function isSACitizen($idNumber): bool
    {
        $idNumber = $this->trimWhiteSpaces($idNumber);
        // The 11th digit (index 10) indicates citizenship status
        return $idNumber[10] == '0';
    }

    // Method to determine if the person is a permanent resident
    public function isPermanentResident($idNumber): bool
    {
        $idNumber = $this->trimWhiteSpaces($idNumber);
        // The 11th digit (index 10) indicates citizenship status
        return $idNumber[10] == '1';
    }

    // Method to parse the ID number
    public function parse($idNumber): array
    {
        $idNumber = $this->trimWhiteSpaces($idNumber);
        if (!$this->isValid($idNumber)) {
            throw new \InvalidArgumentException('Invalid ID number');
        }

        $birthDate = $this->extractBirthDate($idNumber);

        // Determine age
        $age = $birthDate->diffInYears(Carbon::now());

        // Determine gender
        $gender = $this->isMale($idNumber) ? 'Male' : 'Female';

        // Determine citizenship
        $citizenship = $this->isSACitizen($idNumber) ? 'SA Citizen' : 'Permanent Resident';

        return [
            'valid' => $this->isValid($idNumber),
            'birthday' => [
                'default' => $birthDate,
                'iso' => $birthDate->format('Y-m-d'),
                'american' => $birthDate->format('m/d/Y'),
                'european' => $birthDate->format('d/m/Y'),
                'long' => $birthDate->format('F j, Y'),
            ],
            'age' => $age,
            'gender' => $gender,
            'citizenship' => $citizenship,
        ];
    }

    private function trimWhiteSpaces(mixed $idNumber): string
    {
        $idNumber = trim((string) $idNumber); // Remove spaces around the string
        return str_replace(' ', '', $idNumber); // Remove spaces within the string
    }

    private function extractBirthDate(string $idNumber): Carbon
    {
        $year = (int) substr($idNumber, 0, 2);
        $month = (int) substr($idNumber, 2, 2);
        $day = (int) substr($idNumber, 4, 2);

        $currentYear = (int) date('Y');
        $year = $year + ($year > substr($currentYear, 2, 2) ? 1900 : 2000);

        return Carbon::createFromDate($year, $month, $day);
    }
}
