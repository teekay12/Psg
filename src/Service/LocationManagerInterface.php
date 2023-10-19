<?php

namespace Kareem\Ta\Service;

Interface LocationManagerInterface {
    public function init();
    public function queryPostcode(string $query): array;
    public function queryLocation(float $latitude, float $longitude, int $limit): array;
}