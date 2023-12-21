<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data['title']; ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet">

    <!-- inject:css-->




    <link rel="stylesheet" href="<?= base_url('css/plugin.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/jquery.dataTables.min.css'); ?>">


    <!-- endinject -->

    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
    <style>
        .datepicker {
            z-index: 1000000000000;
        }

        #addModal {
            transform: none;
        }
    </style>


    </style>
</head>

<body class="layout-light side-menu overlayScroll">
    <div class="mobile-author-actions"></div>
    <header class="header-top">
        <nav class="navbar navbar-light">
            <div class="navbar-left">
                <a href="" class="sidebar-toggle">
                    <img class="svg" src="<?= base_url("/images/bars.svg") ?>" alt="img"></a>
                <a class="navbar-brand" href="#">
                    <img class="dark" src="<?= base_url("/img/png/logo.png") ?>" alt="img" height="50px" width="50px">
                    <img class="light" src="<?= base_url("/img/png/logo.png") ?>" alt="img" height="50px" width="50px">
                </a>
                <div class="top-menu">

                    <div class="strikingDash-top-menu position-relative">
                        <ul>
                            <li>
                                <a href="<?= route_to("hrd.dashboard") ?>" class="">
                                    <span class="menu-text">Dashboard</span>
                                </a>
                            </li>
                            <li class="has-subMenu">
                                <a href="#" class="">Proses</a>
                                <ul class="subMenu">
                                    <li>
                                        <a href="" class="">
                                            <span class="menu-text">Profile Matching</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="" class="">
                                            <span class="menu-text">PROMETHEE</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="" class="">
                                            <span class="menu-text">Ranking</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-subMenu">
                                <a href="#" class="">Data</a>
                                <ul class="subMenu">
                                    <li>
                                        <a href="" class="">
                                            <span data-feather="file-text" class="nav-icon"></span>
                                            <span class="menu-text">Data Pelamar</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="" class="">
                                            <span data-feather="hard-drive" class="nav-icon"></span>
                                            <span class="menu-text">Data Parameter</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="" class="">
                                            <span data-feather="book" class="nav-icon"></span>
                                            <span class="menu-text">Data Sub Parameter</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="" class="">
                                            <span data-feather="type" class="nav-icon"></span>
                                            <span class="menu-text">Data Tipe Preferensi</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="" class="">
                                            <span data-feather="book-open" class="nav-icon"></span>
                                            <span class="menu-text">Batch Pendaftaran</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- ends: navbar-left -->

            <div class="navbar-right">
                <ul class="navbar-right__menu">
                    <li class="nav-author">
                        <div class="dropdown-custom">
                            <a href="javascript:;" class="nav-item-toggle"><img src="<?= base_url("images/default.jpg") ?>" alt="" class="rounded-circle"></a>
                            <div class="dropdown-wrapper">
                                <div class="nav-author__info">
                                    <div class="author-img">
                                        <img src="<?= base_url("images/default.jpg") ?>" alt="" class="rounded-circle">
                                    </div>
                                    <div>
                                        <h6><?= session()->get("name") ?></h6>
                                        <span><?= session()->get("role") ?></span>
                                    </div>
                                </div>
                                <div class="nav-author__options">
                                    <a href="<?= route_to("logout") ?>" class="nav-author__signout">
                                        <span data-feather="log-out"></span> Sign Out</a>
                                </div>
                            </div>
                            <!-- ends: .dropdown-wrapper -->
                        </div>
                    </li>
                    <!-- ends: .nav-author -->
                </ul>
                <!-- ends: .navbar-right__menu -->
                <div class="navbar-right__mobileAction d-md-none">
                    <a href="#" class="btn-search">
                        <span data-feather="search"></span>
                        <span data-feather="x"></span></a>
                    <a href="#" class="btn-author-action">
                        <span data-feather="more-vertical"></span></a>
                </div>
            </div>
            <!-- ends: .navbar-right -->
        </nav>
    </header>