<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Rincian Transaksi';

if(isset($_GET['code'])) {
    $post_kode = filter($_GET['code']);
    $search = $call->query("SELECT * FROM trx WHERE wid = '$post_kode' AND user = '$sess_username'");
    if($search->num_rows == 0) redirect(1,base_url('page/riwayat'));
    $rows = $search->fetch_assoc();
    if($data_user['level'] == 'Basic' AND $rows['provider'] == 'X') {
        $price = $rows['price']+conf('trxmanual', 3);
    } else if($data_user['level'] == 'Premium' AND $rows['provider'] == 'X') {
        $price = $rows['price']+conf('trxmanual', 4);  
    } else if($data_user['level'] == 'Basic' AND $rows['provider'] == 'DIGI') {
        $price = $rows['price'];
    } else if($data_user['level'] == 'Basic' AND $rows['provider'] == 'DIGI') {
        $price = $rows['price'];
    } else if($data_user['level'] == 'Admin' AND $rows['provider'] == 'DIGI') {
        $price = $rows['price'];
    } else if($data_user['level'] == 'Admin' AND $rows['provider'] == 'X') {
        $price = $rows['price']+conf('trxmanual', 4); 
    }
   
    
    if($rows['status'] == 'error') :
        $label = 'danger';
        $class= '';
        $icon = 'close-circle-outline';
        $status = 'Transaksi Gagal';
    elseif($rows['status'] == 'success'):
        $label = 'success';
        $class= '';
        $icon = 'checkmark-done-outline';
        $status = 'Transaksi Berhasil';
    else:
        $label = 'warning';
        $class= 'rgs-r90';
        $icon = 'hourglass-outline';
        $status = 'Transaksi Sedang Di Proses';
    endif;
    
    if($rows['trxtype'] == 'shop') :
        $table = 'produk';
        $column = 'kode';
        $value = 'kategori';
        $type = 'SHOP';
    elseif($rows['trxtype'] == 'manual'):
        $table = 'trx';
        $column = 'code';
        $value = 'name';
        $type = 'Manual Transaksi';
    else:
        $table = 'srv';
        $column = 'code';
        $value = 'brand';
        $type = str_replace('-', ' ', strtoupper($call->query("SELECT * FROM srv WHERE code = '".$rows['code']."'")->fetch_assoc()['type']));
    endif;
    
    $stat = $rows['status'] == 'error' && $rows['refund'] == '1' ? 'Refund' : $rows['status'];
} else {
    redirect(0, base_url('page/riwayat'));
}

