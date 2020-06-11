<?php

namespace App\Http\Controllers;

use App\CovidData;
use App\Country;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function changeCountryAPI($name){
        if($name == 'Global'){
            $countries = Country::all()->sortBy('name');
            $total_cases = 0;
            $new_cases = 0;
            $total_recovered = 0;
            $new_recovered = 0;
            $total_deaths = 0;
            $new_deaths = 0;
            foreach($countries as $country){
                $data = $country->covidData()->orderBy('date', 'desc')->take(2)->get();
                if(count($data)){
                    $total_cases += $data[0]->total_confirmed;
                    $new_cases += $data[0]->total_confirmed - $data[1]->total_confirmed;
                    $total_recovered += $data[0]->total_recovered;
                    $new_recovered += $data[0]->total_recovered - $data[1]->total_recovered;
                    $total_deaths += $data[0]->total_deaths;
                    $new_deaths += $data[0]->total_deaths - $data[1]->total_deaths;
                }
            }
            $jsonObj[] = [
                'total_cases' => $total_cases,
                'new_cases' => $new_cases,
                'total_recovered' => $total_recovered,
                'new_recovered' => $new_recovered,
                'total_deaths' => $total_deaths,
                'new_deaths' => $new_deaths,
                'active_cases' => $total_cases - $total_recovered - $total_deaths,
                'new_active_cases' => $new_cases - $new_recovered - $new_deaths
            ];
            return json_encode($jsonObj);
        }
        $country = Country::where('name', $name)->first();
        if($country != []){
            $data = $country->covidData()->orderBy('date', 'desc')->take(2)->get();
            if(count($data)){
                $total_cases = $data[0]->total_confirmed;
                $new_cases = $data[0]->total_confirmed - $data[1]->total_confirmed;
                $total_recovered = $data[0]->total_recovered;
                $new_recovered = $data[0]->total_recovered - $data[1]->total_recovered;
                $total_deaths = $data[0]->total_deaths;
                $new_deaths = $data[0]->total_deaths - $data[1]->total_deaths;
                $jsonObj[] = [
                    'total_cases' => $total_cases,
                    'new_cases' => $new_cases,
                    'total_recovered' => $total_recovered,
                    'new_recovered' => $new_recovered,
                    'total_deaths' => $total_deaths,
                    'new_deaths' => $new_deaths,
                    'active_cases' => $total_cases - $total_recovered - $total_deaths,
                    'new_active_cases' => $new_cases - $new_recovered - $new_deaths
                ];
                return json_encode($jsonObj);
            }
            else{
                return "Error";
            }
        }
        else{
            return "Error";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  void
     * @return view
     */
    public function show()
    {
        //
        $countries = Country::all()->sortBy('name');
        $total_cases = 0;
        $new_cases = 0;
        $total_recovered = 0;
        $new_recovered = 0;
        $total_deaths = 0;
        $new_deaths = 0;
        foreach($countries as $country){
            $data = $country->covidData()->orderBy('date', 'desc')->take(2)->get();
            if(count($data)){
                $total_cases += $data[0]->total_confirmed;
                $new_cases += $data[0]->total_confirmed - $data[1]->total_confirmed;
                $total_recovered += $data[0]->total_recovered;
                $new_recovered += $data[0]->total_recovered - $data[1]->total_recovered;
                $total_deaths += $data[0]->total_deaths;
                $new_deaths += $data[0]->total_deaths - $data[1]->total_deaths;
            }
        }
        return view('main', ['countries'=>$countries, 'total_cases'=>$total_cases, 'new_cases'=>$new_cases, 'total_recovered'=>$total_recovered, 'new_recovered'=>$new_recovered, 'total_deaths'=>$total_deaths, 'new_deaths'=>$new_deaths]);
    }

    /**
     * Update all the data from an api and populate the tables if they are empty
     *
     * @param void
     * @return void
     */
    public static function updateAll(){
        $countries = Country::all();
        $countriesTest = $countries->first();
        if($countriesTest == Null){
            $this->populateTables();
        }
        else{
            $this->updateData($countries);
        }
    }

    private function populateTables(){

        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.covid19api.com/countries');
        $responseDecoded = json_decode($response->getBody(), true);
        foreach($responseDecoded as $i){
            $country = new Country();
            $country->name = $i['Country'];
            $country->code = $i['ISO2'];
            $country->slug = $i['Slug'];
            $country->save();
            
            $response = $client->request('GET', 'https://api.covid19api.com/total/dayone/country/'.$country->slug);
            $data = json_decode($response->getBody(), true);
            if($data == []){
                continue;
            }
            else{
                foreach($data as $d){
                    $covidData = new CovidData();
                    $covidData->country()->associate($country);
                    $covidData->total_confirmed = $d['Confirmed'];
                    $covidData->total_recovered = $d['Recovered'];
                    $covidData->total_deaths = $d['Deaths'];
                    $covidData->date = date("Y-m-d H:i:s", strtotime($d['Date']));
                    $covidData->save();
                }
            }
            
        }
    }

    private function updateData($countries){
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', '-1');

        $client = new \GuzzleHttp\Client();
        foreach($countries as $country){
            $covidData = $country->covidData()->orderBy('date', 'desc')->first();
            if($covidData == []){
                $response = $client->request('GET', 'https://api.covid19api.com/total/dayone/country/'.$country->slug);
                $data = json_decode($response->getBody(), true);
                if($data == []){
                    continue;
                }
                else{
                    foreach($data as $d){
                        $covidData = new CovidData();
                        $covidData->country()->associate($country);
                        $covidData->total_confirmed = $d['Confirmed'];
                        $covidData->total_recovered = $d['Recovered'];
                        $covidData->total_deaths = $d['Deaths'];
                        $covidData->date = date("Y-m-d H:i:s", strtotime($d['Date']));
                        $covidData->save();
                    }
                }
            }
            else{
                $dateInTheirFormat = date('Y-m-d', strtotime($covidData->date)).'T'.date('H:i:s', strtotime($covidData->date)).'Z';
                $currDateInTheirFormat = date('Y-m-d', strtotime(Carbon::now()->toDateTimeString())).'T'.date('H:i:s', strtotime(Carbon::now()->toDateTimeString())).'Z';
                $dateInTheirFormat[18] = "1";
                $response = $client->request('GET', 'https://api.covid19api.com/country/'.$country->slug.'?from='.$dateInTheirFormat.'&to='.$currDateInTheirFormat);
                $data = json_decode($response->getBody(), true);
                if($data == []){
                    continue;
                }
                else{
                    foreach($data as $d){
                        $date = date("Y-m-d H:i:s", strtotime($d['Date']));
                        $date2 = date("Y-m-d H:i:s", strtotime($covidData->date));
                        if($date > $date2){
                            $newCovidData = new CovidData();
                            $newCovidData->country()->associate($country);
                            $newCovidData->total_confirmed = $d['Confirmed'];
                            $newCovidData->total_recovered = $d['Recovered'];
                            $newCovidData->total_deaths = $d['Deaths'];
                            $newCovidData->date = $date;
                            $newCovidData->save();
                        }
                    }
                }
            }
        }
    }
}
