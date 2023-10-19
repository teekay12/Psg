# Techinical Assesment

This project simply downloads all postcodes in the UK and saves them into a SQLite database.
This is done by runnning a custom command 'php index.php app:download-locations' which takes few minutes to complete

There are room for improvement 1 due to the large size of the file and having to hit the database everytime there's a query, but due to the time constraint I won't be able to improve on this.

I feel performance could be increased in this area by introducing Redis to hold search keys and there value to avoid hitting the database.

And also, there are some areas I could have coded to an interface rather than coding to a concrete class.

This project has as two other functionality

## 1 
A function that takes in a query "Post code" and returns similar postcode

## 2 
A functions that takes in 3 parameter "lat, longitude and limit" and returns a locations withing a specific search radius.

Both functions returns a json response and can only be tested through a Unit test that I have written by running 
vendor/bin/phpunit

To install run `composer install`