require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-konfirmasi">
        <div class="section rgs-rincian-deposit">

            <div class="text-center">
                <button type="button" class="btn btn-icon btn-lg">
                    <ion-icon name="<?= $icon ?>" class="<?= $class ?>"></ion-icon>
                </button>
                <h4 class="text-white"><?= $status ?></h4>
            </div>

            <div class="card mt-2">
                <div class="card-body">
                    <ul class="listview image-listview no-line no-space flush mb-1">
                        <li>
                            <div class="item">
                                <? if($rows['trxtype'] == 'shop') : ?>
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="storefront-outline"></ion-icon>
                                    </div>
                                <? elseif($rows['trxtype'] == 'manual'): ?>
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="storefront-outline"></ion-icon>
                                    </div>
                                <? else: ?>
                                    <img src="<?= assets('mobile/img/home/'.$call->query("SELECT * FROM srv WHERE code = '".$rows['code']."'")->fetch_assoc()['type'].'.svg') ?>" width="44px" class="image" id="RGSLogo">
                                <? endif ?>
                                <div class="in">
                                    <div>
                                        <span><?= $type ?></span>
                                        <footer><?= $rows['name'] ?></footer>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    
                    <div class="more-info accordion pt-1" id="expandPembayaran">
                        <div class="accordion-header">
                            <button class="btn p-0 text-white" type="button" data-toggle="collapse" data-target="#show" aria-expanded="false">
                                INFORMASI TRANSAKSI
                            </button>
                        </div>
                        <div id="show" class="accordion-body collapse show" data-parent="#expandPembayaran">
                            <div class="accordion-content">
                                <? if($rows['trxtype'] !== 'shop') : ?>
                                <div class="trans-id">
                                    <div class="text-muted">Tujuan Pengisian</div>
                                    <div class="rgs-text-rincian"><?= $rows['data'] ?></div>
                                </div>
                                <? endif ?>
                                <div class="trans-id">
                                    <div class="text-muted">Kategori</div>
                                    <div class="rgs-text-rincian"><?= strtoupper($call->query("SELECT * FROM $table WHERE $column = '".$rows['code']."'")->fetch_assoc()[$value]) ?></div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">ID Transaksi</div>
                                    <div class="rgs-text-rincian"><?= $post_kode ?></div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">Waktu Transaksi</div>
                                    <div class="rgs-text-rincian"><?= format_date('id', $rows['date_cr']) ?></div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">Poin</div>
                                    <div class="rgs-text-rincian">+5</div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">Status Transaksi</div>
                                    <div class="rgs-text-rincian text-<?= $label ?>"><?= ucwords($stat) ?></div>
                                </div>
                                <? if($rows['status'] <> 'processing') : ?>
                                <div class="text-muted mt-1">Keterangan</div>
                                <div class="rgs-rincian-keterangan">
                                    <div class="rgs-text-rincian"><?= nl2br($rows['note']) ?></div>
                                </div>
                                <? endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="more-info accordion pt-2" id="expandinfo">
                        <div class="accordion-header">
                            <button class="btn p-0 text-white" type="button" data-toggle="collapse" data-target="#show1" aria-expanded="false">
                                INFORMASI TAGIHAN
                            </button>
                        </div>
                        <div id="show1" class="accordion-body collapse show" data-parent="#expandinfo">
                            <div class="accordion-content">
                                <div class="trans-id">
                                    <div class="text-muted">Harga</div>
                                    <div class="rgs-text-rincian">Rp <?= currency($price) ?></div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">Biaya Transaksi</div>
                                    <? if($data_user['level'] == 'Basic' AND $rows['provider'] == 'X') : ?>
                                    <div class="rgs-text-rincian text-warning"><?= conf('trxadmin', 3) ?></div>
                                    <? elseif($data_user['level'] == 'Premium' AND $rows['provider'] == 'X'): ?>
                                    <div class="rgs-text-rincian text-warning">Rp <?= currency(conf('trxadmin', 4)) ?></div>
                                    <? elseif($data_user['level'] == 'Basic' AND $rows['provider'] == 'DIGI'): ?>
                                    <div class="rgs-text-rincian text-warning">Rp <?= currency(conf('trxadmin', 3)) ?></div>
                                    <? elseif($data_user['level'] == 'Premium' AND $rows['provider'] == 'DIGI'): ?>
                                    <div class="rgs-text-rincian text-warning">Rp <?= currency(conf('trxadmin', 4)) ?></div>
                                    <? elseif($data_user['level'] == 'Admin' AND $rows['provider'] == 'X'): ?>
                                    <div class="rgs-text-rincian text-warning">Rp <?= currency(conf('trxadmin', 4)) ?></div>
                                    <? elseif($data_user['level'] == 'Admin' AND $rows['provider'] == 'DIGI'): ?>
                                    <div class="rgs-text-rincian text-warning">Rp <?= currency(conf('trxadmin', 4)) ?></div>
                                    <? endif ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="trans-id rgs-bg-rincian text-dark mt-2">
                        <div>Total Pembayaran</div>
                        <div>Rp <?= currency($rows['price']) ?></div>
                    </div>
                    
                </div>
            </div>
            
            <p class="text-center mb-4">Jika ada masalah dalam transaksi ini, silahkan hubungi CS kami!</p>
            
            <div class="form-button-group rgs-detail-transfer bg-primary text-center">
                <div class="row">
                    <div class="col-6">
                        <a href="javascript:window.print()" class="text-white ">
                            <ion-icon name="print-outline"></ion-icon>
                            <span>Cetak Struk</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('page/contact') ?>" class="text-white">
                            <ion-icon name="headset-outline"></ion-icon>
                            <span>Hubungi CS</span>
                        </a>
                    </div>
                </div>
                <a href="<?= base_url('page/riwayat.php') ?>" class="btn rounded shadowed btn-block btn-lg mt-3 mb-2">Selesai</a>
            </div>

        </div>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>