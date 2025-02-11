<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

use App\Models\Car;
use SimpleXMLElement;

class ExportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for get data from https://tapir.ws/files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $json_response = $client -> request("GET", "https://tapir.ws/files/new_cars.json");

        $jsons_for_insert = [];
        $null_fields = [
            "year" => null,
            "mileage" => null
        ];
        $json_array = json_decode($json_response -> getBody(), true);

        foreach($json_array as $json){
            array_push($jsons_for_insert, array_merge($json, $null_fields));
        }

        $xml_response = $client -> request("GET", "https://tapir.ws/files/used_cars.xml");

        $xml_array = [];
        $xml_string = simplexml_load_string($xml_response -> getBody());

        foreach($xml_string -> vehicle as $car){
            $xml_to_array = json_decode(json_encode($car), true);
            array_push($xml_array, $xml_to_array);
        }

        $items = array_merge($xml_array, $jsons_for_insert);
        Car::insert($items);
        
    }
}
