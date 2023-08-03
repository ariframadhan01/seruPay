<?php
require '../RGShenn.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['code']) ? filter($_GET['code']) : '';
$get_data = isset($_GET['data']) ? filter($_GET['data']) : '';

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if(!$get_code || !$get_data) exit('No direct script access allowed!');
    if($call->query("SELECT * FROM srv WHERE code = '$get_code' AND status = 'available'")->num_rows == false) exit('Layanan Tidak Ditemukan.');
    $row = $call->query("SELECT * FROM srv WHERE code = '$get_code' AND status = 'available'")->fetch_assoc();
    $search_cat = $call->query("SELECT * FROM category WHERE code = '".$row['brand']."'");
    $data_cat = $search_cat->fetch_assoc();
    $operator = strtolower($row['brand']);
    $tipe = $data_cat['type'];
    $label = $tipe == 'games' ? 'ID Game' : 'Tujuan Pengisian';
    $MustHaveZone = ['mobile legend', 'lifeafter credits', 'ragnarok m: eternal love', 'tom and jerry : chase', 'knights of valour', 'scroll of onmyoji'];
    $layanan = $row['name'];
    $get_data = str_replace('SHENN','',$get_data);
    $get_data = in_array($operator, $MustHaveZone) ? str_replace('=',' | ',$get_data) : str_replace('=', '', $get_data);
    if($row['brand'] == 'GARENA' && $call->query("SELECT * FROM kodeVoucher WHERE kategori = 'GARENA' AND idLayanan = '$get_code' AND status = 'Tersedia'")->num_rows == 1) {
        $server = 'X';
    } else {
        $server = $row['provider'];
    }
    $price = price($data_user['level'],$row['price'],$server);
    
if($row['provider'] == 'X') :
    $actionPOST = 'buymanual';
    else :
        $actionPOST = 'buyprepaid';
        endif;
?>
                        <div class="section d-invoice">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="listview image-listview no-line no-space flush mb-1">
                                        <li>
                                            <div class="item">
                                                <img src="<?= assets('mobile/img/home/'.$row['type'].'.svg') ?>" width="44px" class="image" id="RGSLogo">
                                                <div class="in">
                                                    <div>
                                                        <span><?= strtoupper(str_replace('-', ' ', $row['type'])) ?></span>
                                                        <footer><?= $layanan ?></footer>
                                                        <footer class="text-warning">+2 Point</footer>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    
                                    <div class="more-info accordion pt-1" id="expandPembayaran">
                                        <div class="accordion-header">
                                            <button class="btn p-0 text-white" type="button" data-toggle="collapse" data-target="#show" aria-expanded="false">
                                                INFORMASI PELANGGAN
                                            </button>
                                        </div>
                                        <div id="show" class="accordion-body collapse show" data-parent="#expandPembayaran">
                                            <div class="accordion-content">
                                                <? if(in_array(strtolower($row['brand']), $MustHaveZone)) : ?>
                                                <div class="trans-id">
                                                    <div class="text-muted"><?= $label ?></div>
                                                    <div class="rgs-text-rincian"><?= explode(' | ', filter($get_data))['0'] ?></div>
                                                </div>
                                                <div class="trans-id">
                                                    <div class="text-muted">Server</div>
                                                    <div class="rgs-text-rincian"><?= explode(' | ', filter($get_data))['1'] ?></div>
                                                </div>
                                                <? else: ?>
                                                <div class="trans-id">
                                                    <div class="text-muted"><?= $label ?></div>
                                                    <div class="rgs-text-rincian"><?= $get_data ?></div>
                                                </div>
                                                <? endif ?>
                                                <div class="trans-id">
                                                    <div class="text-muted">Brand</div>
                                                    <div class="rgs-text-rincian"><?= $row['brand'] ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="more-info accordion pt-1" id="expandinfo">
                                        <div class="accordion-header">
                                            <button class="btn p-0 text-white" type="button" data-toggle="collapse" data-target="#show1" aria-expanded="false">
                                                INFORMASI TAGIHAN
                                            </button>
                                        </div>
                                        <div id="show1" class="accordion-body collapse show" data-parent="#expandinfo">
                                            <div class="accordion-content">
                                                <div class="trans-id">
                                                    <div class="text-muted">Harga</div>
                                                    <div class="rgs-text-rincian"><?= 'Rp '.currency($price) ?></div>
                                                </div>
                                                <div class="trans-id">
                                                    <div class="text-muted">Biaya Transaksi</div>
                                                    <? if($data_user['level'] == 'Basic') : ?>
                                                    <div class="text-warning">Rp <?= currency(conf('trxadmin', 3)) ?></div>
                                                    <? else: ?>
                                                    <div class="text-warning">Rp <?= currency(conf('trxadmin', 4)) ?></div>
                                                    <? endif ?>
                                                </div>
                                                <hr>
                                                <div class="trans-id">
                                                    <div><b>Total Pembayaran</b></div>
                                                    <? if($data_user['level'] == 'Basic') : ?>
                                                    <div><b><?= 'Rp '.currency($price+conf('trxadmin', 3)) ?></b></div>
                                                    <? else: ?>
                                                    <div><b><?= 'Rp '.currency($price+conf('trxadmin', 4)) ?></b></div>
                                                    <? endif ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-1">
                                            <ion-icon name="shield-checkmark-outline"></ion-icon>
                                        </div>
                                        <div class="col-11">
                                            Transaksi Mudah, Cepat & Aman. Dengan Melanjutkan Proses Ini, Kamu Sudah Menyetujui <a href="#">Syarat Dan Ketentuan</a>
                                        </div>
                                    </div>
                                    <form method="POST">
                                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                        <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($get_code) ?>">
                                        <? if(in_array(strtolower($row['brand']), $MustHaveZone)) : ?>
                                        <input type="hidden" id="data" name="data" value="<?= explode(' | ', filter($get_data))['0'] ?>">
                                        <input type="hidden" id="data2" name="data2" value="<?= explode(' | ', filter($get_data))['1'] ?>">
                                        <? else: ?>
                                        <input type="hidden" id="data" name="data" value="<?= $get_data ?>">
                                        <? endif ?>
                                        <div class="row mt-2">
                                        <div class="col-11">
                                            <input type="password" class="form-control" maxlength="6" name="pin" pattern="[0-9]*" inputmode="numeric" placeholder="Silahkan masukkan PIN untuk melanjutkan transaksi">
                                        </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block mt-1 mb-1" name="<?= $actionPOST ?>" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Bayar Sekarang</button>
                                    </form>
                                </div>
                            </div>
                        </div>
<?
} else {
    exit('No direct script access allowed!');
}