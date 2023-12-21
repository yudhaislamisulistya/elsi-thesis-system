<?php

$role = session()->get('role');

?>

<?= $this->include('layouts/header') ?>
<main class="main-content">
    <?= $this->include("layouts/sidebar") ?>
    <div class="contents">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Data Profile Matching</h4>
                        <?php
                        if ($role == 'HRD') {
                        ?>
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
                        <?php

                        }

                        ?>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?= $this->include('components/alert.php'); ?>
                    <div class="card">
                        <div class="card-header color-dark fw-500">
                            Data Batch
                        </div>
                        <div class="card-body p-0">
                            <div class=" p-25 bg-white mb-30">
                                <div class="table-responsive">
                                    <table class="table mb-0" id="DT-default" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="content-visibility: hidden;">No.</th>
                                                <th>Nomor</th>
                                                <th>Code</th>
                                                <th>Nama Batch</th>
                                                <th>Description</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Selesai</th>
                                                <th style="width: 10%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($data["data"] as $key => $value) {
                                            ?>
                                                <tr>
                                                    <td style="content-visibility: hidden;"><?= $value["id"] ?></td>
                                                    <td><?= $key + 1 ?></td>
                                                    <td><?= $value["code"] ?></td>
                                                    <td><?= $value["name"] ?></td>
                                                    <td><?= $value["description"] ?></td>
                                                    <td><?= $value["start_period"] ?></td>
                                                    <td><?= $value["end_period"] ?></td>
                                                    <td>
                                                        <?php

                                                        if ($role == "HRD") {

                                                        ?>
                                                            <ul class="orderDatatable_actions mb-0 d-flex">
                                                                <li>
                                                                    <a href="#" class="view">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                            <circle cx="12" cy="12" r="3"></circle>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#editModal" class="edit">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#deleteModal" data-toggle="modal" class="remove" onclick="setDeleteId(<?= $value['id']; ?>)">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        <?php

                                                        } else {
                                                            $today = date("Y-m-d");
                                                            if ($today < $value["start_period"] || $today > $value["end_period"]) {
                                                                $disabled = "disabled";
                                                            } else {
                                                                $disabled = "";
                                                            }
                                                        ?>
                                                            <a href="<?= route_to("candidate.form.index", $value["code"]) ?>" class="btn btn-sm btn-primary <?= $disabled ?>">Isi Form</a>
                                                        <?php
                                                        }

                                                        ?>
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
                <form id="addForm" action=<?= route_to("hrd.batch.store") ?> method="POST">
                    <div class="form-group">
                        <label for="namaBatch">Nama Batch</label>
                        <input type="text" class="form-control" id="namaBatch" name="namaBatch" placeholder="Enter batch name">
                    </div>
                    <!-- deskripsi -->
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="col position-relative">
                            <label for="periodeMulai">Periode Mulai</label>
                            <input type="date" class="form-control" id="periodeMulai" name="periodeMulai">
                        </div>
                        <div class="col">
                            <label for="periodeSelesai">Periode Selesai</label>
                            <input type="date" class="form-control" id="periodeSelesai" name="periodeSelesai">
                        </div>
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
                <form id="editForm" action=<?= route_to("hrd.batch.update") ?> method="POST">
                    <input type="hidden" id="editId" name="editId">
                    <div class="form-group">
                        <label for="editNamaBatch">Nama Batch</label>
                        <input type="text" class="form-control" id="editNamaBatch" name="editNamaBatch" placeholder="Enter batch name">
                    </div>
                    <!-- deskripsi -->
                    <div class="form-group">
                        <label for="editDeskripsi">Deskripsi</label>
                        <textarea class="form-control" id="editDeskripsi" name="editDeskripsi" rows="3"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="col position-relative">
                            <label for="editPeriodeMulai">Periode Mulai</label>
                            <input type="date" class="form-control" id="editPeriodeMulai" name="editPeriodeMulai">
                        </div>
                        <div class="col">
                            <label for="editPeriodeSelesai">Periode Selesai</label>
                            <input type="date" class="form-control" id="editPeriodeSelesai" name="editPeriodeSelesai">
                        </div>
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
            let namaBatch = row.find("td:eq(3)").text();
            let deskripsi = row.find("td:eq(4)").text();
            let periodeMulai = row.find("td:eq(5)").text();
            let periodeSelesai = row.find("td:eq(6)").text();

            $("#editId").val(id);
            $("#editNamaBatch").val(namaBatch);
            $("#editDeskripsi").val(deskripsi);
            $("#editPeriodeMulai").val(periodeMulai);
            $("#editPeriodeSelesai").val(periodeSelesai);

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
        window.location.href = "<?= base_url('hrd/batch/delete') ?>/" + id;
    }
</script>