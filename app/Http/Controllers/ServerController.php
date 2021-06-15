<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Input;
use Config;
use Session;
use Schema;
use \DB;
use App\Models\Validation;
use App\Models\LatLonValidation;
use Barryvdh\Debugbar\Facade as Debugbar;

class ServerController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $db;
    public $config;

    public function index()
    {
        if (Session::has('sqlsrv')) {
            $result = collect([]);
            $request = "";
            Config::set('database.connections.sqlsrv', Session::get('sqlsrv'));
            DB::reconnect();
            // dd(DB::connection('sqlsrv')->getPdo());
            return view('server.dashboard');
        // return view('operations', compact('result'));
        } else {
            return view('server.connectionform');
        }
    }

    public function disconnect()
    {
        Session::forget('sqlsrv');
        Session::forget('db');
        return view('welcome');
    }

    public function testconnection(Request $request)
    {
        try {
            Config::set(['database.connections.sqlsrv'=>
                  [
                    "driver" => "sqlsrv",
                    "url" => null,
                    "host"     => $request->host,
                    // "port" => "1433",
                    "database" => $request->database,
                    "username" => $request->username,
                    "password" => $request->password,
                    "charset" => "utf8",
                    "prefix" => "",
                    "prefix_indexes" => true,
                 ]
               ]);
            
            // DB::purge('sqlsrv');
            DB::reconnect();
            DB::connection()->getPdo();
            if (DB::connection('sqlsrv')->getPdo()) {
                Session::put('sqlsrv', Config::get('database.connections.sqlsrv'));
                Session::put('db', $request->database);
                // dd(DB::connection()->getDatabaseName());
                return redirect()->back()->withInput($request->all())->with('Success', 'Connection successful');
            } else {
                return redirect()->back()->withInput($request->all())->with('Error', 'Connection unsuccessful');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->all())->with('Error', $e->getMessage());
        }
    }

    public function forwardquery(Request $request)
    {
        try {
            if (Session::has('sqlsrv')) {
                Config::set('database.connections.sqlsrv', Session::get('sqlsrv'));
                DB::reconnect();
                $addresses = DB::select($request->input('query'));
                $columns = Schema::getColumnListing($request->input('selecttable'));
                return view('server.forwardgeocode', compact('addresses', 'columns', 'request'));
            } else {
                return redirect()->back()->with('Error', 'Session expired');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->all())->with('Error', $e->getMessage());
        }
    }

    public function reversequery(Request $request)
    {
        try {
            if (Session::has('sqlsrv')) {
                Config::set('database.connections.sqlsrv', Session::get('sqlsrv'));
                DB::reconnect();
                $coordinates = DB::select($request->input('query'));
                $columns = Schema::getColumnListing($request->input('selecttable'));
                return view('server.reversegeocode', compact('coordinates', 'columns', 'request'));
            } else {
                return redirect()->back()->with('Error', 'Session expired');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->all())->with('Error', $e->getMessage());
        }
    }

    public function forwardindex()
    {
        try {
            if (Session::has('sqlsrv')) {
                Config::set('database.connections.sqlsrv', Session::get('sqlsrv'));
                DB::reconnect();
                $addresses = collect([]);
                return view('server.forwardgeocode', compact('addresses'));
            } else {
                return view('server.connectionform');
            }
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('Error', $e->getMessage());
        }
    }

    public function forwardvalidate(Request $request)
    {
        try {
            switch ($request->input('action')) {
                case 'validate':
                if (Session::has('sqlsrv')) {
                    Config::set('database.connections.sqlsrv', Session::get('sqlsrv'));
                    DB::reconnect();
                    $addresses = DB::select($request->input('query'));
                    $addresses = array_slice($addresses, 0, 2);
                    $columns = Schema::getColumnListing($request->input('selecttable'));
                    if (count($addresses)>=1) {
                        if (!isset($addresses[0] -> EGID)
                        or !isset($addresses[0] -> Street)
                        or !isset($addresses[0] -> Zip)
                        or !isset($addresses[0] -> Town)) {
                            dd('fail');
                        } else {
                            foreach ($addresses as $address) {
                                $query = $address->Street . " " . $address->Zip . " " . $address->Town;
                                $response = Http::get('https://localhost:5001/V2/ForwardGeocode?', [
                                'q' => $query,
                                'limit' => 1,
                            ]);
                
                                sleep(1);
                
                                $res = $response['searchResponseLists'][0];

                                $insert = DB::table($request->input('inserttable'))->insert([
                            'EGID' => $address->EGID,
                            'Street' => $address->Street,
                            'Zip' => $address->Zip,
                            'Town' => $address->Town,
                            'PlaceID' => $res['PlaceId'],
                            'Latitide' => $res['Latitude'],
                            'Longitude' => $res['Longitude'],
                            'DisplayName' => $res['DisplayName'],
                            'Class' => $res['class'],
                            'Type' => $res['type'],
                            'Importance' => $res['importance'],
        
                            ]);
                
                                if ($insert) {
                                    DB::table($request->input('selecttable'))->where('EGID', $address->EGID)->update(['Validate' => 1]);
                                }
                            }
                        }
                    }

                    $addresses = DB::table($request->input('inserttable'))->paginate(15);
                    $columns = Schema::getColumnListing($request->input('inserttable'));
                    return view('server.forwardvalidated', compact('addresses', 'columns'));
                // Debugbar::info($res);
                } else {
                    return view('server.connectionform');
                }
                break;
                
                case 'validated':
                    return $this->forwardvalidated($request);
                break;
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('Error', $e->getMessage());
        }
    }

    public function forwardvalidated(Request $request)
    {
        try {
            if (Session::has('sqlsrv')) {
                Config::set('database.connections.sqlsrv', Session::get('sqlsrv'));
                DB::reconnect();
                $addresses = DB::table($request->input('inserttable'))->paginate(15);
                $columns = Schema::getColumnListing($request->input('inserttable'));
                // dd($columns);
                return view('server.forwardvalidated', compact('addresses', 'columns'));
            } else {
                return view('server.connectionform');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('Error', $e->getMessage());
        }
    }

    public function reverseindex()
    {
        try {
            if (Session::has('sqlsrv')) {
                Config::set('database.connections.sqlsrv', Session::get('sqlsrv'));
                DB::reconnect();
                $coordinates = collect([]);
                return view('server.reversegeocode', compact('coordinates'));
            } else {
                return view('server.connectionform');
            }
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('Error', $e->getMessage());
        }
    }

    public function reversevalidate(Request $request)
    {
        try {
            switch ($request->input('action')) {
                case 'validate':
                    
                if (Session::has('sqlsrv')) {
                    Config::set('database.connections.sqlsrv', Session::get('sqlsrv'));
                    DB::reconnect();
                    $coordinates = DB::select($request->input('query'));
                    $coordinates = array_slice($coordinates, 0, 2);
                    $columns = Schema::getColumnListing($request->input('selecttable'));

                    if (count($coordinates)>=1) {
                        if (!isset($coordinates[0] -> ID)
                        or !isset($coordinates[0] -> city)
                        or !isset($coordinates[0] -> latitude)
                        or !isset($coordinates[0] -> longitude)) {
                            dd('fail');
                        } else {
                            // dd('pass');
                            foreach ($coordinates as $coordinate) {
                                // $query = $coordinate->Street . " " . $coordinate->Zip;
                                $response = Http::get('https://localhost:5001/V2/ReverseGeocode?', [
                                    'lat' => $coordinate->latitude,
                                    'lon' => $coordinate->longitude,
                                    'zoom' => 18
                                ]);
                
                                sleep(1);
                
                                $res = $response['searchResponse'];
                                $insert = DB::table($request->input('inserttable'))->insert([
                                    'RefID' =>  $coordinate->ID,
                                    'City' => $coordinate->city,
                                    'OldLatitude' =>  $coordinate->latitude,
                                    'OldLongitude' => $coordinate->longitude,
                                    'PlaceID' =>  $res['PlaceId'],
                                    'NewLatitude' => $res['Latitude'],
                                    'NewLongitude' => $res['Longitude'],
                                    'DisplayName' => $res['DisplayName'],
                                    'Importance' => $res['importance'],
                
                                ]);
                
                                if ($insert) {
                                    DB::table($request->input('selecttable'))->where('ID', $coordinate->ID)->update(['Validate' => 1]);
                                }
                            }
                        }
                    }

                    $coordinates = DB::table($request->input('inserttable'))->paginate(15);
                    $columns = Schema::getColumnListing($request->input('inserttable'));
                    return view('server.reversevalidated', compact('coordinates', 'columns'));
                // Debugbar::info($res);
                } else {
                    return view('server.connectionform');
                }
                break;
                
                case 'validated':
                    return $this->reversevalidated($request);
                break;
            }
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('Error', $e->getMessage());
        }
    }

    public function reversevalidated(Request $request)
    {
        try {
            if (Session::has('sqlsrv')) {
                Config::set('database.connections.sqlsrv', Session::get('sqlsrv'));
                DB::reconnect();
                $coordinates = DB::table($request->input('inserttable'))->paginate(15);
                $columns = Schema::getColumnListing($request->input('inserttable'));
                // dd($columns);
                return view('server.reversevalidated', compact('coordinates', 'columns'));
            } else {
                return view('server.connectionform');
            }
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('Error', $e->getMessage());
        }
    }
}
