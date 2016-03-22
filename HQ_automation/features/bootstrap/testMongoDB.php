<?php

//connect do database
$URI = "";
$mongo = new MongoClient($URI);

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
