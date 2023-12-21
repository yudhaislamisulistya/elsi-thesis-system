<?= $this->include('layouts/header') ?>
<main class="main-content">
    <?= $this->include("layouts/sidebar") ?>
    <div class="contents">
        <div class="container-fluid">
            <div class="social-dash-wrap">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-main">
                            <h4 class="text-capitalize breadcrumb-title">HRD Dashboard</h4>
                        </div>
                        <div class="alert-icon-big alert alert-info mb-20" role="alert">
                            <div class="alert-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                                    <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                    <polyline points="2 17 12 22 22 17"></polyline>
                                    <polyline points="2 12 12 17 22 12"></polyline>
                                </svg>
                            </div>
                            <div class="alert-content">
                                <h6 class="alert-heading">Welcome!</h6>
                                <p>You are now on the dashboard page and have HRD access.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-25">
                        <div class="card card-overview border-0">
                            <div class="card-body pt-0 pb-0">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="f_overview-today" role="" aria-labelledby="f_overview-tab">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card-overview__left">
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-12 col-md-6">
                                                            <div class="overview-single">
                                                                <div class="overview-content">
                                                                    <h1><?= $data['totalCandidate'] ?></h1>
                                                                    <p>Data Pelamar</p>
                                                                </div>
                                                                <div class="overview-single__chart">
                                                                    <div class="parentContainer">
                                                                        <div>
                                                                            <canvas id="lineChartOne"></canvas>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-12 col-md-6 br-1">
                                                            <div class="overview-single">
                                                                <div class="overview-content">
                                                                    <h1><?= $data['totalParameter'] ?></h1>
                                                                    <p>Data Parameter</p>
                                                                </div>
                                                                <div class="overview-single__chart">
                                                                    <div class="parentContainer">
                                                                        <div>
                                                                            <canvas id="lineChartTwo"></canvas>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="card-overview__right">
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-12 col-md-6">
                                                            <div class="overview-single">
                                                                <div class="overview-content">
                                                                    <h1><?= $data['totalSubParameter'] ?></h1>
                                                                    <p>Data Sub Parameter</p>
                                                                </div>
                                                                <div class="overview-single__chart">
                                                                    <div class="parentContainer">
                                                                        <div>
                                                                            <canvas id="lineChartThree"></canvas>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-12 col-md-6 co-last">
                                                            <div class="overview-single">
                                                                <div class="overview-content">
                                                                    <h1><?= $data['totalBatch'] ?></h1>
                                                                    <p>Data Batch Pendaftaran</p>
                                                                </div>
                                                                <div class="overview-single__chart">
                                                                    <div class="parentContainer">
                                                                        <div>
                                                                            <canvas id="lineChartFour"></canvas>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="card-body p-0">
                                                <div class=" p-25 bg-white mb-30">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0" id="DT-default" class="display" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="content-visibility: hidden;">No.</th>
                                                                    <th>Nomor</th>
                                                                    <th>Username</th>
                                                                    <th>Nama</th>
                                                                    <th>Email</th>
                                                                    <th>Tempat Tanggal Lahir</th>
                                                                    <th>Jenis Kelamin</th>
                                                                    <th>No. Telepon</th>
                                                                    <th>Alamat</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($data["fiveLatestCandidate"] as $key => $value) {
                                                                ?>
                                                                    <tr>
                                                                        <td style="content-visibility: hidden;"><?= $value["id"] ?></td>
                                                                        <td><?= $key + 1 ?></td>
                                                                        <td><?= $value["username"] ?></td>
                                                                        <td><?= $value["name"] ?></td>
                                                                        <td><?= $value["email"] ?></td>
                                                                        <td><?= $value["birth_location_date"] ?></td>
                                                                        <td><?= $value["gender"] ?></td>
                                                                        <td><?= $value["telephone"] ?></td>
                                                                        <td><?= $value["address"] ?></td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <footer class="footer-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="footer-copyright">
                        <p>2023 @<a href="#">Elsi Titasari Br Bangun</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</main>
<?= $this->include('layouts/footer') ?>