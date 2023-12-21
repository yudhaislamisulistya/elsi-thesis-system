<style>

</style>

<?= $this->include('layouts/header') ?>
<main class="main-content">
    <?= $this->include('layouts/sidebar') ?>
    <div class="contents">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Data Formulir</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?= $this->include('components/alert.php'); ?>
                    <div class="accordion" id="accordionExample">
                        <div class="card card-horizontal card-default card-md mb-4">
                            <div class="card-header">
                                <h6>Formulir Penilaian</h6>
                            </div>
                            <div class="card-body py-md-30">
                                <div class="horizontal-form">
                                    <form action="<?= route_to('candidate.form.store') ?>" method="POST">
                                        <input type="hidden" name="batch_code" id="batch_code" value="<?= $data["code"] ?>">
                                        <?php

                                        foreach ($data["subParametersData"] as $key => $value) {
                                            $valueNow = get_value_grade_sub_parameter_candidate(get_user_by_id(session()->get('user_id'))["code"], $data["code"], $value["sub_parameter_code"]);

                                            if (check_grade_sub_parameter($value["sub_parameter_code"])) {
                                                echo '<div class="form-group row mb-25">
                                                    <div class="col-sm-3 d-flex align-items-center">
                                                        <label class="col-form-label color-dark fs-14 fw-500">' . $value["name"] . '</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select name="sub_parameter_code[' . $value["sub_parameter_code"] . ']" class="form-control ih-medium ip-gray radius-xs b-light px-15">
                                                            ';
                                                foreach ($data["gradeSubParametersData"] as $key => $gradeSubParameter) {
                                                    $selected = $gradeSubParameter["value"] == $valueNow ? "selected" : "";
                                                    if ($gradeSubParameter["sub_parameter_code"] == $value["sub_parameter_code"]) {
                                                        echo '<option value="' . $gradeSubParameter["value"] . '" ' . $selected . '>' . $gradeSubParameter["description"] . '</option>';
                                                    }
                                                }
                                                echo '
                                                        </select>
                                                    </div>
                                                </div>';
                                            } else {
                                                echo '<div class="form-group row mb-25">
                                                    <div class="col-sm-3 d-flex align-items-center">
                                                        <label class="col-form-label color-dark fs-14 fw-500">' . $value["name"] . '</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="number" name="sub_parameter_code[' . $value["sub_parameter_code"] . ']" class="form-control ih-medium ip-gray radius-xs b-light px-15" placeholder="Masukkan Nilai Penilaian" value="' . $valueNow . '">
                                                    </div>
                                                </div>';
                                            }
                                        }
                                        ?>

                                        <!-- Tombol Submit dan Cancel -->
                                        <div class="layout-button mt-25">
                                            <button type="button" class="btn btn-default btn-squared border-normal bg-normal px-20 ">cancel</button>
                                            <button type="submit" class="btn btn-primary btn-default btn-squared px-30">Save/Update</button>
                                        </div>
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
        $('#DT-default').DataTable();
    });
</script>