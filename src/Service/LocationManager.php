<?php

namespace Kareem\TA\Service;

use Kareem\Ta\Model\Location;
use Kareem\Ta\Repository\LocationRepository;
use Kareem\Ta\Service\LocationManagerInterface;

class LocationManager implements LocationManagerInterface
{
    private LocationRepository $locationRepository;

    public function __construct(){
        $this->locationRepository = new LocationRepository();
    }

    //Location url
    private string $locationsUrl = "https://parlvid.mysociety.org/os/ONSPD/2022-11.zip";

    // The downloaded zip file
    private string $fileName = "./files/postcodes.zip"; 

    // Extracted file name
    private string $extractedFile = 'Data/ONSPD_NOV_2022_UK.csv';
    
    public function init(){
        $this->download()->extract()->import();
    }

    public function queryPostcode(string $query): array {
        return $this->locationRepository->queryPostcode($query);
    }

    public function queryLocation(float $latitude, float $longitude, int $limit): array {
        return $this->locationRepository->queryLocation($latitude, $longitude, $limit);
    }

    private function download() {
        // Initialize cURL
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $this->locationsUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FILE, fopen($this->fileName, 'w'));

        // Execute the download
        $result = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo "cURL error: " . curl_error($ch);
        } else {
            echo "Download completed successfully.";
        }

        curl_close($ch);
        return $this;
    }

    private function extract() {
        $zip = new \ZipArchive;

        if ($zip->open($this->fileName) === TRUE) {
            $zip->extractTo('./files', $this->extractedFile);

            $zip->close();
        } else {
            echo 'Failed to open the zip file.'."\n";
        }

        return $this;
    }

    private function import(): void {
        if (($file = fopen('./files/'.$this->extractedFile, 'r')) !== false) {
            $header = fgetcsv($file);
            $counter = 0;
            while (($data = fgetcsv($file)) !== false) {
                $postcode = $data[0];
                $latitude = $data[42];
                $longitude = $data[43];

                $this->locationRepository->save(new Location($postcode, $latitude, $longitude));

                if($counter >= 1){
                    die;
                }
                $counter++;
            }

            fclose($handle);
        }
    }
}