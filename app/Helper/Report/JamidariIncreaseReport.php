<?php

namespace App\Helper\Report;

use App\PositionInformation;
use Illuminate\Support\Carbon;

class JamidariIncreaseReport
{
    protected $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
        $this->start_date = date('Y-m-d', strtotime($filter['start_date']));
        $this->end_date = date('Y-m-d', strtotime($filter['end_date']));
    }


    function generateReport()
    {

        $table = [];

        // fetch all clients/position holders
        $clients = PositionInformation::where('status', 1)->select(['Code', 'Name','BusinessStart', 'incrRate'])->get();

        // loop through clients and compare date after adding year
        foreach ($clients as $client) {

            // if no start date then skip
            if ($client->BusinessStart == null) {
                continue;
            }

            $client_start_date_carbon = Carbon::parse($client->BusinessStart)->addYear($client->AggTwo);
            $client_increase_date = $client_start_date_carbon->format('Y-m-d');


            if(!($client_increase_date >= $this->start_date && $client_increase_date <= $this->end_date)){
                continue;
            }

            $ld = [
                'client' => $client,
                'increase_date' => $client_start_date_carbon->format('d-m-Y'),
            ];

            array_push($table, $ld);
        }


        return $table;
    }


    function getReport()
    {

        $table = $this->generateReport();
        return $table;
    }
}
