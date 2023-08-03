<?php
require '../RGShenn.php';
require _DIR_('library/session/user');

$get_s = isset($_GET['s']) ? str_replace('=', '.', str_replace('-',' ',filter($_GET['s']))) : '';
$search_cat = $call->query("SELECT * FROM category WHERE name = '$get_s' AND type = 'e-money'");
if($search_cat->num_rows == 0) exit(redirect(0,base_url('order/e-money')));
$data_cat = $search_cat->fetch_assoc();
$operator = strtolower($data_cat['name']);

if(in_array($data_cat['name'], ['GOPAY DRIVER', 'GRAB DRIVER', 'MAXIM DRIVER'])) :
    $kategori = 'Driver';
    else:
        $kategori = 'Umum';
        endif;
$srv = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand = '$operator' AND kategori = '$kategori' ORDER BY price ASC")->fetch_assoc();

if($srv['provider'] == 'X') :
    $label = 'Nama Akun Paypal';
    $placeholder = 'Masukkan Nama Terlebih Dahulu';
    $tipe = 'text';
    else :
        $label = 'Nomor HP';
        $placeholder = 'Masukkan Nomor HP Terlebih Dahulu';
        $tipe = 'number';
        endif;
        
require 'action.php';
$page = isset($_SESSION['success']) ? 'Pembayaran Berhasil' : ucwords($operator);
require _DIR_('library/header/user');
?>

<? if(isset($_SESSION['success'])) :  ?>

    <? require _DIR_('order/result') ?>

<? unset($_SESSION['success']); else: ?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-order">

        <div class="section full mb-2">
            <div class="wide-block pb-1 pt-1">
                <form id="myForm">
                <ul class="listview image-listview no-line no-space flush">
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="create-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label"><?= $label ?></label>
                                        <input type="<?= $tipe ?>" class="form-control" placeholder="<?= $placeholder ?>" name="data" id="data" required>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="section mb-1">
            <? require _DIR_('library/session/result-mobile') ?>
        </div>
        
        <div class="section rgs-list-layanan">
            <?php
            $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand = '$operator' AND kategori = '$kategori' ORDER BY price ASC");
            if($search->num_rows == FALSE) { ?>
            <div class="alert alert-danger text-left fade show" role="alert">
                Tidak Ada Layanan Yang Tersedia!
            </div>
            <? } ?>
            <div class="row rgs-show">
                <? 
                while($row = $search->fetch_assoc()) {
                    if($row['status'] == 'available') :
                ?>
                <div class="col-12 mb-2">
                    <a href="javascript:;" onclick="ConfirmModal('<?= base_url('confirm-prepaid/'.$row['code'].'/') ?>')">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <h6><?= $row['name'] ?></h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <h6>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <?= $row['note'] ?>
                            </div>
                        </div>
                    </a>    
                </div>
                <? else: ?>
                <div class="col-12 mb-2 rgs-layanan-gangguan">
                    <a href="javascript:;" onclick="ConfirmModal('<?= base_url('confirm-prepaid/'.$row['code'].'/') ?>')">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <h6><?= $row['name'] ?></h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <h6>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-8">
                                        <?= $row['note'] ?>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="text-danger">*Sedang gangguan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>    
                </div>
                <?php endif; } ?>
            </div>
        </div>

    </div>
    <!-- * App Capsule -->
<? endif ?>   
<?php require _DIR_('library/footer/user') ?>

<script type="text/javascript">
$(document).ready(function() {
    
    $(".rgs-show").hide();
    $('input[name="data"]').keyup(function(){
        var target = $("#data").val();
        
        if(target.length <= 4) {
            $(".rgs-show").hide();
        } else {
            $(".rgs-show").show();
        }
        
    });
});

function ConfirmModal(link) {
    var target = $("#data").val();
    var target2 = $("#data2").val();
    target2 == '' || !target2 ? modalKonfirmasi('Konfirmasi Transaksi', link + target) : modalKonfirmasi('Konfirmasi Transaksi', link + target + '=' + target2);
}
</script>