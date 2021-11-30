# Lovely Table

WP Lovely Table is a WordPress Plugin that shows list of the users in a HTML table. The HTML table will be shown under a custom endpoint. 

The source data is provided by a 3rd-party API endpoint. 


## Installation

Clone the repository and run composer install:

```composer install``` 


## Configuration

After installing and activating the plugin, you can change the plugin settings under `Settings -> Lovely Table` menu.


### Cache

To avoid multiple requests to 3rd party API, we cache the API responses.
The cache files will be saved under the `cache` folder. Please make sure PHP has write access to this folder.


## Running the tests

You are able to run our tests using PHPUnit. 

```vendor/bin/phpunit tests/APITest.php```


## Usage

After activating the plugin, a lovely HTML table will be shown when a custom endpoint is visited. 
By default, it is under the `my-lovely-table` endpoint. So by visiting the URL like `https://your-website.com/my-lovely-table`, the HTML table will be shown.
You can change it under the `Settings -> Lovely Table` menu.


### Lovely Table Settings

`Endpoint Page` is the custom endpoint.

`Cache Time`  This is the time that a file is stored in cache before it's refreshed. By default, it expires in 60 minutes (3600 seconds).

`Custom Table Class` You can use the custom CSS class to styling the HTML table.


## License

This code is released under ["GPL 2.0 or later" License](LICENSE).
