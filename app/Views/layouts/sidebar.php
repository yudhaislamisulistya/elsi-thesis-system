<aside class="sidebar-wrapper">
    <div class="sidebar sidebar-collapse" id="sidebar">
        <div class="sidebar__menu-group">
            <ul class="sidebar_nav">
                <?php

                $role = session()->get('role');

                if ($role == 'HRD') {
                ?>
                    <li class="menu-title">
                        <span>Main menu</span>
                    </li>
                    <li>
                        <a href="<?= route_to("hrd.dashboard") ?>" class="">
                            <span data-feather="home" class="nav-icon"></span>
                            <span class="menu-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-title m-top-30">
                        <span>Proses</span>
                    </li>
                    <li>
                        <a href="<?= route_to("hrd.profile-matching.index") ?>" class="">
                            <span data-feather="file-plus" class="nav-icon"></span>
                            <span class="menu-text">Profile Matching</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= route_to("hrd.promethee.index") ?>" class="">
                            <span data-feather="code" class="nav-icon"></span>
                            <span class="menu-text">PROMETHEE</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= route_to("hrd.ranking.index") ?>" class="">
                            <span data-feather="filter" class="nav-icon"></span>
                            <span class="menu-text">Ranking</span>
                        </a>
                    </li>
                    <li class="menu-title m-top-30">
                        <span>Data</span>
                    </li>
                    <li>
                        <a href="<?= route_to("hrd.candidate.index") ?>" class="">
                            <span data-feather="file-text" class="nav-icon"></span>
                            <span class="menu-text">Data Pelamar</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= route_to("hrd.parameter.index") ?>" class="">
                            <span data-feather="hard-drive" class="nav-icon"></span>
                            <span class="menu-text">Data Parameter</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= route_to("hrd.sub-parameter.index") ?>" class="">
                            <span data-feather="book" class="nav-icon"></span>
                            <span class="menu-text">Data Sub Parameter</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= route_to("hrd.preference.index") ?>" class="">
                            <span data-feather="type" class="nav-icon"></span>
                            <span class="menu-text">Data Tipe Preferensi</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= route_to("hrd.batch.index") ?>" class="">
                            <span data-feather="book-open" class="nav-icon"></span>
                            <span class="menu-text">Batch Pendaftaran</span>
                        </a>
                    </li>
                <?php
                } else {
                ?>
                    <li class="menu-title">
                        <span>Main menu</span>
                    </li>
                    <li>
                        <a href="<?= route_to("candidate.dashboard") ?>" class="">
                            <span data-feather="home" class="nav-icon"></span>
                            <span class="menu-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-title m-top-30">
                        <span>Proses</span>
                    </li>
                    <li>
                        <a href="<?= route_to("candidate.batch.index") ?>" class="">
                            <span data-feather="file-plus" class="nav-icon"></span>
                            <span class="menu-text">Batch</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= route_to("hrd.ranking.index") ?>" class="">
                            <span data-feather="filter" class="nav-icon"></span>
                            <span class="menu-text">Ranking</span>
                        </a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</aside>