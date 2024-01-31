<?= $this->include('layouts/header') ?>
<main class="main-content">
    <?= $this->include("layouts/sidebar") ?>
    <div class="contents">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Data Profile Matching</h4>
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
                                <a href="#addModal" class="btn btn-sm btn-primary btn-add" data-toggle="modal">
                                    <i class="la la-plus"></i> Add New
                                </a>
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
                            Data Parameter
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
                                                <th>Bobot Ternormalisasi Sub Parameter</th>
                                                <th>Tipe Preferensi</th>
                                                <th>Target</th>
                                                <th>Nilai Batas Awal (q)</th>
                                                <th>Nilai Batas Akhir (p)</th>
                                                <th style="width: 10%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($data["data"] as $key => $value) {
                                            ?>
                                                <tr>
                                                    <td style="content-visibility: hidden;"><?= $value["preference_id"] ?></td>
                                                    <td><?= $key + 1 ?></td>
                                                    <td><?= $value["sub_parameter_code"] . " - " . get_sub_parameter_by_code($value["sub_parameter_code"])["name"] ?></td>
                                                    <td><?= $value["sub_parameter_weight"] ?></td>
                                                    <td><?= $value["sub_parameter_type"] ?></td>
                                                    <td><?= $value["preference_target_value"] ?></td>
                                                    <td><?= $value["start_bound_q"] ?></td>
                                                    <td><?= $value["end_bound_p"] ?></td>
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
                                                                <a href="#deleteModal" data-toggle="modal" class="remove" onclick="setDeleteId(<?= $value['preference_id']; ?>)">
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
                <form id="addForm" action=<?= route_to("hrd.preference.store") ?> method="POST">
                    <div class="form-group">
                        <label for="kodeSubParameter">Kode Sub Parameter</label>
                        <select name="kodeSubParameter" id="kodeSubParameter" class="form-control">
                            <?php
                            foreach ($data["subParameterData"] as $key2 => $value) {
                            ?>
                                <option value="<?= $value["sub_parameter_code"] ?>"><?= $value["sub_parameter_code"] . " - " . $value["name"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tipePreferensi">Tipe Preferensi</label>
                        <select name="tipePreferensi" id="tipePreferensi" class="form-control">
                            <option value="Kriteria Biasa">Kriteria Biasa - Tipe 1</option>
                            <option value="Kriteria Quasi">Kriteria Quasi - Tipe 2</option>
                            <option value="Kriteria Linier">Kriteria Linier - Tipe 3</option>
                            <option value="Kriteria Level">Kriteria Level - Tipe 4</option>
                            <option value="Kriteria Linier & Area Indifference">Kriteria Linier & Area Indifference - Tipe 5</option>
                            <option value="Kriteria Gaussian">Kriteria Gaussian - Tipe 6</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="target">Target</label>
                        <input type="text" class="form-control" id="target" name="target" placeholder="Enter preference name">
                    </div>
                    <div class="form-group">
                        <label for="nilaiBatasAwal">Nilai Batas Awal (q)</label>
                        <input type="text" class="form-control" id="nilaiBatasAwal" name="nilaiBatasAwal" placeholder="Enter preference name">
                    </div>
                    <div class="form-group">
                        <label for="nilaiBatasAkhir">Nilai Batas Akhir (p)</label>
                        <input type="text" class="form-control" id="nilaiBatasAkhir" name="nilaiBatasAkhir" placeholder="Enter preference name">
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
                <form id="editForm" action=<?= route_to("hrd.preference.update") ?> method="POST">
                    <input type="hidden" id="editId" name="editId">
                    <div class="form-group">
                        <label for="editKodeSubParameter">Kode Sub Parameter</label>
                        <select name="editKodeSubParameter" id="editKodeSubParameter" class="form-control">
                            <?php
                            foreach ($data["subParameterData"] as $key2 => $value) {
                            ?>
                                <option value="<?= $value["sub_parameter_code"] ?>"><?= $value["sub_parameter_code"] . " - " . $value["name"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editTipePreferensi">Tipe Preferensi</label>
                        <select name="editTipePreferensi" id="editTipePreferensi" class="form-control">
                            <option value="Kriteria Biasa">Kriteria Biasa - Tipe 1</option>
                            <option value="Kriteria Quasi">Kriteria Quasi - Tipe 2</option>
                            <option value="Kriteria Linier">Kriteria Linier - Tipe 3</option>
                            <option value="Kriteria Level">Kriteria Level - Tipe 4</option>
                            <option value="Kriteria Linier & Area Indifference">Kriteria Linier & Area Indifference - Tipe 5</option>
                            <option value="Kriteria Gaussian">Kriteria Gaussian - Tipe 6</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editTarget">Target</label>
                        <input type="text" class="form-control" id="editTarget" name="editTarget" placeholder="Enter preference name">
                    </div>
                    <div class="form-group">
                        <label for="editNilaiBatasAwal">Nilai Batas Awal (q)</label>
                        <input type="text" class="form-control" id="editNilaiBatasAwal" name="editNilaiBatasAwal" placeholder="Enter preference name">
                    </div>
                    <div class="form-group">
                        <label for="editNilaiBatasAkhir">Nilai Batas Akhir (p)</label>
                        <input type="text" class="form-control" id="editNilaiBatasAkhir" name="editNilaiBatasAkhir" placeholder="Enter preference name">
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
            pageLength: 25,
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
            let tipePreferensi = row.find("td:eq(4)").text();
            let target = row.find("td:eq(5)").text();
            let nilaiBatasAwal = row.find("td:eq(6)").text();
            let nilaiBatasAkhir = row.find("td:eq(7)").text();
            kodeSubParameter = kodeSubParameter.split(" - ")[0];

            $("#editId").val(id);
            $("#editKodeSubParameter").val(kodeSubParameter);
            $("#editTipePreferensi").val(tipePreferensi);
            $("#editTarget").val(target);
            $("#editNilaiBatasAwal").val(nilaiBatasAwal);
            $("#editNilaiBatasAkhir").val(nilaiBatasAkhir);

            $("#editModal").modal("show");
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
        window.location.href = "<?= base_url('hrd/preference/delete') ?>/" + id;
    }
</script>