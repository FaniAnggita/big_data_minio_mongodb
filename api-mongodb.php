<?php
require 'vendor/autoload.php';

// Menghubungkan ke server MongoDB
$server = "localhost:27017";
$m = new MongoDB\Client('mongodb://' . $server);

// Variabel untuk nama database dan collection
$namaDB = "dbGooglePlayStore";
$namaCol = "colGooglePlayStore";

// Memilih database
$db = $m->$namaDB;

// Memilih collection
$collection = $db->$namaCol;

// query ke collection
$cursor = $collection->find();
$i = 0;

$title = $collection->find(array(), array('projection' => array('title' => 1, 'speaker' => 1)));
$i = 0;

// foreach ($title as $t) {
//     echo $t['title'];
// }
