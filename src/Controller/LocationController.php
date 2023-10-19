<?php 

namespace Kareem\Ta\Controller;

use Kareem\Ta\Service\LocationManagerInterface;

class LocationController 
{
    public LocationManagerInterface $locationManger;

    public function __construct(LocationManagerInterface $locationMangerInterface) {
        $this->locationManager = $locationMangerInterface;
    }

    public function searchPostcode(string $query) {
        $result = $this->locationManager->queryPostcode($query);
        return $this->prepareJsonResponse($result);
    } 
    
    public function searchLocation(float $latitude, float $longitude, int $limit) {
        $result = $this->locationManager->queryLocation($latitude, $longitude, $limit);
        return $this->prepareJsonResponse($result);
    }
    
    private function prepareJsonResponse(array $data) {
        header('Content-Type: application/json');
        $response = ['result' => $data];
        return json_encode($response);
    }
}