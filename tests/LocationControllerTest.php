<?php

namespace Test\Unit;

use PHPUnit\Framework\TestCase;
use Kareem\Ta\Controller\LocationController;
use Kareem\Ta\Service\LocationManager;

class LocationControllerTest extends TestCase
{
    public function testSearchPostcode()
    {
        // Mock LocationManager
        $locationManager = $this->createMock(LocationManager::class);
        
        // Define the expected result from LocationManager
        $expectedResult = ['id' => 1, 'postcode' => 'AB1 0AA', 'latitude' => 57.101474, 'longitude' => -2.242851];
        
        $locationManager->expects($this->once())
            ->method('queryPostcode')
            ->with('AB1 0AA')
            ->willreturn([$expectedResult]);

        $locationController = new LocationController($locationManager);

        // Call the searchPostcode method
        $result = $locationController->searchPostcode('AB1 0AA');

        // Prepare the expected JSON response
        $expectedResponse = json_encode(['result' => [$expectedResult]]);

        // Assert that the result matches the expected JSON response
        $this->assertEquals($expectedResponse, $result);
    }

    public function testSearchCoordinate()
    {
        // Mock LocationManager
        $locationManager = $this->createMock(LocationManager::class);
        
        // Define the expected result from LocationManager
        $expectedResult = ['id' => 1, 'postcode' => 'AB1 0AA', 'latitude' => 57.101474, 'longitude' => -2.242851];
        
        $locationManager->expects($this->once())
            ->method('queryLocation')
            ->with(57.101474, -2.242851, 1)
            ->willreturn([$expectedResult]);

        $locationController = new LocationController($locationManager);

        // Call the searchLocation method
        $result = $locationController->searchLocation(57.101474, -2.242851, 1);

        // Prepare the expected JSON response
        $expectedResponse = json_encode(['result' => [$expectedResult]]);

        // Assert that the result matches the expected JSON response
        $this->assertEquals($expectedResponse, $result);
    }
}