<?php

use Designbycode\SouthAfricanIdValidator\SouthAfricanIdValidator;

beforeEach(function () {
    $this->validator = new SouthAfricanIdValidator;
    $this->id = '921223 0051 08 0';

});

it('can validate that number has a length of 13', function ($id) {
    expect($this->validator->isLength13($id))
        ->toEqual(13);
})->with(['6901240689086', '8907290565082', '7809090453082', 9108200519082, '900601 0051 08 2']);

it('can test that ID is a number', function () {
    expect($this->validator->isNumber($this->id))->toBeTrue();
});

it('check if id pass luhna validation', function () {
    expect($this->validator->passesLuhnCheck($this->id))
        ->toBeTrue();
});

it('can validate if is male', function () {
    expect($this->validator->isMale($this->id))
        ->toBeFalse();
});

it('can validate if is female', function () {
    expect($this->validator->isFemale($this->id))
        ->toBeTrue();
});

it('can determine if the person is a South African citizen', function ($id) {
    expect($this->validator->isSACitizen($id))
        ->toBeTrue();
})->with(['690124 0689 08 6', 8907290565082, '7809090453082', '9108200519082', '9006010051082']);

it('can determine if the person is a permanent resident', function ($id) {
    expect($this->validator->isPermanentResident($id))
        ->toBeFalse();
})->with(['6901240689086', '8907290565082', '7809090453082', 9108200519082, '9006010051082']);

it('can validate ID', function () {
    expect($this->validator->isValid($this->id))->toBeTrue();
});

it('can validate list of ID', function ($value) {
    expect($this->validator->isValid($this->id))->toBeTrue();
})->with(['690124 0689 08 6', '8907290565082', '7809090453082', 9108200519082, '9006010051082']);

it('parses a valid ID number', function () {
    $result = $this->validator->parse($this->id);
    expect($result['valid'])->toBeTrue()
        ->and($result['birthday']['default'])->toBeString(Carbon\Carbon::class)
        ->and($result['age'])->toBeGreaterThan(0)
        ->and($result['gender'])->toBeString()
        ->and($result['citizenship'])->toBeString();
});

it('should equal date of ISO from', function () {
    $result = $this->validator->parse($this->id);
    expect($result['birthday']['iso'])->toEqual('1992-12-23');
});

it('should equal date of american from', function () {
    $result = $this->validator->parse($this->id);
    expect($result['birthday']['american'])->toEqual('12/23/1992');
});

it('should equal date of european from', function () {
    $result = $this->validator->parse($this->id);
    expect($result['birthday']['european'])->toEqual('23/12/1992');
});

it('should equal date of long format from', function () {
    $result = $this->validator->parse($this->id);
    expect($result['birthday']['long'])->toEqual('December 23, 1992');
});
