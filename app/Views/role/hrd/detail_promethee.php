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
                        <h4 class="text-capitalize breadcrumb-title">Data Detail PROMETHEE</h4>
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
                                        <h1>1. Penilaian Yang Menjadi Perhitungan</h1>
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
                                                    $value = get_value_pm_sub_parameter_candidate($uniqueCandidateCodeFromSubParameterCandidates['candidate_code'], $data["batch_code"], $uniqueSubParameterCodeFromSubParameterCandidates['sub_parameter_code']);
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

                        <!-- Card 2: Data Menjadi Numerik -->
                        <div class="card mb-20">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <h1>2. Menentukan Tipe Fungsi Preferensi masing-masing Sub Paramater</h1>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Sub Parameter</th>
                                                <th>Bobot Sub Paramater</th>
                                                <th>Tipe Preferensi</th>
                                                <th>Target</th>
                                                <th>Nilai Batas Awal (q)</th>
                                                <th>Nilai Batas Akhir (p)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($data["dataPreferences"] as $dataPreferences) {
                                                echo "<tr>";
                                                echo "<td>" . $dataPreferences['sub_parameter_code'] . "</td>";
                                                echo "<td>" . $dataPreferences['sub_parameter_weight'] . "</td>";
                                                echo "<td>" . $dataPreferences['sub_parameter_type'] . "</td>";
                                                echo "<td>" . $dataPreferences['preference_target_value'] . "</td>";
                                                echo "<td>" . $dataPreferences['start_bound_q'] . "</td>";
                                                echo "<td>" . $dataPreferences['end_bound_p'] . "</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Hitung Gap -->
                        <div class="card mb-20">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <h1>3. Menentukan Nilai Preferensi</h1>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="card-body">
                                    <?php
                                    foreach ($data["dataPromethee"] as $subParameterCode => $candidateComparisons) {
                                        echo "<h3>Sub Parameter " . $subParameterCode . " - " .  get_sub_parameter_by_code($subParameterCode)['name'] . "</h3>";
                                        echo "<table class='table mb-0'>";
                                        echo "<thead>";
                                        echo "<tr>";
                                        echo "<th>Alternatif</th>";
                                        echo "<th>a</th>";
                                        echo "<th>b</th>";
                                        echo "<th>d</th>";
                                        echo "<th>Prefensi (d)</th>";
                                        echo "<th>Indeks Preferensi</th>";
                                        echo "</tr>";
                                        echo "</thead>";
                                        echo "<tbody>";

                                        foreach ($candidateComparisons as $candidateA => $comparisons) {
                                            foreach ($comparisons as $candidateB => $comparisonData) {
                                                echo "<tr>";
                                                echo "<td>" . $candidateA . " -> " . $candidateB . "</td>";
                                                echo "<td>" . get_value_pm_sub_parameter_candidate($candidateA, $data["batch_code"], $subParameterCode) . "</td>"; // Display valuePM for candidate A
                                                echo "<td>" . get_value_pm_sub_parameter_candidate($candidateB, $data["batch_code"], $subParameterCode) . "</td>"; // Display valuePM for candidate B
                                                echo "<td>" . $comparisonData['valuePM'] . "</td>"; // Display valuePM for candidate B
                                                echo "<td>" . $comparisonData['d'] . "</td>"; // Replace with actual preference value
                                                echo "<td>" . $comparisonData['preferenceIndex'] . "</td>"; // Replace with actual preference index
                                                echo "</tr>";
                                            }
                                        }
                                        echo "</tbody>";
                                        echo "</table>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Card 4: Menghitung Total Indeks Prefrensi -->
                        <div class="card mb-20">
                            <div class="card-header" id="headingFour">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        <h1>4. Menghitung Total Indeks Prefrensi</h1>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                <div class="card-body table-responsive-xxl">
                                    <table class="table mb-0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Candidates</th>
                                                <?php foreach ($data["uniqueCandidateCodeFromSubParameterCandidates"] as $candidate) : ?>
                                                    <th><?= $candidate['candidate_code']; ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data["uniqueCandidateCodeFromSubParameterCandidates"] as $candidateRow) : ?>
                                                <tr>
                                                    <td><?= $candidateRow['candidate_code']; ?></td>
                                                    <?php foreach ($data["uniqueCandidateCodeFromSubParameterCandidates"] as $candidateCol) : ?>
                                                        <td>
                                                            <?php
                                                            echo isset($data["totalPreferenceIndices"][$candidateRow['candidate_code']][$candidateCol['candidate_code']])
                                                                ? number_format($data["totalPreferenceIndices"][$candidateRow['candidate_code']][$candidateCol['candidate_code']], 4)
                                                                : '-';
                                                            ?>
                                                        </td>
                                                    <?php endforeach; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-20">
                            <div class="card-header" id="headingFive">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        <h1>5. Menghitung Leaving Flow, Entering Flow, dan Net Flow</h1>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Candidate</th>
                                                <th>Leaving Flow</th>
                                                <th>Entering Flow</th>
                                                <th>Net Flow</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data["uniqueCandidateCodeFromSubParameterCandidates"] as $candidate) : ?>
                                                <tr>
                                                    <td><?= $candidate['candidate_code']; ?></td>
                                                    <td><?= number_format($data["leavingFlow"][$candidate['candidate_code']], 4); ?></td>
                                                    <td><?= number_format($data["enteringFlow"][$candidate['candidate_code']], 4); ?></td>
                                                    <td><?= number_format($data["netFlow"][$candidate['candidate_code']], 4); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="card mb-20">
                            <div class="card-header" id="headingSix">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                        <h1>5. Ranking</h1>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                                <div class="card-body">
                                    <form action="<?= route_to('hrd.promethee.save_ranking'); ?>" method="POST">
                                        <input type="hidden" name="batch_code" value="<?= $data["batch_code"]; ?>">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Rank</th>
                                                    <th>Candidate</th>
                                                    <th>Leaving Flow</th>
                                                    <th>Entering Flow</th>
                                                    <th>Net Flow</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $rank = 1; ?>
                                                <?php foreach ($data["netFlowRanking"] as $candidateCode => $flow) : ?>
                                                    <tr>
                                                        <td><?= $rank; ?></td>
                                                        <input type="hidden" name="candidates[<?= $candidateCode; ?>][rank]" value="<?= $rank; ?>">
                                                        <input type="hidden" name="candidates[<?= $candidateCode; ?>][leaving_flow]" value="<?= $data['leavingFlow'][$candidateCode]; ?>">
                                                        <input type="hidden" name="candidates[<?= $candidateCode; ?>][entering_flow]" value="<?= $data['enteringFlow'][$candidateCode]; ?>">
                                                        <input type="hidden" name="candidates[<?= $candidateCode; ?>][net_flow]" value="<?= $flow; ?>">

                                                        <td><?= $candidateCode; ?></td>
                                                        <td><?= number_format($data['leavingFlow'][$candidateCode], 4); ?></td>
                                                        <td><?= number_format($data['enteringFlow'][$candidateCode], 4); ?></td>
                                                        <td><?= number_format($flow, 4); ?></td>
                                                    </tr>
                                                    <?php $rank++; ?>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>

                                        <button type="submit" class="btn btn-primary">Submit</button>
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

</script>