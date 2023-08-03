<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Akun Saya';
$pengeluaran = $call->query("SELECT SUM(mutation.amount) AS total FROM mutation WHERE type = '-' AND user = '$sess_username' AND kategori IN ('Transaksi', 'Deposit', 'Lainnya', 'Tarik Komisi')")->fetch_assoc()['total'];
$pemasukkan  = $call->query("SELECT SUM(mutation.amount) AS total FROM mutation WHERE type = '+' AND user = '$sess_username' AND kategori IN ('Transaksi', 'Deposit', 'Lainnya', 'Tarik Komisi')")->fetch_assoc()['total'];
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section rgs-bg-texture profile">
            <div class="profile-head">
                <div class="avatar mr-0">
                    <img src="<?= assets('images/user/11.png') ?>" alt="avatar" class="imaged w64 rounded">
                </div>
                <div class="in mt-1">
                    <h3 class="name text-light m-0 bold"><?= $data_user['name'] ?></h3>
                    <h5 class="subtext text-light"><?= explode(substr($data_user['phone'], '4', '4'), $data_user['phone'])['0'].'&bull;&bull;&bull;&bull;'.explode(substr($data_user['phone'], '4', '4'), $data_user['phone'])['1'] ?></h5>
                    <? if($data_user['level'] == 'Basic') : ?>
                    <a href="<?= base_url('account/upgrade.php') ?>" class="btn btn-warning btn-sm mt-1">
                        <ion-icon name="rocket-outline"></ion-icon>
                        Upgrade Ke Premium
                    </a>
                    <? endif; ?>
                </div>
            </div>
        </div>
        <ul class="listview image-listview">
            <li class="profile-menu">
                <div class="money-info">
                    <a href="#" class="item">
                        <div class="icon-box bg-success">
                            <ion-icon name="arrow-up-outline"></ion-icon>
                        </div>
                        <div class="in">
                            <div class="title">Pemasukan</div>
                            <div class="subtitle text-blue">Rp <?= currency($pemasukkan) ?></div>
                        </div>
                    </a>
                    <a href="#" class="item">
                        <div class="icon-box bg-warning">
                            <ion-icon name="arrow-down-outline"></ion-icon>
                        </div>
                        <div class="in">
                            <div class="title">Pengeluaran</div>
                            <div class="subtitle text-blue">Rp <?= currency($pengeluaran) ?></div>
                        </div>
                    </a>
                </div>
            </li>
            <li>
                <a href="<?= base_url('deposit/') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="cash-outline" class="text-blue"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Saldo</div>
                        <span class="text-blue">Rp <?= currency($data_user['balance']) ?></span>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?= base_url('premium/') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="ribbon-outline" class="text-success"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Level</div>
                        <span class="text-success"><?= $data_user['level'] ?></span>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?= base_url('referral/') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="people-outline" class="text-blue"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Referral</div>
                    </div>
                </a>
            </li>
        </ul>
        <div class="listview-title pb-0">Fiture</div>
        <ul class="listview image-listview">
            <li>
                <a href="<?= base_url('account/settings.php') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="cog-outline" class="text-danger"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Pengaturan Akun</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?= base_url('auth/logout.php') ?>" class="text-dark">
                    <div class="item">
                        <div class="icon-box bg-transparent">
                            <ion-icon name="log-out-outline" class="text-danger"></ion-icon>
                        </div>
                        <div class="in">
                            <div>Keluar</div>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
        <div class="listview-title pb-0">Lainnya</div>
        <ul class="listview image-listview">
            <li>
                <a href="<?= base_url('page/price-list.php') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="list-outline" class="text-blue"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Daftar Harga</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?= base_url('page/help-center.php') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="chatbubbles-outline" class="text-warning"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Pusat Bantuan</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?= base_url('page/about-us.php') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="rocket-outline" class="text-warning"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Tentang Kami</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?= base_url('page/terms-conditions.php') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="reader-outline" class="text-warning"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Syarat & Ketentuan</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?= base_url('page/privacy-policy.php') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="reader-outline" class="text-warning"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Kebijakan Privasi</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?= base_url('page/contact.php') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="chatbubbles-outline" class="text-warning"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Hubungi Kami</div>
                    </div>
                </a>
            </li>
            <? if( $data_user['level'] == 'Admin' ): ?>
            <li>
                <a href="<?= base_url('admin/') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="desktop-outline" class="text-success"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Halaman Admin</div>
                    </div>
                </a>
            </li>
            <? endif ?>
        </ul>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>