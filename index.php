<?php
require 'RGShenn.php';
if(!isset($_SESSION['user']) && !isset($_COOKIE['token']) && !isset($_COOKIE['ssid'])) {
        $ShennID = $_COOKIE['ssid'];
        $ShennUID = str_replace(['SHENN-A','AIY'],'',$ShennID) + 0;
        $ShennKey = $_COOKIE['token'];
        $ShennUser = $call->query("SELECT * FROM users WHERE id = '$ShennUID'")->fetch_assoc();

        $ShennCheck = $call->query("SELECT * FROM users_cookie WHERE cookie = '$ShennKey' AND username = '".$ShennUser['username']."'");
        if($ShennCheck->num_rows == 1) {
            $_SESSION['user'] = $ShennUser;
            redirect(0,visited());
            $call->query("UPDATE users_cookie SET active = '$date $time' WHERE cookie = '$ShennKey'");
        } else {
            redirect(0,base_url('auth/login'));
        }
} else {
    if((time() - $_SESSION['last_login_time']) > 1440) {
        redirect(0,base_url('auth/logout'));
    } else {
    $_SESSION['last_login_time'] = time();
    require _DIR_('library/session/user');
    $page = 'Dashboard';
    require _DIR_('library/header/user');
?>
    <!-- App Capsule -->
    <style>
        .urgent-alert {
            color: #FFF;
            background: #135b8f5e;
            width: 100%;
            border-radius: 3px;
            padding: 6px 12px 6px 0;
            margin-bottom: 8px;
            display: none;
        }
        .urgent-alert.show {
            display: inline-flex;
        }
        .urgent-alert .icon{
            font-size: 22px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 6px;
        }
        .marquee {
          width: 100%;
          overflow: hidden;
        }
        .urgent-alert .marquee {
            font-size: 13px;
        }
        .urgent-alert .marquee span:not(:last-child) {
            padding-right: 18px 
        }
        .infinite-menu .card:not(:last-child) {
            padding-right: 12px
        }
        .infinite-menu .card:last-child {
            padding-right: 1rem
        }
        .inifite-menu {
            margin-left: 16px;
        }
        .card.reward-poin {
            display: inline-flex;
        }
        .app-list {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 0 16px;
        }
        .app-list .sort-menu .menu {
            display: flex;
            padding-right: 4px;
        }
        .app-list > .menu {
            border-right: 2px solid #e1e1e1;
            padding-right: 4px
        }
        .app-list .btn {
            padding: 8px;
            font-size: 10px;
            height: 24px;
            font-weight: 600;
            width: 70px;
        }
        .app-list .sort-menu .menu:not(:first-child) {
            border-left: 2px solid #e1e1e1;
        }
        .app-list .sort-menu .menu .in {
            line-height: 16px;
        }
        .app-list .sort-menu .menu img {
            max-height: 30px;
            margin: 0 4px;
        }
        .app-list .sort-menu .menu .in .title {
            font-size: 10px;
            font-weight: 600;
        }
        .app-list .sort-menu .menu .in .subtitle {
            font-size: 11px;
            color: #909090;
        }
        .app-list .sort-menu {
            display: inline-flex;
            justify-content: space-between;
            align-items: center;
            width: 80%;
        }
        .app-menu .item .col {
            max-height: 56px
        }
        .rewards-bg {
            background-repeat: no-repeat !important;
            background-size: cover !important;
        }
    </style> 
    <div id="appCapsule" class="pb-0">
        <div class="section full mt-3 pb-1">
            <div class="card">
            <div class="app-menu">
                <div class="app-list">
                <div class="menu">
                    <a href="<?= base_url('deposit/deposit') ?>" class="btn btn-primary menu rounded">Isi Saldo +</a>
                </div>
                <div class="sort-menu">
                    <div class="menu">
                        <img src="<?= assets('mobile/img/home/wallet-99.png') ?>" alt="Wallet">
                        <div class="in">
                            <div class="title text-dark">Rp <?= currency($data_user['balance']) ?></div>
                            <div class="subtitle">Saldo Anda</div>
                        </div>
                    </div>
                    <a href="<?= ($data_user['level'] === 'Basic') ? base_url('account/upgrade.php') : base_url('premium'); ?>" class="menu">
                        <img src="<?= assets('mobile/img/home/wallet-99.png') ?>" alt="Komisi">
                        <div class="in">
                            <?php if($data_user['level'] === 'Basic'): ?>
                            <div class="title text-warning">Verifikasi</div>
                            <?php else: ?>
                            <div class="title text-dark">Rp <?= currency($data_user['komisi']) ?></div>
                            <?php endif; ?>
                            <div class="subtitle">Total Komisi</div>
                        </div>
                    </a>
                </div>
            </div>
            </div>
            <div class="divider mt-3"></div>
            </div>
            
            <?php if($data_user['level'] === 'Basic'): ?>
            <a href="<?= base_url('account/upgrade.php') ?>">
                <div class="alert alert-outline-primary mt-2 mr-2 ml-2" role="alert" style="background: #e6fcfa; border-radius: 8px; text-decoration: none">
                    <div style="display: inline-flex; justify-content: space-between; align-items: center; width: 100%;">
                        <div style="display: inline-flex; justify-content: space-between; align-items: center;">
                            <ion-icon name="rocket-outline" style="font-size: 26px; padding-right: 12px;"></ion-icon>
                            <div class="in">
                                <div style="font-size: 14px; font-weight: 600;">Upgrade ke Akun Premium</div>
                                <div>Dapatkan keuntungan lebih banyak!</div>
                            </div>
                        </div>
                        <div style="position: absolute; right: 6px; font-size: 26px;"><ion-icon name="chevron-forward-outline"></ion-icon></div>
                    </div>
                </div>
            </a>
            <br>
            <?php endif; ?>
            <div class="section mb-2 mt-1">
                <? require _DIR_('library/session/result-mobile') ?>
            </div>
            <div class="section full rgs-info">
                <div class="app-menu">
                    <a href="<?= base_url('order/pulsa-reguler') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/img/home/pulsa-1.png') ?>" width="50px">
                            <strong>Pulsa Reguler</strong>
                        </div>
                    </a>
                    <a href="<?= base_url('order/pulsa-transfer') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/img/home/pulsa-transfer-1.png') ?>" width="50px">
                            <strong>Pulsa Transfer</strong>
                        </div>
                    </a>
                    <a href="<?= base_url('order/paket-internet') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/img/home/paket-internet-1.png') ?>" width="50px">
                            <strong>Paket Data</strong>
                        </div>
                    </a>
                    <a href="#" onclick="toastbox('toastComingSoon', 2500)" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/img/home/tarik-dana-1.png') ?>" width="50px">
                            <strong>Tarik Dana</strong>
                        </div>
                    </a>
                    <a href="<?= base_url('order/games') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/img/home/games-1.png') ?>" width="50px">
                            <strong>Games</strong>
                        </div>
                    </a>
                </div>
                <div class="app-menu mt-4 mb-2">
                    <a href="<?= base_url('order/e-money') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/img/home/e-money-1.png') ?>" width="50px">
                            <strong>E-Money</strong>
                        </div>
                    </a>
                    <a href="<?= base_url('order/token-pln') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/img/home/token-pln-1.png') ?>" width="50px">
                            <strong>Token PLN</strong>
                        </div>
                    </a>
                    <a href="<?= base_url('order/voucher') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/img/home/data-1.png') ?>" width="50px">
                            <strong>Voucher Data</strong>
                        </div>
                    </a>
                    <a href="<?= base_url('order/pascabayar') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/img/home/pascabayar-1.png') ?>" width="50px">
                            <strong>Pascabayar</strong>
                        </div>
                    </a>
                    <a href="<?= base_url('page/menu') ?>" class="item">
                        <div class="col">
                            <div class="d-flex justify-content-center">
                                <div class="bg-primary" style="border-radius: 100%; height: 50px; width: 50px; display: flex; justify-content: center; align-items: center;">
                                    <ion-icon name="ellipsis-horizontal" class="text-light" style="font-size: 32px"></ion-icon>
                                </div>
                            </div>
                            <strong>Lainnya</strong>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <?php $rewards = $call->query("SELECT * FROM modules_point_rewards WHERE available = '1' ORDER by point ASC LIMIT 10"); ?>
        <?php if($rewards->num_rows > 0): ?>
        <div class="section full bg-white mt-1 pb-1">
            <div class="d-flex justify-content-between align-items-center pr-2">
                <div class="section-title">Tukar Poin</div>
                <a href="<?= base_url('premium/tukar-poin') ?>" class="text-primary" style="font-weight: 600;">Lihat Semua</a>
            </div>
            <div class="card mt-1 rewards-bg bg-primary">
                <div class="card-body p-2 pb-0">
                    <div class="card-title text-white" style="font-size: 14px; display: inline-flex;">
                        <div style="text-transform: uppercase;">Poin Anda</div>
                        <div class="ml-1" style="background: var(--color-theme-secondary); padding: 0px 7px; border-radius: 30px;">
                            <?= currency($data_user['point']) ?>
                        </div>
                    </div>
                    <div class="card-subtitle text-white" style="text-transform: none; line-height: 16px">
                        Tukarkan poin anda dengan Hadiah Menarik berikut.
                    </div>
                </div>
                <div class="infinite-menu p-2 pt-0 pl-0 ml-2 mt-1">
                    <?php while($data_rewards = $rewards->fetch_assoc()): ?>
                    <a href="<?= base_url('premium/tukar-poin') ?>" class="card reward-poin bg-transparent no-border m-0" style="color: #FFF !important">
                        <div class="card-body p-0" style="max-width: 100px">
                            <div>
                                <img src="<?= assets('images/rewards-icon/'.$data_rewards['photo']); ?>" alt="Rewards Icon" style="min-height: 70px; max-height: 70px; max-width: 100px; width: 100px; border-radius: 6px">
                            </div>
                            <div style="padding-top: 4px">
                                <div style="font-size: 14px; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= $data_rewards['name']; ?></div>
                                <div style="background: var(--color-theme-secondary); border-radius: 30px; margin-top: 4px; padding: 0px 7px; width: max-content; font-size: 12px;"><?= currency($data_rewards['point']); ?> Poin</div>
                            </div>
                        </div>
                    </a>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="section full bg-white mt-1">
        <div class="d-flex justify-content-between align-items-center pr-2">
            <div class="section-title">Info & Promo Spesial</div>
            <a href="<?= base_url('page/info.php') ?>" class="text-primary" style="font-weight: 600;">Lihat Semua</a>
        </div>
        <?php 
        $slider = $call->query("SELECT * FROM news_promo ORDER BY id ASC LIMIT 5");
        if($slider->num_rows !== 0):
        ?>
            <div class="carousel-single owl-carousel owl-theme">
                <?php while($slide = $slider->fetch_assoc()): ?>
                <div class="item">
                    <img src="<?= assets('images/news/'.$slide['banner']) ?>" alt="RGS News Banner" class="imaged w-100">
                </div>
                <?php endwhile; ?>
            </div>

        <?php endif; ?>
        </div>
        
        <div class="section full mb-2 bg-white mt-1">
        <div class="section-title">Fitur <?= $_CONFIG['title'] ?></div>
        <?php 
        $slider = $call->query("SELECT * FROM slider WHERE status = '1' AND type = 'Vertical' ORDER BY id ASC LIMIT 10");
        if($slider->num_rows !== 0):
        ?>
            <div class="carousel-multiple owl-carousel owl-theme">
                <?php while($slide = $slider->fetch_assoc()): ?>
                <div class="item">
                    <img src="<?= assets('images/slider/'.$slide['img']) ?>" alt="RGS News Banner" class="imaged w-100">
                </div>
                <?php endwhile; ?>
            </div>

        <?php endif; ?>
        </div>

        <div class="section full rgs-info bg-white" style="padding-bottom: 80px; margin-top: 29px">
            <div class="section-title">Informasi Terbaru</div>
            <?php
            $search = $call->query("SELECT * FROM information ORDER BY id DESC LIMIT 5");
            if($search->num_rows == false) {
                print '<div class="alert alert-primary text-left fade show mt-2 mb-2 mr-2 ml-2" role="alert">Belum Ada Informasi Terbaru</div>';
            } else {
            while($row = $search->fetch_assoc()) {
            ?>
            <div class="card">
                <div class="card-body">
                    <ion-icon name="megaphone-outline" class="text-warning"></ion-icon>
                    <span class="title"><?= $row['title'] ?></span>
                    <span class="date"><?= format_date('en',$row['date']) ?></span>
                    <span class="content"><?= nl2br(substr($row['content'],0,+100).'.') ?> <a href="<?= base_url('page/news-detail/'.$row['id']) ?>">Selengkapnya.</a> </span>
                </div>
            </div>
            <? } ?>

            <div class="text-center">
                <a href="<?= base_url('page/info') ?>" class="btn btn-outline-primary">Lihat Semua Informasi</a>
            </div>
            <? } ?>

        </div>

    </div>
    <div class="modal fade action-sheet inset" id="komisiModal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Total Komisi</h5>
                </div>
                <div class="modal-body">
                    <div style="padding: 1rem; text-align: center;">
                        <div class="alert alert-outline-primary" role="alert">
                            <div style="font-weight: 500; padding-bottom: 6px;">Komisi Anda</div>
                            <div style="font-size: 18px; font-weight: 600;">Rp <?= currency($data_user['komisi']) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <script>
        $(document).ready(function() {
            $('.urgent-alert').addClass('show');
        });
    </script>
<?php } } require _DIR_('library/footer/user') ?>