<?php
/* $accessApp = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';
if($accessApp !== 'com.serupay.app'):
    redirect('0', str_replace('area.', '', base_url()));
endif; */
?>
<!doctype html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title><?= $_CONFIG['title'] ?></title>
    <meta name="description" content="<?= $_CONFIG['description'] ?>">
    <meta name="keywords" content="<?= $_CONFIG['keyword'] ?>">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="<?= $_CONFIG['icon'] ?>" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= assets('mobile/') ?>img/Logo/logo.png">
    <link rel="stylesheet" href="<?= assets('mobile/') ?>css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= assets('mobile/') ?>css/theme.css?v=<?= time() ?>">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link rel="manifest" href="__manifest.json">
    <script src="<?= assets('mobile/') ?>js/lib/jquery-3.4.1.min.js"></script>
    <script src="<?= assets('mobile/') ?>js/lib/popper.min.js"></script>
    <script src="<?= assets('mobile/') ?>js/lib/bootstrap.min.js"></script>
</head>

<body<?= in_array($page, ['Menunggu Pembayaran', 'Pembayaran Berhasil', 'Rincian Transaksi', 'Login', 'Verifikasi OTP', 'Verifikasi PIN', 'Daftar', 'Lupa Password']) ? ' class="bg-primary"' : ( $page == 'Upgrade Level' ? ' class="rgs-upgrade-level bg-primary"' : ( $page == 'Dashboard' ? ' class="rgs-home"' : ( in_array($page, ['Detail Berita', 'Ganti PIN']) ? ' class="bg-white"' : '' ) )) ?>>

    
    <div id="loader">
    <div class="spinner-border text-primary" role="status"></div>
    </div>

    <!-- App Header -->
<? if($page === 'Dashboard'): ?>
    <div class="appHeader no-border text-light">
        <div class="left">
            <a href="<?= base_url() ?>" class="headerButton">
                <img src="<?= $_CONFIG['icon'] ?>" width="40px">
            </a>
            <div class="pageTitle rgs-head-home bold">
                <?= $data_user['name'] ?><br>
                <span><?= strtoupper($data_user['level']) ?></span>
            </div>
        </div>
        <div class="right">
            <a href="<?= base_url('page/info.php') ?>" class="headerButton">
                <ion-icon name="notifications-outline" class="text-light"></ion-icon>
            </a>
        </div>
    </div>
<? elseif($page === 'Login'): ?>
    <div class="appHeader no-border transparent position-absolute text-light bold">
        <div class="pageTitle d-flex justify-content-center align-items-center">
            <img src="<?= assets('mobile/img/Logo/logo.png'); ?>" alt="logo" class="logo" style="max-height: 144px;">
        </div>
        <div class="right">
            <a href="javascript:;" class="headerButton" data-toggle="modal" data-target="#register">Daftar</a>
        </div>
    </div>
<? elseif($page === 'Akun Saya'): ?>
    <div class="appHeader no-border bg-primary text-light">
        <div class="left"></div>
        <div class="pageTitle bold"><?= $page ?></div>
        <div class="right"></div>
    </div>
<? elseif($page === 'Verifikasi OTP' || $page === 'Verifikasi PIN' || $page === 'Daftar'): ?>
    <div class="appHeader no-border bg-primary text-light">
        <div class="left">
            <form method="POST">
                <button type="submit" name="cancel" class="btn btn-icon btn-md pt-2 btn-primary mr-1 mb-1">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </button>
            </form>
        </div>
        <div class="pageTitle bold"><?= $page ?></div>
        <div class="right"></div>
    </div>
<? elseif($page === 'Menunggu Pembayaran' || $page === 'Pembayaran Berhasil'): ?>
    <div class="appHeader no-border bg-primary text-light">
        <div class="left"></div>
        <div class="right"></div>
    </div>
<? elseif($page === 'Upgrade Level'): ?>
    <div class="appHeader no-border bg-primary text-light">
        <div class="left"></div>
        <div class="pageTitle bold">
            <?= strtoupper($page) ?>
        </div>
        <div class="right">
            <a href="<?= base_url() ?>" class="headerButton">
                <ion-icon name="close-outline" class="text-light"></ion-icon>
            </a>
        </div>
    </div>
    <div class="extraHeader rgs-upgrade-level-header no-border bg-primary">
        <h1>Premium</h1>
    </div>
<? elseif($page === 'Coming Soon'): ?>
    <div class="appHeader no-border transparent position-absolute">
        <div class="left">
            <a href="<?= base_url() ?>" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle bold"><?= $page ?></div>
        <div class="right">
            <a href="#"data-toggle="modal" data-target="#openMenu" class="headerButton">
                <ion-icon name="ellipsis-vertical-outline"></ion-icon>
            </a>
        </div>
    </div>
