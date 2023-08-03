<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Riwayat';
require _DIR_('library/header/user');
?>
    <!-- App Capsule -->
    <div id="appCapsule" class="extra-header-active rgs-riwayat">
        <div class="tab-content mt-0">

            <!-- Transaksi tab -->
            <div class="tab-pane fade show active" id="Transaksi" role="tabpanel">
                
                <?
                $searchTrx = $call->query("SELECT * FROM trx WHERE user = '$sess_username' ORDER BY id DESC LIMIT 30");
                if($searchTrx->num_rows == FALSE) {
                ?>
                    <div class="text-center mt-5">
                        <img src="<?= assets('mobile/img/svg/riwayat.svg') ?>" alt="alt" class="imaged square w200">
                        <h4 class="mt-2">Anda Belum Memiliki Riwayat Transaksi</h4>
                    </div>
                <?
                } else {
                while ($rowTrx = $searchTrx->fetch_assoc()) {
                    
                    if($rowTrx['status'] == 'error') :
                        $btn = 'btn-danger';
                    elseif($rowTrx['status'] == 'success'):
                        $btn = 'btn-success';
                    else:
                        $btn = 'rgs-btn-pending';
                    endif;
                    
                    if($rowTrx['trxtype'] == 'shop') :
                        $table = 'produk';
                        $column = 'kode';
                        $value = 'kategori';
                        
                    else:
                        $table = 'srv';
                        $column = 'code';
                        $value = 'brand';
                    endif;
                    
                    
                ?>
                <a href="<?= base_url('order/detail/'.$rowTrx['wid']) ?>">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <span class="tipe"><?= strtoupper($call->query("SELECT * FROM $table WHERE $column = '".$rowTrx['code']."'")->fetch_assoc()[$value]) ?></span>
                                    <span class="layanan text-dark"><?= $rowTrx['name'] ?></span>
                                    <span class="tujuan text-dark"><?= $rowTrx['data'] ?></span>
                                    <span class="date"><?= format_date('en',$rowTrx['date_cr']) ?></span>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="kode">#<?= $rowTrx['wid'] ?></span>
                                    <span class="harga text-danger">Rp <?= currency($rowTrx['price']) ?></span>
                                    <span class="btn <?= $btn ?> btn-status rounded"><?= ucwords($rowTrx['status']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <? } } ?>
                
            </div>
            <!-- * Transaksi tab -->

            <!-- Topup tab -->
            <div class="tab-pane fade" id="Topup" role="tabpanel">
            
                <?
                $searchDepo = $call->query("SELECT * FROM deposit WHERE user = '$sess_username' AND method != 'transfer' ORDER BY id DESC LIMIT 40");
                if($searchDepo->num_rows == FALSE) {
                ?>
                    <div class="text-center mt-5">
                        <img src="<?= assets('mobile/img/svg/riwayat.svg') ?>" alt="alt" class="imaged square w200">
                        <h4 class="mt-2">Anda Belum Memiliki Riwayat Isi Saldo</h4>
                    </div>
                <?
                } else {
                    print '<ul class="listview image-listview">';
                while ($rowDepo = $searchDepo->fetch_assoc()) {
                    $label = "warning";
                    if($rowDepo['status'] == 'cancel') $label = 'danger';
                    if($rowDepo['status'] == 'paid') $label = 'success';
                ?>
                <li>
                    <a href="<?= base_url('deposit/invoice/'.$rowDepo['rid']) ?>" class="item">
                        <div class="in">
                            <div>
                                <span class="date"><?= format_date('en',$rowDepo['date_cr']) ?></span>
                                <span class="layanan">Deposit #<?= $rowDepo['rid'] ?> Via <?= $call->query("SELECT * FROM deposit_method WHERE code = '".$rowDepo['method']."'")->fetch_assoc()['name'] ?></span>
                            </div>
                            <span class="harga text-<?= $label ?>"><?= 'Rp '.currency($rowDepo['amount']) ?></span>
                        </div>
                    </a>
                </li>
                <? } } ?>
            </ul>

            </div>
            <!-- * Topup tab -->

            <!-- Mutasi tab -->
            <div class="tab-pane fade" id="Mutasi" role="tabpanel">
            
                <?
                $searchMutasi = $call->query("SELECT * FROM mutation WHERE user = '$sess_username' AND kategori IN ('Transaksi', 'Deposit', 'Lainnya', 'Tarik Komisi') ORDER BY id DESC LIMIT 50");
                if($searchMutasi->num_rows == FALSE) {
                ?>
                    <div class="text-center mt-5">
                        <img src="<?= assets('mobile/img/svg/riwayat.svg') ?>" alt="alt" class="imaged square w200">
                        <h4 class="mt-2">Anda Belum Memiliki Riwayat Mutasi</h4>
                    </div>
                <?
                } else {
                    print '<ul class="listview image-listview">';
                while ($rowMutasi = $searchMutasi->fetch_assoc()) {
                    if($rowMutasi['type'] == '+') $label = 'success';
                    if($rowMutasi['type'] == '-') $label = 'danger';
                ?>
                <li>
                    <a href="#" class="item">
                        <div class="in">
                            <div>
                                <span class="date"><?= format_date('en', $rowMutasi['date'].' '.$rowMutasi['time']) ?></span>
                                <span class="layanan"><?= $rowMutasi['note'] ?></span>
                            </div>
                            <span class="harga text-<?= $label ?>"><?= $rowMutasi['type'].'Rp '.currency($rowMutasi['amount']) ?></span>
                        </div>
                    </a>
                </li>
                <? } } ?>
            </ul>

            </div>
            <!-- * Mutasi tab -->

        </div>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>