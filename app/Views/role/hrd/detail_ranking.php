<style>

</style>

<?= $this->include('layouts/header') ?>
<main class="main-content">
    <?= $this->include("layouts/sidebar") ?>
    <div class="contents">

        <div class="container-fluid">
            <div class="row">
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="accordion" id="accordionExample">
                        <div class="card mt-20">
                            <div class="card-header" id="headingSix">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                        <h1>1. Ranking</h1>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseSix" aria-labelledby="headingSix" data-parent="#accordionExample">
                                <div class="card-body">
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
                                            <?php
                                            $rank = 1;
                                            foreach ($data["data"] as $key => $value) {
                                                $style = ($rank == 1) ? 'style="background-color: green; color: white;"' : '';
                                            ?>
                                                <tr <?= $style ?>>
                                                    <td><?= $rank ?></td>
                                                    <td><?= $value["candidate_code"] . " - " . get_user_by_candidate_code($value["candidate_code"])["name"] ?></td>
                                                    <td><?= $value["leaving_flow"] ?></td>
                                                    <td><?= $value["entering_flow"] ?></td>
                                                    <td><?= $value["net_flow"] ?></td>
                                                </tr>
                                            <?php
                                                $rank++;
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

</script>