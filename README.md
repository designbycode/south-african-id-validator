# South African ID Validator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/designbycode/south-african-id-validator.svg?style=flat-square)](https://packagist.org/packages/designbycode/south-african-id-validator)
[![Tests](https://img.shields.io/github/actions/workflow/status/designbycode/south-african-id-validator/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/designbycode/south-african-id-validator/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/designbycode/south-african-id-validator.svg?style=flat-square)](https://packagist.org/packages/designbycode/south-african-id-validator)

The South African ID Validator is a PHP class that validates and extracts information from South African ID numbers. It uses the Luhn Algorithm to validate the ID number and provides methods to determine the gender, citizenship, and birthdate of the individual.

## Installation

You can install the package via composer:

```bash
composer require designbycode/south-african-id-validator
```

## Usage


### Instantiation

To use the South African ID Validator, create an instance of the `SouthAfricanIdValidator` class:
```php
$validator = new SouthAfricanIdValidator();
```
### Validation

To validate an ID number, use the `isValid` method:
```php
$idNumber = '9404260051081';
if ($validator->isValid($idNumber)) {
    echo 'ID number is valid';
} else {
    echo 'ID number is invalid';
}
```
### Parsing

To extract information from a valid ID number, use the `parse` method:
```php
$idNumber = '9404260051081';
$parsedData = $validator->parse($idNumber);
print_r($parsedData);
```
Output:
```
Array
(
    [valid] => 1
    [birthday] => Arrya(
        'default' => '1978-04-29',
        'iso' => '1978-04-29',
        'american' => '04/29/1978',
        'european' => '04/29/1978',
        'long' => 'April 29, 1978',
    )
    [age] => 28
    [gender] => Male
    [citizenship] => SA Citizen
)
```
### Gender Determination

To determine the gender of the individual, use the `isMale` or `isFemale` methods:
```php
$idNumber = '9404260051081';
if ($validator->isMale($idNumber)) {
    echo 'Male';
} else {
    echo 'Female';
}
```
### Citizenship Determination

To determine the citizenship of the individual, use the `isSACitizen` or `isPermanentResident` methods:
```php
$idNumber = '9404260051081';
if ($validator->isSACitizen($idNumber)) {
    echo 'SA Citizen';
} else {
    echo 'Permanent Resident';
}
```
**Methods**
---------

### `isValid(mixed $idNumber): bool`

Validates the ID number using the Luhn Algorithm and checks if it has a length of 13 digits and is numeric.

### `isLength13(mixed $idNumber): bool`

Checks if the ID number has a length of 13 digits.

### `isNumber(mixed $idNumber): bool`

Checks if the ID number is numeric.

### `passesLuhnCheck(mixed $idNumber): bool`

Validates the ID number using the Luhn Algorithm.

### `isMale(mixed $idNumber): bool`

Determines if the ID number is for a male.

### `isFemale(mixed $idNumber): bool`

Determines if the ID number is for a female.

### `isSACitizen(mixed $idNumber): bool`

Determines if the ID number is for a South African citizen.

### `isPermanentResident(mixed $idNumber): bool`

Determines if the ID number is for a permanent resident.

### `parse(mixed $idNumber): array`

Parses the ID number and returns an array with the following information:

* `valid`: A boolean indicating if the ID number is valid.
* `birthday`: The birthdate in the format `YYYY/MM/DD`.
* `age`: The age of the individual.
* `gender`: The gender of the individual (Male or Female).
* `citizenship`: The citizenship status of the individual (SA Citizen or Permanent Resident).

**Use Cases**
------------

### Validating ID numbers in a registration form

Use the `isValid` method to validate ID numbers in a registration form to ensure that only valid ID numbers are accepted.

### Extracting information from ID numbers

Use the `parse` method to extract information from ID numbers, such as birthdate, age, gender, and citizenship, to populate user profiles or perform analytics.

### Determining gender and citizenship

Use the `isMale`, `isFemale`, `isSACitizen`, and `isPermanentResident` methods to determine the gender and

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Claude Myburgh](https://github.com/claudemyburgh)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
