<?php
if(isset($_POST['login'])) {
    $postPhone = '0'.str_replace('-', '', filter($_POST['user']));
    $OTP = random(6);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false, 'message' => 'System Error, please try again later.'];
    } else if(!$postPhone) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Masukkan Nomor HP Terlebih Dahulu!', 'phone'];
    } else {
        if($call->query("SELECT * FROM users WHERE phone = '$postPhone'")->num_rows == 0) {
            $_SESSION['phoneError'] = ['type' => true, 'phone' => $postPhone];
        } else {
            $data_user = $call->query("SELECT * FROM users WHERE phone = '$postPhone'")->fetch_assoc();
            if($data_user['status'] == 'suspend') {
                $_SESSION['result'] = ['type' => false,'message' => 'Akun Ditangguhkan, Harap Hubungi Admin.'];
            } else if($data_user['status'] !== 'active' && $data_user['status'] !== 'locked') {
                $_SESSION['result'] = ['type' => false,'message' => 'Akun Belum Diverifikasi.'];
            } else if ($call->query("SELECT * FROM users_blacklist WHERE phone = '$postPhone'")->num_rows == 1) {
                $_SESSION['result'] = ['type' => false,'message' => 'Akun Telah Diblacklist.'];
            } else {
                $result_wa = $WATL->sendMessage($postPhone, "Hallo {$data_user['name']}, Kode OTP anda untuk login adalah $OTP, Terimakasih Telah Bergabung bersama {$_CONFIG['title']}");
                $result_mail = mailer($_MAILER,[
                    'dest' => $data_user['email'],
                    'name' => $data_user['name'],
                    'subject' => 'OTP Untuk '.$_CONFIG['title'].' Akun',
                    'message' => base64_encode(mailplate('otp',[
                        'name' => $data_user['name'],
                        'otp' => $OTP
                    ])),
                    'is_template' => 'yes'
                ]);
                
                file_put_contents('.notifier', json_encode($result_wa, JSON_PRETTY_PRINT));
                $result_notif = ($result_mail == false) ? $result_wa['result'] : $result_mail;
                if($result_mail == true || $result_wa['result'] == false) {
                    $_SESSION['login'] = ['otp' => $OTP, 'phone' => $postPhone];
                    $_SESSION['result'] = ['type' => true,'message' => 'Kode Verifikasi Telah Dikirim, Silahkan Cek Inbox/Folder Spam Email Anda'];
                } else {
                    $_SESSION['result'] = ['type' => false,'message' => 'Gagal Kirim Kode OTP.'];
                }
            }
        }
    }
} else if(isset($_POST['otpLogin'])) {
    $postOTP = filter($_POST['otpcode']);
    $dataPhone = $_SESSION['login']['phone'];
    
    $ip = client_ip();
    $cookie_time = time() + (86400 * 90);
	$ShennCookie = random(86);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false, 'message' => 'System Error, please try again later.'];
    } else if(!$postOTP || !$dataPhone) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Masukkan Kode OTP Telebih Dahulu!.'];
    } else if($postOTP <> $_SESSION['login']['otp']) {
       $_SESSION['result'] = ['type' => false, 'message' => 'Kode Otp Yang Anda Masukkan Salah, Harap Periksa Kembali.']; 
    } else {
	    $data_user = $call->query("SELECT * FROM users WHERE phone = '$dataPhone'")->fetch_assoc();
        $_SESSION['pin'] = ['data' => $data_user];
        unset($_SESSION['login']);
    } 
} else if(isset($_POST['verifPin'])) {
    $postPin = filter($_POST['pin']);
    $data_user = $_SESSION['pin']['data'];
    
    $ip = client_ip();
    $cookie_time = time() + (86400 * 90);
	$ShennCookie = random(86);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false, 'message' => 'System Error, please try again later.'];
    } else if(!$postPin || !$data_user) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Masukkan Pin Keamanan Telebih Dahulu!.'];
    } else {
        if(check_bcrypt($postPin, $data_user['pin']) == true) {
            setcookie('ssid', 'SHENN-A'.$data_user['id'].'AIY', $cookie_time, '/', $_SERVER['HTTP_HOST']);
            setcookie('token', $ShennCookie, $cookie_time, '/', $_SERVER['HTTP_HOST']);
            $call->query("INSERT INTO users_cookie VALUES ('$ShennCookie', '".$data_user['username']."', '$datetime')");
            if(isset($_COOKIE['FCM_TOKEN'])) {
                $userFcm = $_COOKIE['FCM_TOKEN'];
                if($call->query("SELECT * FROM users_token WHERE user = '".$data_user['username']."' AND token = '$userFcm'")->num_rows == TRUE) {
                    $call->query("UPDATE users_token SET date = '$datetime' WHERE user = '".$data_user['username']."'");
                } else {
                    $call->query("INSERT INTO users_token VALUES ('','".$data_user['username']."','$userFcm','$datetime')");
                }
            }
            $_SESSION['user'] = $data_user;
            
            $notification = [
                'title' => 'Selamat Datang',
                'body' => 'Hallo '.$data_user['name'].' Selamat Datang Kembali Di '.$_CONFIG['title'],
                'click_action' =>  'Open_URI'
            ];
            
            $data = [
                'picture' => '',
                'uri' =>  base_url(),
            ];
            $FCM->sendNotif(isset($_COOKIE['FCM_TOKEN']) ? $_COOKIE['FCM_TOKEN'] : '', $notification, $data);
            
            $call->query("INSERT INTO logs VALUES ('', '".$data_user['username']."', 'login', '$ip', '$datetime')");
            unset($_SESSION['pin']);
            $_SESSION['last_login_time'] = time();
            redirect(0, base_url());
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Pin Keamanan Tidak Valid.'];
        }
    } 
} else if(isset($_POST['reg'])) {
    $post_name = isset($_POST['name']) ? ucwords(strtolower(filter($_POST['name']))) : '';
    $post_email = isset($_POST['email']) ? filter($_POST['email']) : '';
    $post_phone = isset($_POST['phone']) ? filter($_POST['phone']) : '';
    $post_pin = isset($_POST['pin']) ? filter($_POST['pin']) : '';
    $post_cpin = isset($_POST['cpin']) ? filter($_POST['cpin']) : '';
    $post_referral = isset($_POST['reff']) ? filter($_POST['reff']) : '';
    $post_referral = !$post_referral ? 'RGS-SYSTEM' : filter($_POST['reff']);
    $post_AcceptMail = ['gmail.com','yahoo.com','outlook.com','icloud.com'];
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System Error, please try again later.'];
    } else if($_CONFIG['mt']['web'] == 'true') {
        $_SESSION['result'] = ['type' => false,'message' => 'Aplikasi Sedang Dalam Perbaikan.'];
    } else if(!$post_email || !$post_phone || !$post_name) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masih Ada Formulir Kosong.'];
    } else if(!in_array(explode('@',$post_email)[1],$post_AcceptMail)) {
        $_SESSION['result'] = ['type' => false,'message' => 'Email Tidak Didukung.'];
    } else if($call->query("SELECT * FROM users WHERE phone = '$post_phone'")->num_rows == true) {
        $_SESSION['result'] = ['type' => false,'message' => 'Nomor HP Sudah Terdaftar, Silahkan Coba Dengan Yang Lain.'];
    } else if($call->query("SELECT * FROM users WHERE email = '$post_email'")->num_rows == true) {
        $_SESSION['result'] = ['type' => false,'message' => 'Email Sudah Terdaftar, Silahkan Coba Dengan Yang Lain.'];
    } else if(is_numeric($post_pin) == FALSE || is_numeric($post_cpin) == FALSE) {
        $_SESSION['result'] = ['type' => false,'message' => 'Pin Keamanan Hanya Boleh Diisi Angka'];
    } else if(strlen($post_pin) < 6 || strlen($post_cpin) < 6) {
        $_SESSION['result'] = ['type' => false,'message' => 'Pin Keamanan Tidak Boleh Kurang Dari 6'];
    } else if(strlen($post_pin) > 6 || strlen($post_cpin) > 6) {
        $_SESSION['result'] = ['type' => false,'message' => 'Pin Keamanan Tidak Boleh Lebih Dari 6'];
    } else if($post_pin <> $post_cpin) {
        $_SESSION['result'] = ['type' => false,'message' => 'Konfirmasi Pin Keamanan Tidak Sesuai.'];
    } else if(strtolower($post_referral) !== 'rgs-system' && $call->query("SELECT * FROM users WHERE referral = '$post_referral'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Kode Referral Tidak Valid.'];
    } else {
        $OTP = random(6);;
        $post_invited = (strtolower($post_referral) == 'rgs-system') ? 'RGS-SYSTEM' : $call->query("SELECT * FROM users WHERE referral = '$post_referral'")->fetch_assoc()['username'];
        $post_invitid = (strtolower($post_referral) == 'rgs-system') ? 'RGS-SYSTEM' : $call->query("SELECT * FROM users WHERE referral = '$post_referral'")->fetch_assoc()['name'];
        
        $result_wa = $WATL->sendMessage($post_phone, "Hallo $post_name, Kode OTP anda untuk aktifasi Akun adalah $OTP, Terimakasih Telah Bergabung bersama {$_CONFIG['title']}");
        $result_mail = mailer($_MAILER, [
            'dest' => $post_email,
            'name' => $post_name,
            'subject' => 'OTP Untuk '.$_CONFIG['title'].' Akun',
            'message' => base64_encode(mailplate('otp',[
                'name' => $post_name,
                'otp' => $OTP
            ])),
            'is_template' => 'yes'
        ]);
        
        $username = 'RGS-'.strtoupper(random(7));
        if($call->query("SELECT * FROM users WHERE username = '$username'")->num_rows == true) {
            $username = 'RGS-'.strtoupper(random(8));
        } else {
            $username = $username;
        }
        
        file_put_contents('.notifier', json_encode($result_wa, JSON_PRETTY_PRINT));
        if($result_mail == true || $result_wa['result'] == false) {
            $_SESSION['register'] = ['otp' => $OTP, 'data' => [
                'user' => $username,
                'email' => $post_email,
                'phone' => $post_phone,
                'name' => $post_name,
                'pin' => $post_pin,
                'reff' => $post_invited,
                'referral' => strtoupper(random(6)),
                'joined' => $datetime,
                'invt' => $post_invitid
            ]];
            $_SESSION['result'] = ['type' => true,'message' => 'Kode Verifikasi Telah Dikirim, Silahkan Cek Inbox/Folder Spam Email Anda'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Gagal Kirim Kode Verifikasi.'];
        }
    }
} else if(isset($_POST['otpreg'])) {
    $post_otp = filter($_POST['otpcode']);
    $data = $_SESSION['register']['data'];
    $reff = $_SESSION['register']['data']['reff'];
    $kodeReff = $_SESSION['register']['data']['referral'];
    $post_name = ucwords(strtolower($data['name']));
    $post_phone = filter_phone('0', filter($data['phone']));
    
    $ip = client_ip();
    $cookie_time = time() + (86400 * 90);
	$ShennCookie = random(86);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System Error, please try again later.'];
    } else if(!$post_otp || !is_array($data)) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masih Ada Formulir Kosong.'];
    } else if($post_otp <> $_SESSION['register']['otp']){
       $_SESSION['result'] = ['type' => false,'message' => 'Kode Otp Yang Anda Masukkan Salah, Harap Periksa Kembali.']; 
    } else {
        $in = $call->query("INSERT INTO users VALUES ('','$post_name','".$data['email']."','$post_phone','".$data['user']."','0','0','0','Basic','$kodeReff','$reff','active','$datetime', '".bcrypt($data['pin'],10)."')");
        if($in == true){
            $call->query("INSERT INTO users_api VALUES ('".$data['user']."','".random(8)."','".random(64)."','','development')");
            $kepo = $call->query("SELECT * FROM users WHERE username = '".$data['user']."'")->fetch_assoc();
            setcookie('ssid', 'SHENN-A'.$kepo['id'].'AIY', $cookie_time, '/', $_SERVER['HTTP_HOST']);
            setcookie('token', $ShennCookie, $cookie_time, '/', $_SERVER['HTTP_HOST']);
            $call->query("INSERT INTO users_cookie VALUES ('$ShennCookie', '".$data['user']."', '$datetime')");
            $_SESSION['user'] = $kepo;
            $call->query("INSERT INTO logs VALUES ('','".$kepo['username']."','login','$ip','$datetime')");
            if(isset($_COOKIE['FCM_TOKEN'])) {
                $userFcm = $_COOKIE['FCM_TOKEN'];
                $call->query("INSERT INTO users_token VALUES ('','".$kepo['username']."','$userFcm','$datetime')");
            }
            mailer($_MAILER, [
                'dest' => $data['email'],
                'name' => $data['name'],
                'subject' => 'Detail Untuk '.$_CONFIG['title'].' Akun',
                'message' => base64_encode(mailplate('detail', ['user' => $data])),
                'is_template' => 'yes'
            ]);
            $_SESSION['result'] = ['type' => true,'message' => 'Validasi Berhasil, Terima Kasih Telah Mendaftar.'];
            
            unset($_SESSION['register']);
            redirect(0, base_url());
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'An error occurred, please try again.'];
        }
    }
} else if(isset($_POST['resend_otp'])) {
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System Error, please try again later.'];
    } else {
        $result_wa = $WATL->sendMessage($data['phone'],"Hallo ".$data['name'].", Kode OTP anda untuk validasi Akun adalah ".$_SESSION['register']['otp'].", Terimakasih Telah Bergabung bersama {$_CONFIG['title']}");
        $result_mail = mailer($_MAILER,[
            'dest' => $data['email'],
            'name' => $data['name'],
            'subject' => 'OTP Untuk '.$_CONFIG['title'].' Akun',
            'message' => base64_encode(mailplate('otp',[
                'name' => $data['name'],
                'otp' => $_SESSION['register']['otp']
            ])),
            'is_template' => 'yes'
        ]);
        
        file_put_contents('.notifier',json_encode($result_wa, JSON_PRETTY_PRINT));
        if($result_mail == true || $result_wa['result'] == false) {
            $_SESSION['result'] = ['type' => true,'message' => 'Kode Verifikasi Telah Dikirim, Silahkan Cek Inbox/Folder Spam Email Anda'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Gagal Kirim Kode OTP.'];
        }
    }
} else if(isset($_POST['cancel'])) {
    unset($_SESSION['login']);
    unset($_SESSION['result']);
    unset($_SESSION['pin']);
    unset($_SESSION['register']);
} 