<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

# Covid-19 Statistics System

## Technology used

- PHP (version 7.4.2)
- Laravel (version 7.14.1)
- XAMPP Control Panel (v3.2.4)
- guzzlehttp/guzzle package (version 6.5 - Laravel will require version 6.3 by default but I updated it)

## Installation Process

- Step 1: Clone the project to your local machine.
- Step 2: Open the terminal in the project folder and run "composer install".
- Step 3: Run the command "cp .env.example .env" in the terminal.
- Step 4: Run the command "php artisan key:generate" in the terminal.
- Step 5: Create a Database and make sure its info is reflected in the .env file.
- Step 6: Run the command "php artisan migrate" in the terminal.

The project should be ready, run the command "php artisan serve" to run on a localhost.
Note: These commands is intended for Windows OS, it might change for other OSs.

## API Used (Data Source)

I have used the following API <a href="https://covid19api.com/">https://covid19api.com/</a>. It provides a good amount of different request handlers but it has showed some inconsistencyin showing the data for my requests.

I have used the following:
- <a href="https://api.covid19api.com/countries">https://api.covid19api.com/countries</a>
- <a href="https://api.covid19api.com/total/dayone/country/south-africa">https://api.covid19api.com/total/dayone/country/south-africa</a>
- <a href="https://api.covid19api.com/country/south-africa?from=2020-03-01T00:00:00Z&to=2020-04-01T00:00:00Z">https://api.covid19api.com/country/south-africa?from=2020-03-01T00:00:00Z&to=2020-04-01T00:00:00Z</a>

## Models

I have decided to go with two model design which held the country information and the other which will hold the daily cases of the corona virus with a foriegn key to the country table. 
The following diagram might help:
![ER diagram](image.png)

This design will reduce or eliminate data redundancy in the database.

## Controllers

In this system, I have only one controller called 'CountryController'. It has the following methods:

#### changeCountryAPI($name)

This method should handle the AJAX requests from the front-end to update the data to a specified country.

###### Parameters:

- name: which is the country name

###### Return:

- JSON object that has the following information: total_cases, new_cases, total_recovered, new_recovered, total_deaths, new_deaths, active_cases, and new_active_cases. Or it returns "Error".

#### show()

This method should handle the request to display the page. It will calculate the global numbers and construct the view.

###### Parameters:

- void

###### Return:

- a View

#### updateAll()

This method is resposible to decide whether we should populate the tables if they are empty (populateTables method will be called) or fetch the latest data (updateData method will be called). It should be called periodically through a cron job in the server. I have initiated the Laravel part to run daily.

###### Parameters:

- void

###### Return:

- void

#### populateTables()

This method is responsible to fetch all the data from the API and store them in the Databse. This method will be called only if the countries table is empty.

###### Parameters:

- void

###### Return:

- void

#### updateData($countries)

This method is responsible to fetch the latest data from the API and store them in the database for each country.

###### Parameters:

- Collection of countries data stored in the database

###### Return:

- void

## View

In the front-end part of the project, I went with Minimum viable product. The front-end has AJAX capabilities to update the data when the user changes the country.

## Difficulties Faced

###### API inconsistency

I could not determine the cause of the problem but sometimes the request returns with limited data as request and in other times it returns all the data since the first case. I have taken that into considaration and made my code check for the date before using data.

###### API wrong response

- <a href="https://api.covid19api.com/total/dayone/country/au">Australia daily cumulative cases</a>
- <a href="https://api.covid19api.com/dayone/country/au">Australia daily new cases</a>

Both should represent the same country but one for the new cases and the other for totals. For some reason the cumulative did not return data. This does not happen to all the countries, the following links should be working fine.

- <a href="https://api.covid19api.com/total/dayone/country/za">South Africa daily cumulative cases</a>
- <a href="https://api.covid19api.com/dayone/country/za">South Africa daily new cases</a>

###### max_execution_time and memory_limit exceptions

I have faced these errors in the my costly methods and learned that I increase them.

###### Date Format

This was not a big issue but it was a new thing that a learned during the project.

## Enhancement Opportunities

In these enhancements, I have took the development speed over the performance of the project. If one day the requirement changes, we can implement them to optimize the code.

###### Reduce number of requests to update or populate data

The populateTables metod in CountryController will have n+1 calls to the API where n = number of countries. The updateData metod in CountryController will also have n calls to the API where n = number of countries. This might be fixed by having one request which will bring all the data and process it internally.

###### Replace heavy operations with lighter ones

As I have read that Eloquent queries and operations are costly compared to Query Builder operation. Replacing them might give me better runtime results.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