<? else: ?>
    <div class="appHeader no-border<?= in_array($page, ['Detail Berita', 'Kembali', 'Tournament Game']) ? ' scrolled' : '' ?> bg-primary text-light">
        <div class="left">
            <a href="<?= in_array($page, ['Ubah Profil', 'Ganti PIN']) ? base_url('account/profile') : base_url() ?>" class="headerButton">
                <ion-icon name="chevron-back-outline"<?= in_array($page, ['Detail Berita', 'Kembali', 'Tournament Game']) ? ' class="text-light"' : '' ?>></ion-icon>
            </a>
        </div>
        <div class="pageTitle bold">
            <?= $page ?>
        </div>
        <div class="right">
            <? if(!in_array($page, ['Verifikasi PIN', 'Verifikasi OTP', 'Daftar'])): ?>
            <a href="#"data-toggle="modal" data-target="#openMenu" class="headerButton">
                <ion-icon name="ellipsis-vertical-outline" class="text-light"></ion-icon>
            </a>
            <? endif?>
        </div>
    </div>
    <? if($page === 'Pemberitahuan'): ?>
    <div class="extraHeader no-border bg-primary">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Informasi" role="tab" aria-selected="true">
                    Informasi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Berita" role="tab" aria-selected="false">
                    Berita & Promo
                </a>
            </li>
        </ul>
    </div>
    <? elseif($page === 'Riwayat') : ?>
    <div class="extraHeader no-border bg-primary">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Transaksi" role="tab" aria-selected="true">
                    Transaksi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Topup" role="tab" aria-selected="false">
                    Isi Saldo
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Mutasi" role="tab" aria-selected="false">
                    Mutasi Saldo
                </a>
            </li>
        </ul>
    </div>
    <? elseif($page === 'Isi Saldo') : ?>
    <div class="extraHeader no-border bg-primary">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#topup" role="tab" aria-selected="true">
                    Topup
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#voucher" role="tab" aria-selected="false">
                    Klaim Voucher
                </a>
            </li>
        </ul>
    </div>
    <? elseif($page === 'Ranking') : ?>
    <div class="extraHeader no-border bg-primary">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#topup" role="tab">
                    Top Up
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#order" role="tab">
                    Order
                </a>
            </li>
        </ul>
    </div>
    <? elseif($page === 'Games') : ?>
    <div class="extraHeader no-border bg-primary">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Semua" role="tab">
                    Semua
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Topup" role="tab">
                    Topup
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Voucher" role="tab">
                    Voucher
                </a>
            </li>
        </ul>
    </div>
    <? elseif($page === 'Voucher') : ?>
    <div class="extraHeader no-border bg-primary">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Semua" role="tab">
                    Semua
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Data" role="tab">
                    Data
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Digital" role="tab">
                    Digital
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#TV" role="tab">
                    TV
                </a>
            </li>
        </ul>
    </div>
    <? elseif($page === 'E-Money') : ?>
    <div class="extraHeader no-border bg-primary">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Semua" role="tab">
                    Semua
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#EMoney" role="tab">
                    E-Money
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Driver" role="tab">
                    Driver
                </a>
            </li>
        </ul>
    </div>
    <? elseif($page === 'Fitur Premium') : ?>
    <div class="extraHeader no-border bg-primary">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Penarikan" role="tab" aria-selected="true">
                    Riwayat Penarikan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Komisi" role="tab" aria-selected="false">
                    Riwayat Komisi
                </a>
            </li>
        </ul>
    </div>
    <? elseif($page === 'Tukar Poin') : ?>
    <div class="extraHeader no-border bg-primary">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#rewards" role="tab">
                    Hadiah
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#history" role="tab">
                     Riwayat
                </a>
            </li>
        </ul>
    </div>
    <? endif ?>
<? endif ?>
    <!-- * App Header -->
     
    <!-- openMenu Action Sheet -->
    <div class="modal fade action-sheet" id="openMenu" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Menu</h5>
                </div>
                <div class="modal-body">
                    <ul class="action-button-list">
                        <li>
                            <a href="<?= base_url() ?>" class="btn btn-list text-primary" style="justify-content: center">
                                <span class="text-center">Kembali Ke Beranda</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('page/about-us') ?>" class="btn btn-list text-primary" style="justify-content: center">
                                <span>Hubungi Kami</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('page/terms-conditions') ?>" class="btn btn-list text-primary" style="justify-content: center">
                                <span>Syarat Dan Ketentuan</span>
                            </a>
                        </li>
                        <li class="action-divider"></li>
                        <li>
                            <a href="#" class="btn btn-list text-primary" data-dismiss="modal" style="justify-content: center">
                                <span>Close</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- * openMenu Action Sheet -->