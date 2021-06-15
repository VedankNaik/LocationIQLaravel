<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use \DB;
use Config;
use App\Models\Validation;
use App\Models\LatLonValidation;
use Barryvdh\Debugbar\Facade as Debugbar;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function addressindex()
    {
        dd(Config::get('database.connections.sqlsrv2'));
        $addresses = DB::table('addresses')->where('Validate', '=', 0)->paginate(15);
        return view('forwardgeocode', compact('addresses'));
    }

    public function forwardvalidate()
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $addresses = DB::table('addresses')->where('Validate', '=', 0)->limit(2)->get();

        foreach ($addresses as $address) {
            $query = $address->Street . " " . $address->Zip . " " . $address->Town;
            $response = Http::get('https://localhost:5001/V2/ForwardGeocode?', [
                'q' => $query,
                'limit' => 1,
            ]);

            sleep(2);

            $res = $response['searchResponseLists'][0];

            $validate = new Validation;
            $validate->EGID = $address->EGID;
            $validate->Street = $address->Street;
            $validate->Zip = $address->Zip;
            $validate->Town = $address->Town;
            $validate->PlaceID = $res['PlaceId'];
            $validate->Latitide = $res['Latitude'];
            $validate->Longitude = $res['Longitude'];
            $validate->DisplayName = $res['DisplayName'];
            $validate->Class = $res['class'];
            $validate->Type = $res['type'];
            $validate->Importance = $res['importance'];
            $validate->save();

            if ($validate->save()) {
                DB::table('addresses')->where('EGID', $address->EGID)->update(['Validate' => 1]);
            }
        }
        $addresses = DB::table('validations')->paginate(15);
        return view('forwardvalidated', compact('addresses'));
        // Debugbar::info($res);
    }

    public function forwardvalidated()
    {
        $addresses = DB::table('validations')->paginate(15);
        return view('forwardvalidated', compact('addresses'));
    }

    public function reverseindex()
    {
        $coordinates = DB::table('latlon')->where('Validate', '=', 0)->paginate(15);
        return view('reversegeocode', compact('coordinates'));
    }

    public function reversevalidate()
    {
        $coordinates = DB::table('latlon')->where('Validate', '=', 0)->limit(2)->get();

        foreach ($coordinates as $coordinate) {
            // $query = $coordinate->Street . " " . $coordinate->Zip;
            $response = Http::get('https://localhost:5001/V2/ReverseGeocode?', [
                'lat' => $coordinate->latitude,
                'lon' => $coordinate->longitude,
                'zoom' => 18
            ]);

            sleep(2);

            $res = $response['searchResponse'];
            //dd($res);

            $validate = new LatLonValidation;
            $validate->RefID = $coordinate->ID;
            $validate->City = $coordinate->city;
            $validate->OldLatitude = $coordinate->latitude;
            $validate->OldLongitude = $coordinate->longitude;
            $validate->PlaceID = $res['PlaceId'];
            $validate->NewLatitude = $res['Latitude'];
            $validate->NewLongitude = $res['Longitude'];
            $validate->DisplayName = $res['DisplayName'];
            $validate->Importance = $res['importance'];
            $validate->save();

            if ($validate->save()) {
                DB::table('latlon')->where('ID', $coordinate->ID)->update(['Validate' => 1]);
            }
        }
        $coordinates = DB::table('lat_lon_validations')->paginate(15);
        return view('reversevalidated', compact('coordinates'));
        // Debugbar::info($res);
    }

    public function reversevalidated()
    {
        $coordinates = DB::table('lat_lon_validations')->paginate(15);
        return view('reversevalidated', compact('coordinates'));
    }
}
