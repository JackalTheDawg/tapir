<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;


use App\Models\Acceptance;
use App\Models\Car;
use App\Models\User;
use App\Mail\NewAsk;
use App\Mail\FailedRequestToCrm;
use App\Notifications\FailedCrmRequest;


class AcceptanceOfApplication extends Controller
{
    public function acceptance(Request $request){
        $builder = Acceptance::create([
            "phone" => $request -> phone,
            "car_id" => $request -> car
        ]);

        $builder -> car;

        Mail::to("random_mail_adress@mail.com") -> send(new NewAsk($builder));

        $time = Carbon::now() -> addMinutes(5);

        $client = new Client(["http_errors" => false]);
        try{
            do {

                if(Carbon::now() > Carbon::parse($time)){
                    throw new \Exception("Connection timeout");
                }

                $response = $client -> request("POST", config("CRM_URL"), [
                    "json" => [
                        "phone" => $builder -> phone,
                        "VIN" => $builder -> car -> vin
                    ]
                ]);
            } while($response -> getStatusCode() != 200);
        } catch(\Exception $e){
            Mail::to("admin@admin.com") -> send(new FailedRequestToCrm($builder));
            $user = User::find(1);
            $user -> notify(new FailedCrmRequest($data));

            return response(["message" => "Connection timeout"], 408);
        }
        
        return response(["message" => "Successfuly"], 200);
    }
}
