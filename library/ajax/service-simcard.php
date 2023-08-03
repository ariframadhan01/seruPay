<?php
require '../../RGShenn.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!isset($_SESSION['user'])) exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');
    if(!isset($_POST['phone'])) exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');
    if(!isset($_POST['type']) || !in_array($_POST['type'],['pulsa-reguler','pulsa-gift','pulsa-transfer','paket-internet','paket-telepon'])) exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');
    if(empty($_POST['phone'])) exit(json_encode(['service' => '', 'brand' => '','class' => '']));
    
    $post_type = $_POST['type'];
    $post_phone = filter_phone('0',$_POST['phone']);
    $kategori = isset($_POST['kategori']) ? filter($_POST['kategori']) : 'Umum';
    $brand = strtr(strtoupper($SimCard->operator($post_phone)),[
        'THREE' => 'TRI',
        'SMARTFREN' => 'SMART'
    ]);
    $itype = $post_type == 'pulsa-reguler' ? 'pulsa-reguler' : ($post_type == 'pulsa-transfer' ? 'pulsa-transfer' : 'paket-internet');
    $image = strtr($brand,[
        'TELKOMSEL' => assets('images/operator-icon/telkomsel.png?'.time()),
        'BY.U' => assets('images/operator-icon/byu.png?'.time()),
        'INDOSAT' => assets('images/operator-icon/indosat.png?'.time()),
        'XL' => assets('images/operator-icon/xl.png?'.time()),
        'AXIS' => assets('images/operator-icon/axis.png?'.time()),
        'SMART' => assets('images/operator-icon/smartfren.png?'.time()),
        'TRI' => assets('images/operator-icon/tri.png?'.time()),
    ]);
    
    if(strtolower($brand) != 'unknown') {
        if($post_type == 'paket-internet') {
            $search = $call->query("SELECT * FROM srv WHERE brand = '$brand' AND type = '$post_type' AND kategori = '$kategori' ORDER BY price ASC");
        } else {
            $search = $call->query("SELECT * FROM srv WHERE brand = '$brand' AND type = '$post_type' ORDER BY price ASC");
        }
        $out_srv = '';
        if($search->num_rows == false) {
            $service = '<div class="alert alert-danger alert-dismissible text-left fade show" role="alert">
                            Layanan Tidak Ditemukan.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <ion-icon name="close-outline" role="img" class="md hydrated" aria-label="close outline"></ion-icon>
                            </button>
                        </div>';
            print json_encode(['service' => $service, 'brand' => null,'image' => $image]);
        } else {
error_reporting(0);
            if($post_type == 'pulsa-reguler') {
                $out_srv .= '<div class="row">';
                while($row = $search->fetch_assoc()) {
                    if($row['status'] == 'available') :
                    $out_srv .= '<div class="col-6 mb-2"><a href="javascript:;" onclick="modalKonfirmasi(\'Konfirmasi Transaksi\',\''.base_url('confirm-prepaid/'.$row['code'].'/'.$post_phone).'\')">';
                    $out_srv .= '<div class="card"><div class="card-body"><h4>'.exServices($brand,$row['name']).'</h4></div>';
                    $out_srv .= '<div class="card-footer rgs-layanan-pulsa">Rp '.currency(price($data_user['level'],$row['price'],$row['provider'])).'</div></div></a></div>';
                    else:
                    $out_srv .= '<div class="col-6 mb-2 rgs-layanan-gangguan"><a href="javascript:;" onclick="modalKonfirmasi(\'Konfirmasi Transaksi\',\''.base_url('confirm-prepaid/'.$row['code'].'/'.$post_phone).'\')">';
                    $out_srv .= '<div class="card"><div class="card-body"><h4>'.exServices($brand,$row['name']).'</h4></div><div class="card-footer rgs-layanan-pulsa">';
                    $out_srv .= '<span class="text-danger">*Sedang gangguan</span></div></div></a></div>';
                    endif;
                }
                $out_srv .= '</div>';
            } else {
                $out_srv .= '<div class="row">';
                while($row = $search->fetch_assoc()) {
                    if($row['status'] == 'available') :
                    $out_srv .= '<div class="col-12 mb-2"><a href="javascript:;" onclick="modalKonfirmasi(\'Konfirmasi Transaksi\',\''.base_url('confirm-prepaid/'.$row['code'].'/'.$post_phone).'\')">';
                    $out_srv .= '<div class="card"><div class="card-body"><div class="row"><div class="col-8"><h6>'.$row['name'].'</h6></div><div class="col-4 text-right">';
                    $out_srv .= '<h6>Rp '.currency(price($data_user['level'],$row['price'],$row['provider'])).'</h6></div></div></div><div class="card-footer">'.$row['note'].'</div></div></a></div>';
                    else:
                    $out_srv .= '<div class="col-12 mb-2 rgs-layanan-gangguan"><a href="javascript:;" onclick="modalKonfirmasi(\'Konfirmasi Transaksi\',\''.base_url('confirm-prepaid/'.$row['code'].'/'.$post_phone).'\')">';
                    $out_srv .= '<div class="card"><div class="card-body"><div class="row"><div class="col-8"><h6>'.$row['name'].'</h6></div><div class="col-4 text-right"><h6>Rp '.currency(price($data_user['level'],$row['price'],$row['provider'])).'</h6></div></div></div>';
                    $out_srv .= '<div class="card-footer"><div class="row"><div class="col-8">'.$row['note'].'</div><div class="col-4 text-right"><span class="text-danger">*Sedang gangguan</span></div></div></div></div></a></div>';    
                    endif;
                }
                $out_srv .= '</div>';
            }
        }
        print json_encode(['service' => $out_srv, 'brand' => $brand,'image' => $image]);
    } else {
    $service = '<div class="alert alert-danger alert-dismissible text-left fade show" role="alert">
                    Layanan Tidak Ditemukan.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <ion-icon name="close-outline" role="img" class="md hydrated" aria-label="close outline"></ion-icon>
                    </button>
                </div>';
        print json_encode(['service' => $service, 'brand' => null,'image' => assets('mobile/img/home/'.$itype.'.svg')]);
    }
} else {
	exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');
}