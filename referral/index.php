<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Referral';
require _DIR_('library/header/user');

function Li($x) {
    $out = '';
    $no = 1; 
    $i = 0;
    foreach($x as $key => $value) {
        $out .= '<li>
                    <div class="item">
                        <div class="icon-box bg-primary">
                            0'.$no.'
                        </div>
                        <div class="in">
                            <div class="rgs-text-custom">'.$value.'</div>
                        </div>
                    </div>
                </li>';
        $i++; $no++;
    } 
    return $out;
}

?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-referral">
        
        <div class="section full rgs-bg-texture text-center pb-2 pt-2">
            <h4 class="text-white">Kode Referral Saya</h4>
            <div class="rgs-kode-referral">
                <h1 class="text-white"><?= strtoupper($data_user['referral']) ?></h1>
                <button type="button" class="btn btn-icon text-white" onclick="copyToClipboard('<?= strtoupper($data_user['referral']) ?>')">
                    <ion-icon name="copy-outline"></ion-icon>
                </button>
            </div>
            <p class="text-white pl-2 pr-2">Segera Ajak Temanmu Untuk Menjadi Member Dan Dapatkan Bonus Melimpah</p>
        </div>
        
        <ul class="nav nav-tabs lined bg-white" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Informasi" role="tab" aria-selected="true">
                    Informasi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Data" role="tab" aria-selected="false">
                    Data Referral
                </a>
            </li>
        </ul>
        
        <div class="tab-content">

            <!-- Informasi tab -->
            <div class="tab-pane fade active show" id="Informasi" role="tabpanel">
                
            <div class="listview-title">Keuntungan Member</div>
            <ul class="listview image-listview">
                <?= 
                    Li([
                        'Mendapatkan 2 Poin Dari Setiap Transaksi Sukses'
                    ])
                ?>
            </ul>
                
            <div class="listview-title">Keuntungan Premium</div>
            <ul class="listview image-listview">
                <?= 
                    Li([
                        'Akses Semua Fitur Layanan Premium',
                        'Mendapatkan Harga Layanan Lebih Murah',
                        'Bebas Biaya Transaksi',
                        'Mendapatkan 5 Poin Dari Setiap Transaksi Sukses',
                        'Mendapatkan Komisi Dari Referral Rp'.currency(conf('referral', 1)).' Per Trx Sukses Member Referral',
                        'Mendapatkan Komisi Dari Referral Rp'.currency(conf('referral', 2)).' Per Member Referral Upgrade Ke Premium'
                    ])
                ?>
            </ul>
                
            </div>
            <!-- * Informasi tab -->
    
            <!-- Data tab -->
            <div class="tab-pane fade" id="Data" role="tabpanel">
            
            <ul class="listview image-listview">
                <? 
                $search = $call->query("SELECT * FROM users WHERE uplink = '".$data_user['username']."' ORDER BY id ASC");
                while($row = $search->fetch_assoc()) { 
                ?>
                <li>
                    <div class="item">
                        <div>
                            <div class="icon-box bg-primary">
                                <ion-icon name="person-add-outline"></ion-icon>
                            </div>
                        </div>
                        <div class="in">
                            <div><?= $row['name'] ?></div>
                            <span class="text-muted"><?= $call->query("SELECT * FROM trx WHERE user = '".$row['username']."' AND status = 'success'")->num_rows ?> Transaksi</span>
                        </div>
                    </div>
                </li>
				<? } ?>
            </ul>
    
            </div>
            <!-- * Data tab -->

        </div>
        
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>