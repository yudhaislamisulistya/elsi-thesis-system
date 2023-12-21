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
                        <h4 class="text-capitalize breadcrumb-title">Data PROMETHEE</h4>
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
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?= $this->include('components/alert.php'); ?>
                    <div class="card">
                        <div class="card-header color-dark fw-500">
                            PROMETHEE
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
                                                <th style="width: 5%;">Action</th>
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
                                                        <ul class="orderDatatable_actions mb-0 d-flex" style="justify-content: center;">
                                                            <li>
                                                                <a href="<?= route_to('hrd.promethee.detail', $value["code"]) ?>" class="edit">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                        <circle cx="12" cy="12" r="3"></circle>
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
    });
</script>