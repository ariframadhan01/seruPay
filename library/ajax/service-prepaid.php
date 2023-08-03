<?php
require '../../RGShenn.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if(!isset($_POST['category'])) exit("No direct script access allowed!");
    if(!isset($_POST['data'])) exit("No direct script access allowed!");
    if(!isset($_POST['type']) || !in_array($_POST['type'],['pulsa-internasional','token-pln','e-money','voucher-game','voucher-game','voucher','pascabayar'])) exit("No direct script access allowed!");
    if(empty($_POST['category'])) die;
    if(empty($_POST['data']) || $_POST['data'] == '0' || $_POST['data'] == '08') die;
    
    $modal = $_POST['type'] == 'pascabayar' ? 'postpaid' : 'prepaid' ;
    $post_phone = filter($_POST['data']);
    $search = $call->query("SELECT * FROM srv WHERE brand = '".filter($_POST['category'])."' AND type = '".$_POST['type']."' AND status = 'available' ORDER BY price ASC");
    if($search->num_rows == 0) {
        $service = '<div class="alert alert-danger alert-dismissible text-left fade show" role="alert">
                        Layanan Tidak Ditemukan.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <ion-icon name="close-outline" role="img" class="md hydrated" aria-label="close outline"></ion-icon>
                        </button>
                    </div>';
        print $service;
    } else {
error_reporting(0);
        $out_srv .= '<div class="row">';
        while($row = $search->fetch_assoc()) {
            if($row['status'] == 'available') :
            $out_srv .= '<div class="col-12 mb-2"><a href="javascript:;" onclick="modalKonfirmasi(\'Konfirmasi Transaksi\',\''.base_url('confirm-'.$modal.'/'.$row['code'].'/'.$post_phone).'\')">';
            $out_srv .= '<div class="card"><div class="card-body"><div class="row"><div class="col-8"><h6>'.$row['name'].'</h6></div><div class="col-4 text-right">';
            $out_srv .= '<h6>Rp '.currency(price($data_user['level'],$row['price'],$row['provider'])).'</h6></div></div></div><div class="card-footer">'.$row['note'].'</div></div></a></div>';
            else:
            $out_srv .= '<div class="col-12 mb-2 rgs-layanan-gangguan"><a href="javascript:;" onclick="modalKonfirmasi(\'Konfirmasi Transaksi\',\''.base_url('confirm-'.$modal.'/'.$row['code'].'/'.$post_phone).'\')">';
            $out_srv .= '<div class="card"><div class="card-body"><div class="row"><div class="col-8"><h6>'.$row['name'].'</h6></div><div class="col-4 text-right"><h6>Rp '.currency(price($data_user['level'],$row['price'],$row['provider'])).'</h6></div></div></div>';
            $out_srv .= '<div class="card-footer"><div class="row"><div class="col-8">'.$row['note'].'</div><div class="col-4 text-right"><span class="text-danger">*Sedang gangguan</span></div></div></div></div></a></div>';    
            endif;
        }
        $out_srv .= '</div>';
        
        print $out_srv;
    }
} else {
	exit("No direct script access allowed!");
}