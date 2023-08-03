<?php
require '../RGShenn.php';
require _DIR_('library/session/premium');

$_POSTNominal = isset($_POST['nominal']) ? filter($_POST['nominal']) : '';
$_POSTUser = isset($_POST['user']) ? filter($_POST['user']) : '';

if(!$_POSTNominal || !$_POSTUser) {
    $_SESSION['result'] = ['type' => false, 'message' => 'Masukkan Nominal Atau Nomor Tujuan Terlebih Dahulu!.'];
    redirect(0, base_url('deposit/'));
} else {
    
    if(!$_POSTNominal || !$_POSTUser) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Masukkan Nominal Atau Nomor Tujuan Terlebih Dahulu!.'];
        redirect(0, base_url('deposit/transfer'));
    } else if($_CONFIG['mt']['web'] == 'true') {
        $_SESSION['result'] = ['type' => false,'message' => 'Aplikasi Sedang Dalam Perbaikan.'];
        redirect(0, base_url('deposit/transfer'));
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
        redirect(0, base_url('deposit/transfer'));
    } else if(!in_array($data_user['level'], ['Premium','Admin'])) {
        $_SESSION['result'] = ['type' => false,'message' => 'Anda Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
        redirect(0, base_url('deposit/transfer'));
    } else if($_POSTNominal < 5000) {
        $_SESSION['result'] = ['type' => false,'message' => 'Minimal Kirim Saldo Adalah Rp '.currency(5000).'.'];
        redirect(0, base_url('deposit/transfer'));
    } else if($_POSTUser == $data_user['phone']) {
        $_SESSION['result'] = ['type' => false,'message' => 'Anda Tidak Dapat Kirim Saldo Ke Akun Anda Sendiri.'];
        redirect(0, base_url('deposit/transfer'));
    } else if($call->query("SELECT * FROM users WHERE phone = '$_POSTUser'")->num_rows == 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'Nomor HP Tujuan Tidak Terdaftar.'];
        redirect(0, base_url('deposit/transfer'));
    } else if($data_user['balance'] < $_POSTNominal) {
        $_SESSION['result'] = ['type' => false,'message' => 'Saldo Anda Tidak Mencukupi Untuk Kirim Saldo.'];
        redirect(0, base_url('deposit/transfer'));
    } 
    
    if(isset($_POST['transfer'])) {
        $post_ip = client_ip();
        $post_rid = strtoupper(random(9));
        $post_nomor = filter($_POST['user']);
        $searcUser = $call->query("SELECT * FROM users WHERE phone = '$post_nomor'")->fetch_assoc();
        $post_user = $searcUser['username'];
        $post_amnt = filter($_POST['nominal']);
        
        if($result_csrf == false) {
            $_SESSION['result'] = ['type' => false,'message' => 'System Error, please try again later.'];
            redirect(0, base_url('deposit/transfer'));
        } else if($_CONFIG['mt']['web'] == 'true') {
            $_SESSION['result'] = ['type' => false,'message' => 'Aplikasi Sedang Dalam Perbaikan.'];
            redirect(0, base_url('deposit/transfer'));
        } else if($sess_username == 'demo') {
            $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
            redirect(0, base_url('deposit/transfer'));
        } else if(!in_array($data_user['level'],['Premium','Admin'])) {
            $_SESSION['result'] = ['type' => false,'message' => 'Anda Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
            redirect(0, base_url('deposit/transfer'));
        } else if(!$post_nomor || !$post_amnt) {
            $_SESSION['result'] = ['type' => false,'message' => 'System Error Silahkan Hubungi Admin (002).'];
            redirect(0, base_url('deposit/transfer'));
        } else if($post_nomor == $data_user['phone']) {
            $_SESSION['result'] = ['type' => false,'message' => 'Anda Tidak Dapat Kirim Saldo Ke Akun Anda Sendiri.'];
            redirect(0, base_url('deposit/transfer'));
        } else if($call->query("SELECT * FROM users WHERE phone = '$post_nomor'")->num_rows == 0) {
            $_SESSION['result'] = ['type' => false,'message' => 'Nomor HP Tujuan Tidak Terdaftar.'];
            redirect(0, base_url('deposit/transfer'));
        } else if($post_amnt < 5000) {
            $_SESSION['result'] = ['type' => false,'message' => 'Minimal Kirim Saldo Rp '.currency(5000).'.'];
            redirect(0, base_url('deposit/transfer'));
        } else if($data_user['balance'] < $post_amnt) {
            $_SESSION['result'] = ['type' => false,'message' => 'Saldo Anda Tidak Mencukupi Untuk Kirim Saldo.'];
            redirect(0, base_url('deposit/transfer'));
        } else {
            $post_note_snd = "Transfer Ke {$searcUser['name']}";
            $post_note_rcv = "Transfer Dari {$data_user['name']}";
            $in = $call->query("INSERT INTO deposit VALUES ('', '$post_rid', '$post_user', 'transfer', '-', '$sess_username', '$post_amnt', '$post_amnt', 'paid', '$datetime', '$datetime')");
            if($in == true) {
                $call->query("UPDATE users SET balance = balance-$post_amnt WHERE username = '$sess_username'");
                $call->query("INSERT INTO mutation VALUES ('','$sess_username','-','$post_amnt','$post_note_snd', '$date', '$time', 'Deposit')");
                
                $call->query("UPDATE users SET balance = balance+$post_amnt WHERE username = '$post_user'");
                $call->query("INSERT INTO logs VALUES ('','$post_user','transfer','$post_ip','$datetime')");
                $call->query("INSERT INTO mutation VALUES ('','$post_user','+','$post_amnt','$post_note_rcv', '$date', '$time', 'Deposit')");
                
                $WATL->sendMessage($data_user['phone'], 'Hallo '.$data_user['name'].', '.$post_note_snd.' Sebesar Rp '.currency($post_amnt).' Berhasil!');
                $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '$sess_username'")->fetch_assoc()['token'];
                $notification = [
                    'title' => 'Transfer Berhasil',
                    'text' => 'Terima Kasih, '.$post_note_snd.' Sebesar Rp '.currency($post_amnt).' Berhasil!',
                    'click_action' =>  'Open_URI',
                ];
                
                $data = [
                    'picture' => '',
                    'uri' =>  base_url('page/riwayat'),
                ];
                $FCM->sendNotif($fcm_token, $notification, $data);
                
                $WATL->sendMessage($post_nomor, 'Hallo '.$searcUser['name'].' Anda Mendapatkan Saldo Sebesar Rp '.currency($post_amnt).' Dari '.$data_user['name']);
                $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '$post_user'")->fetch_assoc()['token'];
                $notification = [
                    'title' => 'Yeayy!!',
                    'text' => 'Anda Mendapatkan Saldo Sebesar Rp '.currency($post_amnt).' Dari '.$data_user['name'],
                    'click_action' =>  'Open_URI',
                ];
                
                $data = [
                    'picture' => '',
                    'uri' =>  base_url('page/riwayat'),
                ];
                $FCM->sendNotif($fcm_token, $notification, $data);
    
                $_SESSION['success'] = ['type' => true,'message' => "Anda Berhasil Mengirim Saldo Rp ".currency($post_amnt)." ke {$searcUser['name']}."];
                unset($_SESSION['csrf']);
            } else {
                $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
                redirect(0, base_url('deposit/transfer'));
            }
        }
    }

$page = isset($_SESSION['success']) ? 'Pembayaran Berhasil' : 'Konfirmasi Transfer';
require _DIR_('library/header/user');
?>
<?php if(isset($_SESSION['success'])) :  ?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-pending-deposit mt-5">
        <div class="section">

            <div class="text-center">
                <button type="button" class="btn btn-icon btn-lg">
                    <ion-icon name="checkmark-done-outline"></ion-icon>
                </button>
                <h3 class="text-light">Transfer Berhasil</h3>
                <small><?= $_SESSION['success']['message'] ?></small>
                <hr class="bg-light">
                <small>TOTAL TRANSFER</small>
                <h3 class="text-light">Rp <?= currency($post_amnt) ?></h3>
            </div>

            <div class="form-button-group bg-primary text-center">
                <a href="<?= base_url() ?>" class="btn rounded shadowed btn-block btn-lg">Selesai</a>
            </div>

        </div>
    </div>
    <!-- * App Capsule -->

<?php unset($_SESSION['success']); else: ?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-konfirmasi">
        <div class="section d-invoice">
            <div class="card">
                <div class="card-body">
                    <ul class="listview image-listview no-line no-space flush mb-1">
                        <li>
                            <div class="item">
                                <img src="<?= assets('mobile/img/home/transfer-saldo-blue.svg') ?>" width="23px" class="mr-2" id="RGSLogo">
                                <div class="in">
                                    <div>
                                        <span>Transfer Saldo</span>
                                        <footer>Antar Member</footer>
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
                                    <div class="text-muted">Nomor HP</div>
                                    <div class="rgs-text-rincian"><?= $_POSTUser ?></div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">Nama</div>
                                    <div class="rgs-text-rincian"><?= $call->query("SELECT * FROM users WHERE phone = '$_POSTUser'")->fetch_assoc()['name'] ?></div>
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
                                    <div class="text-muted">Nominal Transfer</div>
                                    <div class="rgs-text-rincian">Rp <?= currency($_POSTNominal) ?></div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">Biaya Transaksi</div>
                                    <div class="rgs-text-rincian text-warning">GRATIS</div>
                                </div>
                                <hr>
                                <div class="trans-id">
                                    <div><b>Total Pembayaran</b></div>
                                    <div><b>Rp <?= currency($_POSTNominal) ?></b></div>
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
                        <input type="hidden" name="user" value="<?= $_POSTUser ?>">
                        <input type="hidden" name="nominal" value="<?= $_POSTNominal ?>">
                        <button type="submit" class="btn btn-primary btn-block mt-1 mb-1" name="transfer" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Transfer Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
<? endif; ?>    
<?php require _DIR_('library/footer/user'); } ?>