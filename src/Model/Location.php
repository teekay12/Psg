<?php

namespace Kareem\Ta\Model;

class Location {

    public function __construct(public string $postcode, public string $latitude, public string $longitude){
    }
}