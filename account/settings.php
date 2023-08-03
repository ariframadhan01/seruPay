<?php 
require '../RGShenn.php';
require _DIR_('library/session/user');

$_GET['q'] = (isset($_GET['q'])) ? $_GET['q'] : '';
if($_GET['q'] === 'profil') {
    $page = 'Ubah Profil';
} else if($_GET['q'] === 'pin') {
    $page = 'Ganti PIN';
} else {
    $page = 'Pengaturan Akun';
}

if(isset($_POST['updateProfil'])) {
    $post_pin =  filter($_POST['pin']);
    $post_phone =  filter($_POST['phone']);
    $post_name = (!$_POST['name']) ? $data_user['name'] : filter($_POST['name']);
    $post_email = (!$_POST['email']) ? $data_user['email'] : filter($_POST['email']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System Error, please try again later.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
    } else if(!$post_pin) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Masukkan Konfirmasi Pin Keamanan Telebih Dahulu!.'];
    } else if(!$post_name || !$post_email || !$post_phone) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masih Ada Formulir Kosong.'];
    } else {
        if(check_bcrypt($post_pin,$data_user['pin']) == true) {
            $call->query("UPDATE users SET name = '$post_name', email = '$post_email', phone = '$post_phone' WHERE username = '$sess_username'");
            $_SESSION['result'] = ['type' => true,'message' => 'Nama Atau Email Berhasil Diubah.'];
            redirect(0, base_url('account/settings?q=profil'));
            unset($_SESSION['csrf']);
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Pin Keamanan Tidak Valid.'];
        }
    }
} if(isset($_POST['updatePIN'])) {
    $post_pin1 = filter($_POST['pin']);
    $post_pin2 = filter($_POST['newpin']);
    $post_pin3 = filter($_POST['cnewpin']);

    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System Error, please try again later.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
    } else if(!$post_pin1 || !$post_pin2 || !$post_pin3) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masih Ada Formulir Kosong.'];
    } else if(check_bcrypt($post_pin1,$data_user['pin']) == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'PIN Keamanan Lama Anda Salah.'];
    } else if(is_numeric($post_pin2) == FALSE || is_numeric($post_pin3) == FALSE) {
        $_SESSION['result'] = ['type' => false,'message' => 'Pin Keamanan Hanya Boleh Diisi Angka'];
    } else if(strlen($post_pin2) < 6 || strlen($post_pin3) < 6) {
        $_SESSION['result'] = ['type' => false,'message' => 'Pin Keamanan Tidak Boleh Kurang Dari 6'];
    } else if(strlen($post_pin2) > 6 || strlen($post_pin3) > 6) {
        $_SESSION['result'] = ['type' => false,'message' => 'Pin Keamanan Tidak Boleh Lebih Dari 6'];
    } else if($post_pin2 <> $post_pin3) {
        $_SESSION['result'] = ['type' => false,'message' => 'PIN Keamanan Baru Tidak Sesuai.'];
    } else {
        $in = $call->query("UPDATE users SET pin = '".bcrypt($post_pin2)."' WHERE username = '$sess_username'");
        if($in == true) {
            $_SESSION['result'] = ['type' => true,'message' => 'PIN Keamanan Anda Berhasil Diubah.'];
            unset($_SESSION['csrf']);
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
}

require _DIR_('library/header/user');
?>

<?php if($_GET['q'] === 'profil'): ?>
    <!-- App Capsule -->
    <div id="appCapsule">
        <form method="POST">
            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
            <div class="section rgs-bg-texture profile">
                <div class="profile-head mb-2">
                    <div class="avatar mr-0">
                        <img src="<?= assets('images/user/11.png') ?>" alt="avatar" class="imaged w64 rounded">
                    </div>
                    <div class="in mt-1">
                        <h5 class="subtext text-light"><?= $data_user['phone'] ?></h5>
                    </div>
                </div>
            </div>
            <div class="section pt-2">
                
                <? require _DIR_('library/session/result-mobile') ?>
                
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label">Nama</label>
                        <input type="text" class="form-control" value="<?= $data_user['name'] ?>" name="name">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>

                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label">E-mail</label>
                        <input type="email" class="form-control" value="<?= $data_user['email'] ?>" name="email">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label">Nomor HP</label>
                        <input type="number" class="form-control" value="<?= $data_user['phone'] ?>" name="phone">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>

                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label">Konfirmasi Pin Keamanan</label>
                        <input type="password" class="form-control" placeholder="Masukkan PIN Keamanan Anda" name="pin" pattern="[0-9]*" inputmode="numeric">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>

                <div class="mt-2 form-bottom-fixed">
                    <button class="btn btn-primary btn-block" type="submit" name="updateProfil">Submit</button>
                </div>
            </div>
        </form>
    </div>
<?php elseif($_GET['q'] === 'pin'): ?>
    <div id="appCapsule">
        <div class="section full text-center bg-white pt-5 pb-3">
            <img src="<?= assets('mobile/img/svg/security.svg'); ?>" alt="Security" class="imaged w200 rounded">
        </div>
        <div class="section bg-white pt-2">
            
            <? require _DIR_('library/session/result-mobile') ?>
            
            <form method="POST">
            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label">PIN Sekarang</label>
                        <input type="password" class="form-control" placeholder="Masukkan PIN Sekarang" name="pin" pattern="[0-9]*" inputmode="numeric">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label">PIN Baru</label>
                        <input type="password" class="form-control" placeholder="Masukkan PIN Baru" name="newpin" pattern="[0-9]*" inputmode="numeric">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label">Konfirmasi PIN Baru</label>
                        <input type="password" class="form-control" placeholder="Konfirmasi PIN Baru" name="cnewpin" pattern="[0-9]*" inputmode="numeric">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="mt-2 form-bottom-fixed">
                    <button class="btn btn-primary btn-block" type="submit" name="updatePIN">Submit</button>
                </div>
            </form>
        </div>
    </div>
<?php else: ?>
    <div id="appCapsule">
        <div class="listview-title pb-0">Akun</div>
        <ul class="listview image-listview">
            <li>
                <a href="<?= base_url('account/settings.php?q=profil'); ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="person-circle-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Ubah Profil</div>
                    </div>
                </a>
            </li>
        </ul>
        <div class="listview-title pb-0">Keamanan</div>
        <ul class="listview image-listview">
            <li>
                <a href="<?= base_url('account/settings.php?q=pin'); ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="key-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Ganti PIN</div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <!-- * App Capsule -->
<?php endif; ?>
<?php require _DIR_('library/footer/user') ?>