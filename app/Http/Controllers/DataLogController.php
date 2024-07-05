<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class DataLogController extends Controller
{
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

    public function index()
    {
        $title = 'Data Log';
        $reference = $this->database->getReference('DataLog');
        $data = $reference->getValue();

        // Format d_lux to one decimal place
        foreach ($data as &$entry) {
            if (isset($entry['d_lux'])) {
                $entry['d_lux'] = number_format($entry['d_lux'], 1);
            }
        }

        // Sort data by date descending
        usort($data, function ($a, $b) {
            return strtotime($b['d_waktu']) - strtotime($a['d_waktu']);
        });

        return view('data-log', compact('data', 'title'));
    }
}
