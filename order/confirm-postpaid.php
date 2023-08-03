<?php
require '../RGShenn.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['code']) ? filter($_GET['code']) : '';
$get_data = isset($_GET['data']) ? filter($_GET['data']) : '';

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if(!$get_code || !$get_data) exit('No direct script access allowed!');
    if($call->query("SELECT * FROM srv WHERE code = '$get_code' AND type = 'pascabayar' AND status = 'available'")->num_rows == false) exit('Layanan Tidak Ditemukan.');
    $row = $call->query("SELECT * FROM srv WHERE code = '$get_code' AND status = 'available'")->fetch_assoc();
    //146802199352
    $WebID = random_number(8);
    $TrxID = random(10);
    if($row['provider'] == 'DIGI') $try = $DIGI->CheckBill($get_code,$get_data,$TrxID);
    else $try = ['result' => false,'message' => 'Invalid Data.'];
    
    $errMSG = (stristr(strtolower($try['message']),'saldo') || stristr(strtolower($try['message']),'balance')) ? 'System Error.' : $try['message'];
    if($try['result'] == false) exit('<div class="alert alert-danger text-left fade show mt-2 mr-1 ml-1" role="alert">'.$errMSG.'</div>');
    
    if ($data_user['level'] == 'Basic') {
        $admin = conf('trxadmin', 3);
    } else {
        $admin = conf('trxadmin', 4);
    }
    $price = $try['data']['price'] + $admin;
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
                                                        <footer><?= $row['name'] ?></footer>
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
                                                <div class="trans-id">
                                                    <div class="text-muted">Nomor</div>
                                                    <div class="rgs-text-rincian"><?= $try['data']['customer_no'] ?></div>
                                                </div>
                                                <div class="trans-id">
                                                    <div class="text-muted">Nama</div>
                                                    <div class="rgs-text-rincian"><?= $try['data']['customer_name'] ?></div>
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
                                                    <div class="text-muted">Tagihan</div>
                                                    <div class="rgs-text-rincian"><?= 'Rp '.currency($try['data']['price']) ?></div>
                                                </div>
                                                <div class="trans-id">
                                                    <div class="text-muted">Biaya Admin</div>
                                                    <div class="text-warning"><?= 'Rp '.currency($admin) ?></div>
                                                </div>
                                                <hr>
                                                <div class="trans-id">
                                                    <div><b>Total Pembayaran</b></div>
                                                    <div><b><?= 'Rp '.currency($price) ?></b></div>
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
                                        <input type="hidden" id="web_token1" name="web_token1" value="<?= base64_encode($get_code) ?>">
                                        <input type="hidden" id="web_token2" name="web_token2" value="<?= base64_encode($get_data) ?>">
                                        <div class="row mt-2">
                                        <div class="col-11">
                                            <input type="password" class="form-control" maxlength="6" name="pin" pattern="[0-9]*" inputmode="numeric" placeholder="Silahkan masukkan PIN untuk melanjutkan transaksi">
                                        </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block mt-1 mb-1" name="buypostpaid" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Bayar Sekarang</button>
                                    </form>
                                </div>
                            </div>
                        </div>
<?
} else {
    exit('No direct script access allowed!');
}