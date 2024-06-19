<?php

namespace Designbycode\SouthAfricanIdValidator;

use Designbycode\LuhnAlgorithm\LuhnAlgorithm;

class SouthAfricanIdValidator
{
    /**
     * @param  string  $idNumber
     * @return bool
     * Check if id is valid
     */
    public function isValid(string $idNumber): bool
    {
        return ! (! $this->isLength13($idNumber) || ! $this->isNumber($idNumber) || ! $this->isValidLuhn($idNumber));
    }

    // Method to validate if the ID number has a length of 13 digits
    public function isLength13($idNumber): bool
    {
        return strlen((string) $idNumber) === 13;
    }

    public function isNumber($idNumber): bool
    {
        return is_numeric($idNumber);
    }

    // Method to validate the ID number using the Luhn Algorithm
    public function isValidLuhn(string $idNumber): bool
    {
        return (new LuhnAlgorithm)->isValid($idNumber);
    }

    // Method to determine if the ID number is for a male
    public function isMale($idNumber): bool
    {
        // Extract the gender digits (4 digits after the first 6 digits)
        $genderDigits = substr($idNumber, 6, 4);
        $genderNumber = (int) $genderDigits;

        // Determine if the number falls in the male range
        return ($genderNumber >= 5000) && ($genderNumber <= 9999);
    }

    // Method to determine if the ID number is for a female
    public function isFemale($idNumber): bool
    {
        // Extract the gender digits (4 digits after the first 6 digits)
        $genderDigits = substr($idNumber, 6, 4);
        $genderNumber = (int) $genderDigits;

        // Determine if the number falls in the female range
        return $genderNumber >= 0 && $genderNumber <= 4999;
    }

    // Method to determine if the person is a South African citizen
    public function isSACitizen($idNumber): bool
    {
        // The 11th digit (index 10) indicates citizenship status
        return $idNumber[10] == '0';
    }

    // Method to determine if the person is a permanent resident
    public function isPermanentResident($idNumber): bool
    {
        // The 11th digit (index 10) indicates citizenship status
        return $idNumber[10] == '1';
    }

    // Method to parse the ID number
    public function parse($idNumber): array
    {
        // Check if the ID number is valid
        if (! $this->isValid($idNumber)) {
            return ['error' => 'Invalid ID number'];
        }

        // Extract the birthdate
        $year = substr($idNumber, 0, 2);
        $month = substr($idNumber, 2, 2);
        $day = substr($idNumber, 4, 2);

        // Determine century
        $currentYear = (int) date('Y');
        $year = (int) $year + ($year > substr($currentYear, 2, 2) ? 1900 : 2000);

        $birthDate = sprintf('%04d/%02d/%02d', $year, $month, $day);
        $age = $currentYear - $year;

        // Determine gender
        $gender = $this->isMale($idNumber) ? 'Male' : 'Female';

        // Determine citizenship
        $citizenship = $this->isSACitizen($idNumber) ? 'SA Citizen' : 'Permanent Resident';

        return [
            'valid' => $this->isValid($idNumber),
            'birthday' => $birthDate,
            'age' => $age,
            'gender' => $gender,
            'citizenship' => $citizenship,
        ];
    }
}
