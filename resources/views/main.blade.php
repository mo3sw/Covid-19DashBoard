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
    </head>
    @php
        $active_cases = $total_cases - $total_recovered - $total_deaths;
        $new_active_cases = $new_cases - $new_recovered - $new_deaths;

        $recovery_rate_total = substr(strval($total_recovered/$total_cases*100),0,4);
        $recovery_rate_Closed = substr(strval($total_recovered/($active_cases+$total_deaths)*100),0,4);
        $death_rate_total = substr(strval($total_deaths/$total_cases*100),0,4);
        $death_rate_closed = substr(strval($total_deaths/($active_cases+$total_deaths)*100),0,4);
    @endphp
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    <b>Covid-19</b><br>Statistics Website
                </div>
                <div>
                    <div class="card cardText cardStyle" style="width:250px">
                        <div class="card-body">
                            <h6 class="card-title">Total Cases</h6>
                            <h1 class="card-text">{{ $total_cases }}</h1>
                            <p class="card-text">+{{ $new_cases }}</p>
                        </div>
                    </div>
                    <div class="card cardText cardStyle" style="width:250px">
                        <div class="card-body">
                            <h6 class="card-title">Active Cases</h6>
                            <h1 class="card-text medium">{{ $active_cases }}</h1>
                            <p class="card-text">+{{ $new_active_cases }}</p>
                        </div>
                    </div>
                    <div class="card cardText cardStyle" style="width:250px">
                        <div class="card-body">
                            <h6 class="card-title">Recovered Cases</h6>
                            <h1 class="card-text good">{{ $total_recovered }}</h1>
                            <p class="card-text">+{{ $new_recovered }}</p>
                        </div>
                    </div>
                    <div class="card cardText cardStyle" style="width:250px">
                        <div class="card-body">
                            <h6 class="card-title">Death Cases</h6>
                            <h1 class="card-text bad">{{ $total_deaths }}</h1>
                            <p class="card-text">+{{ $new_deaths }}</p>
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
                                <td class="rightAligned good">{{ $recovery_rate_total }}%</td>
                            </tr>
                            <tr>
                                <td class="leftAligned">Recovery rate from closed cases:</td>
                                <td class="rightAligned good">{{ $recovery_rate_Closed }}%</td>
                            </tr>
                            <tr>
                                <td class="leftAligned">Death rate from total cases:</td>
                                <td class="rightAligned bad">{{ $death_rate_total }}%</td>
                            </tr>
                            <tr>
                                <td class="leftAligned">Death rate from close cases:</td>
                                <td class="rightAligned bad">{{ $death_rate_closed }}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>

</html>