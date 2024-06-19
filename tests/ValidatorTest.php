<?php

use Designbycode\SouthAfricanIdValidator\SouthAfricanIdValidator;

beforeEach(function () {
    $this->validator = new SouthAfricanIdValidator;
    $this->id = '7804295117087';
    //    $this->id = "9202204720082";
});

it('can equal id number', function () {
    expect($this->id)->toEqual('7804295117087');
});

it('can validate that number has a length of 13', function () {
    expect($this->validator->isLength13($this->id))
        ->toEqual(13);
});

it('can test that ID is a number', function () {
    expect($this->validator->isNumber($this->id))->toBeTrue();
});

it('check if id pass luhna validation', function () {
    expect($this->validator->isValidLuhn($this->id))
        ->toBeTrue();
});

it('can validate if is male', function () {
    expect($this->validator->isMale($this->id))
        ->toBeTrue();
});

it('can validate if is female', function () {
    expect($this->validator->isFemale($this->id))
        ->toBeFalse();
});

it('can determine if the person is a South African citizen', function () {
    expect($this->validator->isSACitizen($this->id))
        ->toBeTrue();
});

it('can determine if the person is a permanent resident', function () {
    expect($this->validator->isPermanentResident($this->id))
        ->toBeFalse();
});

it('can validate ID', function () {
    expect($this->validator->isValid($this->id))->toBeTrue();
});
