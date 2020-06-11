<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Covid-19 STAT</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

        <!-- Styles -->
        <style>
            html, body{
                background-color: #393d3f;
                color: #fff;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            
            .content {
                text-align: center;
            }
            
            .title {
                font-size: 84px;
            }
            
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .cardText {
                background-color: #fff;
                color: #393d3f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                text-align: center;
            }

            .cardStyle {
                float: left;
                margin: 25px;
            }

            div.clear {
                clear: both;
                margin-top: 50px;
                padding-top: 5%;
            }
            li{
                color: #393d3f;
                text-align: left;
            }
            
            .leftAligned {
                color: #393d3f;
                text-align: left;
            }

            .rightAligned {
                color: #393d3f;
                text-align: right;
                padding-right: 25px;
            }

            table{
                background-color: #fff;
            }

            .good {
                color: rgb(14, 224, 66);
            }

            .bad {
                color: rgb(255, 0, 0);
            }

            .medium {
                color:rgb(240, 185, 6)
            }
        </style>
        <script>
            function changeCountry(myOption){
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log("success");
                        console.log(this.responseText);
                        if(this.responseText == "Error"){
                            alert("This country does not have suffiecient data! Please try again.");
                            return;
                        }
                        var data = JSON.parse(this.responseText);
                        document.getElementById("total_cases").innerHTML = data[0].total_cases;
                        document.getElementById("new_cases").innerHTML = data[0].new_cases;
                        document.getElementById("active_cases").innerHTML = data[0].active_cases;
                        document.getElementById("new_active").innerHTML = data[0].new_active_cases;
                        document.getElementById("total_recovered").innerHTML = data[0].total_recovered;
                        document.getElementById("new_recovered").innerHTML = data[0].new_recovered;
                        document.getElementById("total_deaths").innerHTML = data[0].total_deaths;
                        document.getElementById("new_deaths").innerHTML = data[0].new_deaths;
                        var recovery_rate_total = data[0].total_recovered/parseFloat(data[0].total_cases)*100;
                        document.getElementById("recovery_rate_total").innerHTML = recovery_rate_total.toFixed(2)+"%";
                        var recovery_rate_Closed = parseFloat(data[0].total_recovered)/(parseFloat(data[0].total_recovered)+parseFloat(data[0].total_deaths))*100;
                        document.getElementById("recovery_rate_Closed").innerHTML = recovery_rate_Closed.toFixed(2)+"%";
                        var death_rate_total= parseFloat(data[0].total_deaths)/parseFloat(data[0].total_cases)*100;
                        document.getElementById("death_rate_total").innerHTML = death_rate_total.toFixed(2)+"%";
                        var death_rate_closed = parseFloat(data[0].total_deaths)/(parseFloat(data[0].total_recovered)+parseFloat(data[0].total_deaths))*100;
                        document.getElementById("death_rate_closed").innerHTML = death_rate_closed.toFixed(2)+"%";
                    }
                };
                console.log("/changeCountry/"+myOption.options[myOption.selectedIndex].text);
                xhttp.open("GET", "/changeCountry/"+myOption.options[myOption.selectedIndex].text, true);
                xhttp.send();
            }
        </script>
    </head>
    @php
        $active_cases = $total_cases - $total_recovered - $total_deaths;
        $new_active_cases = $new_cases - $new_recovered - $new_deaths;
        if($total_cases != 0 && $active_cases+$total_deaths != 0){
            $recovery_rate_total = substr(strval($total_recovered/$total_cases*100),0,4);
            $recovery_rate_Closed = substr(strval($total_recovered/($active_cases+$total_deaths)*100),0,4);
            $death_rate_total = substr(strval($total_deaths/$total_cases*100),0,4);
            $death_rate_closed = substr(strval($total_deaths/($active_cases+$total_deaths)*100),0,4);
        }
        else{
            $recovery_rate_total = 0;
            $recovery_rate_Closed = 0;
            $death_rate_total = 0;
            $death_rate_closed = 0;
        }
    @endphp
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    <b>Covid-19</b><br>Statistics Website
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                      <span class="input-group-text">Country:</span>
                    </div>
                    <select class="form-control" id="countryList" name="countryList" onchange="changeCountry(this)">
                        <option>Global</option>
                        @foreach ($countries as $country)
                            <option>{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <div class="card cardText cardStyle" style="width:250px">
                        <div class="card-body">
                            <h6 class="card-title">Total Cases</h6>
                            <h1 class="card-text" id="total_cases">{{ $total_cases }}</h1>
                            <p class="card-text" id="new_cases">+{{ $new_cases }}</p>
                        </div>
                    </div>
                    <div class="card cardText cardStyle" style="width:250px">
                        <div class="card-body">
                            <h6 class="card-title">Active Cases</h6>
                            <h1 class="card-text medium" id="active_cases">{{ $active_cases }}</h1>
                            <p class="card-text" id="new_active">+{{ $new_active_cases }}</p>
                        </div>
                    </div>
                    <div class="card cardText cardStyle" style="width:250px">
                        <div class="card-body">
                            <h6 class="card-title">Recovered Cases</h6>
                            <h1 class="card-text good" id="total_recovered">{{ $total_recovered }}</h1>
                            <p class="card-text" id="new_recovered">+{{ $new_recovered }}</p>
                        </div>
                    </div>
                    <div class="card cardText cardStyle" style="width:250px">
                        <div class="card-body">
                            <h6 class="card-title">Death Cases</h6>
                            <h1 class="card-text bad" id="total_deaths">{{ $total_deaths }}</h1>
                            <p class="card-text" id="new_deaths">+{{ $new_deaths }}</p>
                        </div>
                    </div>
                </div>
                <div class="clear">
                    <table class="table">
                        <thead>

                        </thead>
                        <tbody>
                            <tr>
                                <td class="leftAligned">Recovery rate from total cases:</td>
                                <td class="rightAligned good" id="recovery_rate_total">{{ $recovery_rate_total }}%</td>
                            </tr>
                            <tr>
                                <td class="leftAligned">Recovery rate from closed cases:</td>
                                <td class="rightAligned good" id="recovery_rate_Closed">{{ $recovery_rate_Closed }}%</td>
                            </tr>
                            <tr>
                                <td class="leftAligned">Death rate from total cases:</td>
                                <td class="rightAligned bad" id="death_rate_total">{{ $death_rate_total }}%</td>
                            </tr>
                            <tr>
                                <td class="leftAligned">Death rate from close cases:</td>
                                <td class="rightAligned bad" id="death_rate_closed">{{ $death_rate_closed }}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>

</html>