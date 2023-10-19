<?php

namespace Kareem\Ta\Repository;

use Kareem\Ta\App\SQLiteConnection;
use Kareem\Ta\Model\Location;

class LocationRepository 
{
    private $db;
    
    public function __construct(){
        $this->db = (SQLiteConnection::getinstance())->getConnection();
    }

    public function queryPostcode(string $query): array {
        $query = '%'.$query.'%';
        $sql = "SELECT * FROM locations WHERE postcode LIKE :query";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':query', $query);
        $stmt->execute();
        $results = [];
        while($result = $stmt->fetch(\PDO::FETCH_ASSOC)){
            $results[] = $result; 
        };

        return $results;
    }

    public function queryLocation(float $userLatitude, float $userLongitude, int $limit = 10): array {
        $searchRadius = 5;
        $sql = "SELECT * FROM (
            SELECT postcode, latitude, longitude,
                (6371 * ACOS(COS(RADIANS(:userLatitude)) * COS(RADIANS(latitude)) * COS(RADIANS(longitude) - RADIANS(:userLongitude)) + SIN(RADIANS(:userLatitude)) * SIN(RADIANS(latitude)))) AS distance
            FROM locations
        ) AS subquery
        WHERE distance <= :searchRadius
        ORDER BY distance
        LIMIT :show";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':userLatitude', $userLatitude, \PDO::PARAM_STR);
        $stmt->bindParam(':userLongitude', $userLongitude, \PDO::PARAM_STR);
        $stmt->bindParam(':searchRadius', $searchRadius, \PDO::PARAM_INT);
        $stmt->bindParam(':show', $limit, \PDO::PARAM_INT);

        $stmt->execute();
        $results = [];
        while($result = $stmt->fetch(\PDO::FETCH_ASSOC)){
            $results[] = $result; 
        };
        
        return $results;
    }

    public function save(Location $location): void {
        $data = [
            'postcode' => $location->postcode,
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
        ];
        $sql = "INSERT INTO locations (postcode, latitude, longitude) VALUES (:postcode, :latitude, :longitude)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
    }

}