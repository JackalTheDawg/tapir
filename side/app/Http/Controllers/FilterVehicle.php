<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Car;


class FilterVehicle extends Controller
{
    public function filter(Request $request){
        $args = $request -> all();

        $query = DB::table('cars');
        $range = [];
        $keys = array_keys($args);

        foreach($keys as $arg){
            $params = explode('_', $arg);
            if(!isset($params[1])){
                $query -> where($params[0], "LIKE", "%{$args[$arg]}%");
            } else if(in_array($params[1], ["from", "to"])){
                isset($range[$params[0]]) 
                    ? $range[$params[0]][$params[1]] = $args[$arg]
                    : $range[$params[0]] = [$params[1] => $args[$arg]];
            } else if(in_array($params[1], ["less", "more"])){
                $comparison = $params[1] === 'less' ? '<' : '>';
                $query -> where($params[0], $comparison, $args[$arg]);
            }
        }

        if(count($range) > 0){
            $range_keys = array_keys($range);
            foreach($range_keys as $key){
                $query -> whereBetween($key, [$range[$key]["from"], $range[$key]["to"]]);
            }
        }

        return $query -> paginate(200);
    }

}
