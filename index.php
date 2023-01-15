<?php
require_once('api-mongodb.php')
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baca Object dari MongoDB</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
</head>

<body>
    <div class="row">
        <div class="alert alert-primary text-center" role="alert">
            Anggota Kelompok: <strong> 203110017-Annisa Kinanti & 203110026-Fani Anggita </strong> | Data Source: <a href="#" class="alert-link">https://www.kaggle.com/datasets/lava18/google-play-store-apps</a>
        </div>
    </div>
    <div class="container-fluid p-4">

        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div>
                                <h3 class="text-warning"><?php echo $server; ?></h3>
                                <p class="mb-0">Server</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-modem-fill text-warning fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div>
                                <h3 class="text-danger"><?php echo $namaDB ?></h3>

                                <p class="mb-0">Database</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-database-fill-check fa-3x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div>
                                <h3 class="text-success"><?php echo $namaCol ?></h3>
                                <p class="mb-0">Collection</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-bookmark-star-fill fa-3x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div>
                                <h3 class="text-info"><?php echo count($title->toArray()); ?></h3>
                                <p class="mb-0">Data Total</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-file-earmark-binary-fill text-info fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

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
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Setup - add a text input to each footer cell
            $('#tabel-data tfoot th').each(function() {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" width:"10px"/>');

            });


            $('#tabel-data').DataTable({
                initComplete: function() {
                    // Apply the search
                    this.api()
                        .columns()
                        .every(function() {
                            var that = this;

                            $('input', this.footer()).on('keyup change clear', function() {
                                if (that.search() !== this.value) {
                                    that.search(this.value).draw();
                                }
                            });
                        });

                },

                scrollY: '290px',
                scrollX: true,
                pagingType: 'full_numbers',

                // dom: 'Bfrtip',
                // buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            });

            $('a.toggle-vis').on('click', function(e) {
                e.preventDefault();

                // Get the column API object
                var column = table.column($(this).attr('data-column'));

                // Toggle the visibility
                column.visible(!column.visible());
            });

        });
    </script>
</body>

</html>