<style>

</style>

<?= $this->include('layouts/header') ?>
<main class="main-content">
    <?= $this->include("layouts/sidebar") ?>
    <div class="contents">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Data Detail Profile Matching</h4>
                        <div class="breadcrumb-action justify-content-center flex-wrap">
                            <div class="dropdown action-btn">
                                <button class="btn btn-sm btn-default btn-white dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-download"></i> Export
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <span class="dropdown-item">Export With</span>
                                    <div class="dropdown-divider"></div>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-print"></i> Printer</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-file-pdf"></i> PDF</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-file-text"></i> Google Sheets</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-file-excel"></i> Excel (XLSX)</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-file-csv"></i> CSV</a>
                                </div>
                            </div>
                            <div class="action-btn">
                                <a href="" class="btn btn-sm btn-primary btn-add">
                                    <i class="la la-plus"></i> Add New</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="accordion" id="accordionExample">
                        <!-- Card 1: Raw Data -->
                        <div class="card mb-20">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <h1>1. Data Menajadi Numerik</h1>
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Alternatif</th>
                                                <?php
                                                foreach ($data['uniqueSubParameterCodeFromSubParameterCandidates'] as $uniqueSubParameterCodeFromSubParameterCandidates) {
                                                    echo "<th>" . $uniqueSubParameterCodeFromSubParameterCandidates['sub_parameter_code'] . "</th>";
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($data['uniqueCandidateCodeFromSubParameterCandidates'] as $uniqueCandidateCodeFromSubParameterCandidates) {
                                                echo "<tr>";
                                                echo "<td>" . $uniqueCandidateCodeFromSubParameterCandidates['candidate_code'] . "</td>";
                                                foreach ($data['uniqueSubParameterCodeFromSubParameterCandidates'] as $uniqueSubParameterCodeFromSubParameterCandidates) {
                                                    $value = get_value_grade_sub_parameter_candidate($uniqueCandidateCodeFromSubParameterCandidates['candidate_code'], $data["batch_code"], $uniqueSubParameterCodeFromSubParameterCandidates['sub_parameter_code']);
                                                    echo "<td>" . $value . "</td>";
                                                }
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Hitung GAP Sub Parameter S1 dan S2 atau yang Menggunakan Kalkulasi Rating & Profile Matching atau Profile Matching -->
                        <div class="card mb-20">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <h1>2. Hitung GAP Sub Parameter S1 dan S2 atau yang Menggunakan Kalkulasi Rating & Profile Matching atau Profile Matching</h1>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Alternatif</th>
                                                <?php
                                                foreach ($data['uniqueSubParameterCodeFromSubParameterCandidates'] as $uniqueSubParameterCodeFromSubParameterCandidates) {
                                                    echo "<th>" . $uniqueSubParameterCodeFromSubParameterCandidates['sub_parameter_code'] . "</th>";
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $columnValues = [];
                                            foreach ($data['uniqueCandidateCodeFromSubParameterCandidates'] as $uniqueCandidateCodeFromSubParameterCandidates) {
                                                echo "<tr>";
                                                echo "<td>" . $uniqueCandidateCodeFromSubParameterCandidates['candidate_code'] . "</td>";
                                                foreach ($data['uniqueSubParameterCodeFromSubParameterCandidates'] as $uniqueSubParameterCodeFromSubParameterCandidates) {
                                                    $subParameterCode = $uniqueSubParameterCodeFromSubParameterCandidates['sub_parameter_code'];
                                                    $value = calculate_gap_sub_parameter($uniqueCandidateCodeFromSubParameterCandidates['candidate_code'], $data["batch_code"], $uniqueSubParameterCodeFromSubParameterCandidates['sub_parameter_code']);
                                                    $columnValues[$subParameterCode][] = $value;
                                                    echo "<td>" . $value . "</td>";
                                                }
                                                echo "</tr>";
                                            }
                                            ?>
                                            <?php

                                            $result = calculateMaxMinPerColumn($columnValues);
                                            $maxValues = $result['maxValues'];
                                            $minValues = $result['minValues'];

                                            echo "<tr><td>Max</td>";
                                            foreach ($data['uniqueSubParameterCodeFromSubParameterCandidates'] as $uniqueSubParameterCode) {
                                                $checkExceptRating = check_except_sub_parameter($uniqueSubParameterCode['sub_parameter_code']);
                                                if ($checkExceptRating) {
                                                    echo "<td><b>" . $maxValues[$uniqueSubParameterCode['sub_parameter_code']] . "</b></td>";
                                                } else {
                                                    echo "<td><b>-</b></td>";
                                                }
                                            }
                                            echo "</tr>";
                                            echo "<tr><td>Min</td>";
                                            foreach ($data['uniqueSubParameterCodeFromSubParameterCandidates'] as $uniqueSubParameterCode) {
                                                $checkExceptRating = check_except_sub_parameter($uniqueSubParameterCode['sub_parameter_code']);
                                                $checkSubParameterTargetIsRange = check_sub_parameter_target_is_range($uniqueSubParameterCode['sub_parameter_code']);
                                                if ($checkExceptRating) {
                                                    if (!$checkSubParameterTargetIsRange) {
                                                        echo "<td><b>" . $minValues[$uniqueSubParameterCode['sub_parameter_code']] . "</b></td>";
                                                    } else {
                                                        $negatedMinValue = -$maxValues[$uniqueSubParameterCode['sub_parameter_code']];
                                                        echo "<td><b>" . $negatedMinValue . "</b></td>";
                                                    }
                                                } else {
                                                    echo "<td><b>-</b></td>";
                                                }
                                            }
                                            echo "</tr>";
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Scoring -->
                        <div class="card mb-20">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <h1>3. Scoring</h1>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="card-body">
                                    <form action="<?= route_to('hrd.detail-profile-matching.update') ?>" method="POST">
                                        <input type="hidden" name="batch_code" value="<?= $data["batch_code"] ?>">

                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Alternatif</th>
                                                    <?php foreach ($data['uniqueSubParameterCodeFromSubParameterCandidates'] as $uniqueSubParameterCode) : ?>
                                                        <th><?= $uniqueSubParameterCode['sub_parameter_code'] ?></th>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data['uniqueCandidateCodeFromSubParameterCandidates'] as $candidateCode) : ?>
                                                    <tr>
                                                        <td><?= $candidateCode['candidate_code'] ?></td>
                                                        <?php foreach ($data['uniqueSubParameterCodeFromSubParameterCandidates'] as $subParameterCode) : ?>
                                                            <?php
                                                            $value = calculate_gap_sub_parameter($candidateCode['candidate_code'], $data["batch_code"], $subParameterCode['sub_parameter_code']);
                                                            $valueFinal = calculate_scoring($candidateCode['candidate_code'], $data["batch_code"], $subParameterCode['sub_parameter_code'], $value, $maxValues[$subParameterCode['sub_parameter_code']], $minValues[$subParameterCode['sub_parameter_code']]);
                                                            ?>
                                                            <td>
                                                                <input type="text" name="scores[<?= $candidateCode['candidate_code'] ?>][<?= $subParameterCode['sub_parameter_code'] ?>]" value="<?= $valueFinal ?>" class="form-control" readonly>
                                                            </td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>

                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>
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

<script>
    $(document).ready(function() {

    });
</script>