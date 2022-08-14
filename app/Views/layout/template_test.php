<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?= $title; ?></title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="/assets/img/icon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="<?= base_url(); ?>/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ["<?= base_url(); ?>/assets/css/fonts.min.css"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/atlantis.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/sweetalert2.min.css">
</head>

<body>
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="blue">
                <a href="<?= base_url(""); ?>" class="logo" style="color: white;">
                    FORECASTING
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
                <div class="container-fluid">
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="/assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <a class="dropdown-item" href="/login">Login</a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2">
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-primary">
                        <li class="nav-item">
                            <a href="/loginadmin">
                                <i class="fa fa-sign-in-alt"></i>
                                <p>Login</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="content">
                <div class="flash-data" data-flashdata="<?= session()->get('message') ?>"></div>
                <?= $this->renderSection('content'); ?>

                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Apakah anda yakin ingin keluar?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <a href="/logout" class="btn btn-primary">Keluar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="copyright ml-auto">
                         FORECASTING PRODUKSI JAMUR
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="<?= base_url(); ?>/assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/core/popper.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery UI -->
    <script src="<?= base_url(); ?>/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="<?= base_url(); ?>/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="<?= base_url(); ?>/assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="<?= base_url(); ?>/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Datatables -->
    <script src="<?= base_url(); ?>/assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Sweet Alert -->
    <script src="<?= base_url(); ?>/assets/js/sweetalert2.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/swal.js"></script>

    <!-- Atlantis JS -->
    <script src="<?= base_url(); ?>/assets/js/atlantis.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({});
        });
    </script>
    <?php
    $db = \Config\Database::connect();
    $nilai = $db->query("SELECT * FROM data_awal, kategori
                        WHERE data_awal.id_kt = kategori.id_kt
                        ORDER BY data_awal.id_awal ASC");
    ?>

    <script>
        var bubbleChart = document.getElementById('bubbleChart');

        var myBubbleChart = new Chart(bubbleChart, {
            type: 'bubble',
            data: {
                datasets: [{
                        label: "Low",
                        // data:[{x:25,y:17,r:25},{x:30,y:25,r:28}, {x:35,y:30,r:3}], 
                        data: [
                            <?php
                            foreach ($nilai->getResultArray() as $data) {
                                if ($data['id_kt'] == 1) {
                                    echo '{x:' . $data['suhu'] .  ',y:' .  $data['kelembaban'] . ',r:3}, ';
                                }
                            }
                            ?>
                        ],
                        backgroundColor: "#716aca"
                    },
                    {
                        label: "Medium",
                        data: [
                            <?php
                            foreach ($nilai->getResultArray() as $data) {
                                if ($data['id_kt'] == 2) {
                                    echo '{x:' . $data['suhu'] .  ',y:' .  $data['kelembaban'] . ',r:3}, ';
                                }
                            }
                            ?>
                        ],
                        backgroundColor: "#1d7af3"
                    },
                    {
                        label: "High",
                        data: [
                            <?php
                            foreach ($nilai->getResultArray() as $data) {
                                if ($data['id_kt'] == 3) {
                                    echo '{x:' . $data['suhu'] .  ',y:' .  $data['kelembaban'] . ',r:3}, ';
                                }
                            }
                            ?>
                        ],
                        backgroundColor: "#f3a719"
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
            }
        });
    </script>

    <!-- <script>
        const scatter = document.getElementById('scatter');
        const label = [
            // <?php
                // foreach ($nilai->getResultArray() as $data) {
                //     echo '"' . $data['kelembaban'] .  '"' . ', ';
                // } 
                ?>
        ];
        const data = [
            // <?php
                // foreach ($nilai->getResultArray() as $data) {
                //     echo $data['suhu'] . ', ';
                // } 
                ?>
        ];
        const config = {
            type: 'scatter',
            data: {
                labels: label,
                datasets: [{
                    label: "Suhu",
                    borderColor: "#1d7af3",
                    pointBackgroundColor: "#1d7af3",
                    pointHoverRadius: 1,
                    pointHoverBorderWidth: 1,
                    pointRadius: 1,
                    backgroundColor: 'transparent',
                    fill: true,
                    borderWidth: 2,
                    data: datasuhu
                }]
            },
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Scatter Chart'
                    }
                }
            },
        };
    </script> -->

</body>

</html>