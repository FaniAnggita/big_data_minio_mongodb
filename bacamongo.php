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

?>
<table id="tabel-data" class="table table-striped table-bordered table-hover table-responsive" cellspacing="0">
    <thead class="table-dark">
        <tr>
            <th>id</th>
            <th>app</th>
            <th>Category</th>
            <th>Content Rating </th>
            <th>Rating</th>
            <th>Size</th>
            <th>Installs</th>
            <th>Price</th>
            <th>Genres </th>

        </tr>
    </thead>

    <tbody>
        <?php foreach ($cursor as $d) {
            $i++; ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $d["App"] ?></td>
                <td><?php echo $d["Category"] ?></td>
                <td><?php echo $d["Content Rating"] ?></td>
                <td><?php echo $d["Rating"] ?></td>
                <td><?php echo $d["Size"]; ?></td>
                <td><?php echo $d["Installs"] ?></td>
                <td><?php echo $d["Price"] ?></td>
                <td><?php echo $d["Genres"] ?></td>

            </tr>
        <?php } ?>
    </tbody>
    <tfoot class="table-secondary">
        <tr>
            <th>id</th>
            <th>app</th>
            <th>Category</th>
            <th>Content Rating </th>
            <th>Rating</th>
            <th>Size</th>
            <th>Installs</th>
            <th>Price</th>
            <th>Genres </th>

        </tr>
    </tfoot>
</table>