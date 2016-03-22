<?php

//connect do database
$mongo = new MongoClient("mongodb://heroku_ftfzdmb9:48u7eotcssqek0i9sqq053dcdr@ds059215.mongolab.com:59215/heroku_ftfzdmb9");

//select db
$db = $mongo->selectDB("heroku_ftfzdmb9");

// get all data
$collection = $db->orders;
$cursor = $collection->find();

// iterate through the results
foreach ($cursor as $document) {
    $name = ($document["order"]["firstName"]);
    if ($name == "Mihai") {
        print_r(($document["order"]));
    }
}
