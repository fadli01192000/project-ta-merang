<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $database;

    public function __construct()
    {
        $firebaseConfig = '../project-ta-merang-firebase-adminsdk-i13m6-9a0213bb5c.json';
        if (is_null($firebaseConfig)) {
            throw new \Exception('The Firebase credentials file is not set.');
        }

        $factory = (new Factory)
                    ->withServiceAccount($firebaseConfig)
                    ->withDatabaseUri('https://project-ta-merang-default-rtdb.firebaseio.com');

        $this->database = $factory->createDatabase();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = 'Dashboard';
        $reference = $this->database->getReference('DataLog');
        $data = $reference->getValue();

        // Data Array Kelembapan
        $temp_kelembapan = [];
        if ($data) {
            foreach ($data as $key => $value) {
                if (isset($value['d_kelembapan'])) {
                    $temp_kelembapan[] = $value['d_kelembapan'];
                }
            }
        }
        $temp_kelembapan = array_slice($temp_kelembapan, -10, 10);

        // Data Array LDR
        $temp_ldr = [];
        if ($data) {
            foreach ($data as $key => $value) {
                if (isset($value['d_lux'])) {
                    $temp_ldr[] = (int)$value['d_lux'];
                }
            }
        }
        $temp_ldr = array_slice($temp_ldr, -10, 10);

        // Data Array Suhu
        $temp_suhu = [];
        if ($data) {
            foreach ($data as $key => $value) {
                if (isset($value['d_suhu'])) {
                    $temp_suhu[] = $value['d_suhu'];
                }
            }
        }
        $temp_suhu = array_slice($temp_suhu, -10, 10);

        // Data Array Co2
        $temp_ppm = [];
        if ($data) {
            foreach ($data as $key => $value) {
                if (isset($value['d_ppm'])) {
                    $temp_ppm[] = $value['d_ppm'];
                }
            }
        }
        $temp_ppm = array_slice($temp_ppm, -10, 10);

        // Data Waktu
        $temp_waktu = [];
        if ($data) {
            foreach ($data as $key => $value) {
                if (isset($value['d_waktu'])) {
                    $temp_waktu[] = $value['d_waktu'];
                }
            }
        }
        $temp_waktu = array_slice($temp_waktu, -10, 10);

        return view('dashboard', compact('title','temp_kelembapan','temp_ldr','temp_suhu','temp_ppm','temp_waktu'));
    }
}
