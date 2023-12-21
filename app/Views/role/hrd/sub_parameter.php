<?= $this->include('layouts/header') ?>
<main class="main-content">
    <?= $this->include("layouts/sidebar") ?>
    <div class="contents">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Data Sub Parameter</h4>
                        <div class="breadcrumb-action justify-content-center flex-wrap">
                            <div class="dropdown action-btn">
                                <button class="btn btn-sm btn-default btn-white dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-download"></i> Export
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <span class="dropdown-item">Export With</span>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item" id="printButton">
                                        <i class="la la-print"></i> Printer</a>
                                    <a href="#" class="dropdown-item" id="pdfButton">
                                        <i class="la la-file-pdf"></i> PDF</a>
                                    <a href="#" class="dropdown-item" id="excelButton">
                                        <i class="la la-file-excel"></i> Excel (XLSX)</a>
                                    <a href="#" class="dropdown-item" id="csvButton">
                                        <i class="la la-file-csv"></i> CSV</a>
                                </div>
                            </div>
                            <div class="action-btn">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-primary btn-add dropdown-toggle" type="button" id="addMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="la la-plus"></i> Add New
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="addMenu">
                                        <a class="dropdown-item" href="#addModal" data-toggle="modal">Add New Sub Parameter</a>
                                        <a class="dropdown-item" href="#addModalGradeSubParameter" data-toggle="modal">Add New Grade Sub Parameter</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?= $this->include('components/alert.php'); ?>
                    <div class="card">
                        <div class="card-header color-dark fw-500">
                            Data Sub Parameter
                        </div>
                        <div class="card-body p-0">
                            <div class=" p-25 bg-white mb-30">
                                <div class="table-responsive">
                                    <table class="table mb-0" id="DT-default" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="content-visibility: hidden;">No.</th>
                                                <th>Nomor</th>
                                                <th>Sub Parameter Code</th>
                                                <th>Parameter Code</th>
                                                <th>Name</th>
                                                <th>Weight</th>
                                                <th>Perhitungan</th>
                                                <th>Target</th>
                                                <th>Normalized Weight</th>
                                                <th>Bobot Mutlak</th>
                                                <th style="width: 10%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($data["data"] as $key => $value) {
                                            ?>
                                                <tr>
                                                    <td style="content-visibility: hidden;"><?= $value["sub_parameter_id"] ?></td>
                                                    <td><?= $key + 1 ?></td>
                                                    <td><?= $value["sub_parameter_code"] ?></td>
                                                    <td><?= $value["parameter_code"] ?></td>
                                                    <td><?= $value["name"] ?></td>
                                                    <td><?= $value["weight"] ?></td>
                                                    <td><?= $value["calculation"] ?></td>
                                                    <td>
                                                        <?php
                                                        if ($value["target"]) {
                                                            echo $value["target"];
                                                        } else {
                                                            echo "-";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        echo $value["weight"] . "/" . $data["totalWeightByCode"][$value["parameter_code"]] . " = " . "<b>" . $value["normalized_weight"] . "</b>";
                                                        ?>
                                                    </td>
                                                    <td><b><?= $value["absolute_weight"] ?></b></td>
                                                    <td>
                                                        <ul class="orderDatatable_actions mb-0 d-flex" style="justify-content: center;">
                                                            <li>
                                                                <a href="#editModal" class="edit">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#deleteModal" data-toggle="modal" class="remove" onclick="setDeleteId(<?= $value['sub_parameter_id']; ?>)">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p>
                                $$ \frac{ Bobot\ Sub\ Paramater }{ Total\ Bobot\ Sub\ Paramaeter } $$
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-5 mb-5">
                    <?= $this->include('components/alert.php'); ?>
                    <div class="card">
                        <div class="card-header color-dark fw-500">
                            Data Grade Sub Parameter -> Khusus Data Yang Punya Detailing Tertentu
                        </div>
                        <div class="card-body p-0">
                            <div class=" p-25 bg-white mb-30">
                                <div class="table-responsive">
                                    <table class="table mb-0" id="DT2-default" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="content-visibility: hidden;">No.</th>
                                                <th>Nomor</th>
                                                <th>Sub Parameter Code</th>
                                                <th>Description</th>
                                                <th>Weight</th>
                                                <th style="width: 10%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($data["gradeSubParametersData"] as $key => $value) {
                                            ?>
                                                <tr>
                                                    <td style="content-visibility: hidden;"><?= $value["grade_sub_parameter_id"] ?></td>
                                                    <td><?= $key + 1 ?></td>
                                                    <td><?= $value["sub_parameter_code"] ?></td>
                                                    <td><?= $value["description"] ?></td>
                                                    <td><?= $value["value"] ?></td>
                                                    <td>
                                                        <ul class="orderDatatable_actions mb-0 d-flex" style="justify-content: center;">
                                                            <li>
                                                                <a href="#editModalGradeSubParameter" class="editGrade">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#deleteModalGradeSubParameter" data-toggle="modal" class="remove" onclick="setDeleteIdGrade(<?= $value['grade_sub_parameter_id']; ?>)">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
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

<!-- Modal Add -->
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Item</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addForm" action=<?= route_to("hrd.sub-parameter.store") ?> method="POST">
                    <div class="form-group">
                        <label for="kodeParameter">Kode Parameter</label>
                        <select name="kodeParameter" id="kodeParameter" class="form-control" required>
                            <?php
                            foreach ($data["parametersData"] as $key => $value) {
                            ?>
                                <option value="<?= $value["parameter_code"] ?>"><?= $value["parameter_code"] ?> - <?= $value["name"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kodeSubParameter">Kode Sub Parameter</label>
                        <input type="text" class="form-control" id="kodeSubParameter" name="kodeSubParameter" placeholder="Enter sub parameter code">
                    </div>
                    <div class="form-group">
                        <label for="namaSubParameter">Nama SubParameter</label>
                        <input type="text" class="form-control" id="namaSubParameter" name="namaSubParameter" placeholder="Enter sub parameter name">
                    </div>
                    <div class="form-group">
                        <label for="bobot">Bobot</label>
                        <input type="number" class="form-control" id="bobot" name="bobot" placeholder="Enter weight">
                    </div>
                    <div class="form-group">
                        <label for="perhitungan">Perhitungan</label>
                        <select name="perhitungan" id="perhitungan" class="form-control" required>
                            <option value="Rating dan Profile Matching">Rating dan Profile Matching</option>
                            <option value="Profile Matching">Profile Matching</option>
                            <option value="Rating">Rating</option>
                            <option value="Benefit">Benefit</option>
                            <option value="Cost">Cost</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="target">Target</label>
                        <input type="number" class="form-control" id="target" name="target" placeholder="Enter target">
                        <small class="form-text text-muted">Kosongkan jika tidak ada target dan perhatikan target harus sesuai dengan grade sub parameter</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="submitAddForm()">Add</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Item</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editForm" action=<?= route_to("hrd.sub-parameter.update") ?> method="POST">
                    <input type="hidden" id="editId" name="editId">
                    <div class="form-group">
                        <label for="editKodeParameter">Kode Parameter</label>
                        <select name="editKodeParameter" id="editKodeParameter" class="form-control" required>
                            <?php
                            foreach ($data["parametersData"] as $key => $value) {
                            ?>
                                <option value="<?= $value["parameter_code"] ?>"><?= $value["parameter_code"] ?> - <?= $value["name"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editKodeSubParameter">Kode Sub Parameter</label>
                        <input type="text" class="form-control" id="editKodeSubParameter" name="editKodeSubParameter" placeholder="Enter sub parameter code">
                    </div>
                    <div class="form-group">
                        <label for="editNamaSubParameter">Nama SubParameter</label>
                        <input type="text" class="form-control" id="editNamaSubParameter" name="editNamaSubParameter" placeholder="Enter sub parameter name">
                    </div>
                    <div class="form-group">
                        <label for="editBobot">Bobot</label>
                        <input type="number" class="form-control" id="editBobot" name="editBobot" placeholder="Enter weight">
                    </div>
                    <div class="form-group">
                        <label for="editPerhitungan">Perhitungan</label>
                        <select name="editPerhitungan" id="editPerhitungan" class="form-control" required>
                            <option value="Rating dan Profile Matching">Rating dan Profile Matching</option>
                            <option value="Profile Matching">Profile Matching</option>
                            <option value="Rating">Rating</option>
                            <option value="Benefit">Benefit</option>
                            <option value="Cost">Cost</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editTarget">Target</label>
                        <input type="text" class="form-control" id="editTarget" name="editTarget" placeholder="Enter target">
                        <small class="form-text text-muted">Kosongkan jika tidak ada target dan perhatikan target harus sesuai dengan grade sub parameter</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="submitEditForm()">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this item?</p>
                <input type="hidden" id="deleteId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="submitDelete()">Delete</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
</div>

<!-- Modal Add -->
<div id="addModalGradeSubParameter" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Item</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addFormGrade" action=<?= route_to("hrd.grade-sub-parameter.store") ?> method="POST">
                    <div class="form-group">
                        <label for="kodeSubParameter">Kode Sub Parameter</label>
                        <select name="kodeSubParameter" id="kodeSubParameter" class="form-control" required>
                            <?php
                            foreach ($data["data"] as $key => $value) {
                            ?>
                                <option value="<?= $value["sub_parameter_code"] ?>"><?= $value["sub_parameter_code"] ?> - <?= $value["name"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Description</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Enter description">
                    </div>
                    <div class="form-group">
                        <label for="value">Value</label>
                        <input type="number" class="form-control" id="value" name="value" placeholder="Enter Value">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="submitAddFormGrade()">Add</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModalGradeSubParameter" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Item</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editFormGrade" action=<?= route_to("hrd.grade-sub-parameter.update") ?> method="POST">
                    <input type="hidden" id="editGradeId" name="editGradeId">
                    <div class="form-group">
                        <label for="editKodeSubParameterOther">Kode Sub Parameter</label>
                        <select name="editKodeSubParameterOther" id="editKodeSubParameterOther" class="form-control" required>
                            <?php
                            foreach ($data["data"] as $key => $value) {
                            ?>
                                <option value="<?= $value["sub_parameter_code"] ?>"><?= $value["sub_parameter_code"] ?> - <?= $value["name"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editDeskripsi">Description</label>
                        <input type="text" class="form-control" id="editDeskripsi" name="editDeskripsi" placeholder="Enter description">
                    </div>
                    <div class="form-group">
                        <label for="editValue">Value</label>
                        <input type="number" class="form-control" id="editValue" name="editValue" placeholder="Enter Value">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="submitEditFormGrade()">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div id="deleteModalGradeSubParameter" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this item?</p>
                <input type="hidden" id="deleteIdGrade">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="submitDeleteGrade()">Delete</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
</div>



<?= $this->include('layouts/footer') ?>

<script>
    $(document).ready(function() {
        var cardHeaderText = $('.card-header').text().trim();
        var currentDateTime = new Date().toISOString().slice(0, 19).replace(/-/g, '').replace(/:/g, '').replace('T', '_');

        var table = $("#DT-default").DataTable({
            dom: 'lfrtip',
            buttons: [{
                    extend: 'csv',
                    title: cardHeaderText,
                    exportOptions: {
                        columns: ':not(:last-child)'
                    },
                    filename: cardHeaderText + '_' + currentDateTime
                },
                {
                    extend: 'excel',
                    title: cardHeaderText,
                    exportOptions: {
                        columns: ':not(:last-child)'
                    },
                    filename: cardHeaderText + '_' + currentDateTime
                },
                {
                    extend: 'pdf',
                    title: cardHeaderText,
                    exportOptions: {
                        columns: ':not(:last-child)'
                    },
                    filename: cardHeaderText + '_' + currentDateTime,
                    customize: function(doc) {
                        doc.defaultStyle.fontSize = 10; // Smaller font size
                        doc.content[1].table.widths =
                            Array.from(Array(doc.content[1].table.body[0].length).keys(), () => '*');
                    }
                },
            ],
            order: [
                [1, 'asc']
            ],
            "pageLength": 25,
        });

        var table2 = $("#DT2-default").DataTable({
            dom: 'lfrtip',
            buttons: [{
                    extend: 'csv',
                    title: cardHeaderText,
                    exportOptions: {
                        columns: ':not(:last-child)'
                    },
                    filename: cardHeaderText + '_' + currentDateTime
                },
                {
                    extend: 'excel',
                    title: cardHeaderText,
                    exportOptions: {
                        columns: ':not(:last-child)'
                    },
                    filename: cardHeaderText + '_' + currentDateTime
                },
                {
                    extend: 'pdf',
                    title: cardHeaderText,
                    exportOptions: {
                        columns: ':not(:last-child)'
                    },
                    filename: cardHeaderText + '_' + currentDateTime,
                    customize: function(doc) {
                        doc.defaultStyle.fontSize = 10; // Smaller font size
                        doc.content[1].table.widths =
                            Array.from(Array(doc.content[1].table.body[0].length).keys(), () => '*');
                    }
                },
            ],
            order: [
                [1, 'asc']
            ],
            "pageLength": 25,
        });

        function printTable() {
            var originalTable = document.getElementById('DT-default');
            var clonedTable = originalTable.cloneNode(true);

            Array.from(clonedTable.rows).forEach(row => {
                row.deleteCell(-1); // -1 is the last cell
            });

            var printStyles = `
                                <style>
                                    thead { 
                                        background-color: #4CAF50; 
                                        color: white; 
                                    }
                                    th, td {
                                        border: 1px solid #ddd;
                                        padding: 8px;
                                        text-align: left;
                                    }
                                    table {
                                        border-collapse: collapse;
                                        width: 100%;
                                    }
                                </style>
                            `;

            var newWin = window.open('', '_blank');
            newWin.document.open();
            newWin.document.write('<html><head><title>Print</title>' + printStyles + '</head><body>');
            newWin.document.write(clonedTable.outerHTML);
            newWin.document.write('</body></html>');
            newWin.document.close();
            newWin.print();
        }

        $('#printButton').on('click', function() {
            printTable();
        });

        $('#copyButton').on('click', function() {
            table.button('.buttons-copy').trigger();
        });

        $('#csvButton').on('click', function() {
            table.button('.buttons-csv').trigger();
        });

        $('#excelButton').on('click', function() {
            table.button('.buttons-excel').trigger();
        });

        $('#pdfButton').on('click', function() {
            table.button('.buttons-pdf').trigger();
        });

        $(".edit").click(function() {
            let row = $(this).closest("tr");
            let id = row.find("td:eq(0)").text();
            let kodeSubParameter = row.find("td:eq(2)").text();
            let kodeParameter = row.find("td:eq(3)").text();
            let namaSubParameter = row.find("td:eq(4)").text();
            let bobot = row.find("td:eq(5)").text();
            let perhitungan = row.find("td:eq(6)").text();


            $("#editId").val(id);
            $("#editKodeSubParameter").val(kodeSubParameter);
            $("#editKodeParameter").val(kodeParameter);
            $("#editNamaSubParameter").val(namaSubParameter);
            $("#editBobot").val(bobot);
            $("#editPerhitungan").val(perhitungan);

            $("#editModal").modal("show");
        });

        $(".editGrade").click(function() {
            let row = $(this).closest("tr");
            let id = row.find("td:eq(0)").text();
            let kodeSubParameter = row.find("td:eq(2)").text();
            let deskripsi = row.find("td:eq(3)").text();
            let value = row.find("td:eq(4)").text();

            console.log(kodeSubParameter);

            $("#editGradeId").val(id);
            $("#editKodeSubParameterOther").val(kodeSubParameter);
            $("#editDeskripsi").val(deskripsi);
            $("#editValue").val(value);

            $("#editModalGradeSubParameter").modal("show");
        });
    });

    function submitEditForm() {
        $("#editForm").submit();
    }

    function submitAddForm() {
        $("#addForm").submit();
    }

    function setDeleteId(id) {
        $("#deleteId").val(id);
    }

    function submitDelete() {
        let id = $("#deleteId").val();
        window.location.href = "<?= base_url('hrd/sub-parameter/delete') ?>/" + id;
    }

    function submitEditFormGrade() {
        $("#editFormGrade").submit();
    }

    function submitAddFormGrade() {
        $("#addFormGrade").submit();
    }

    function setDeleteIdGrade(id) {
        $("#deleteIdGrade").val(id);
    }

    function submitDeleteGrade() {
        let id = $("#deleteIdGrade").val();
        window.location.href = "<?= base_url('hrd/grade-sub-parameter/delete') ?>/" + id;
    }
</script>