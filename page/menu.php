<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Daftar Layanan';
require _DIR_('library/header/user');
?>
<style>
    .app-menu .item strong {
        margin-top: 8px
    }
</style>
    <!-- App Capsule -->
        <div class="section full rgs-info bg-white" style="margin-top: 70px">
        <div class="card">
            <div class="p-2 pb-2">
                <div style="font-size: 14px; font-weight: 600;">Isi Ulang</div>
                <div style="font-size: 12px; opacity: .576">Dengan <?= $_CONFIG['title']; ?> isi ulang menjadi lebih mudah</div>
            </div>
            <div class="app-menu mt-0">
                <a href="<?= base_url('order/pulsa-reguler') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/pulsa-1.png') ?>" width="50px">
                        <strong>Pulsa Reguler</strong>
                    </div>
                </a>
                <a href="<?= base_url('order/pulsa-transfer') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/pulsa-transfer-1.png') ?>" width="50px">
                        <strong>Pulsa Transfer</strong>
                    </div>
                </a>
                <a href="<?= base_url('order/paket-internet') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/paket-internet-1.png') ?>" width="50px">
                        <strong>Paket Data</strong>
                    </div>
                </a>
                <a href="<?= base_url('order/paket-telp') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/paket-telp-1.png') ?>" width="50px">
                        <strong>Paket SMS&Telepon</strong>
                    </div>
                </a>
            </div>
            <div class="app-menu mt-3">
                <a href="<?= base_url('order/token-pln') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/token-pln-1.png') ?>" width="50px">
                        <strong>Token PLN</strong>
                    </div>
                </a>
                <a href="<?= base_url('order/pulsa-international') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/globe.jpg') ?>" width="50px">
                        <strong>Pulsa Internasional</strong>
                    </div>
                </a>
                <a href="#" class="item"></a>
                <a href="#" class="item"></a>
            </div>
            <div class="divider mt-3"></div>
        </div>
        <div class="card">
            <div class="p-2 pb-2">
                <div style="font-size: 14px; font-weight: 600;">Uang Elektronik</div>
                <div style="font-size: 12px; opacity: .576">Beli semua kebutuhan Uang Elektronik, hanya di <?= $_CONFIG['title']; ?></div>
            </div>
            <div class="app-menu mt-0">
                    <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('BRI BRIZZI') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/emoney/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
                    <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('MANDIRI E TOLL') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/emoney/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('TAPCASH BNI') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/emoney/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
                <a href="#" class="item"></a>
            </div>
            
            <div class="divider mt-3"></div>
        </div>
        <div class="card">
            <div class="p-2 pb-2">
                <div style="font-size: 14px; font-weight: 600;">Dompet Digital</div>
                <div style="font-size: 12px; opacity: .576">Solusi semua pembayaran Elektronik, hanya di <?= $_CONFIG['title']; ?></div>
            </div>
            <div class="app-menu mt-0">
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('SHOPEE PAY') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/emoney/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('MITRA SHOPEE') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/emoney/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('GO PAY') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/emoney/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('GO PAY DRIVER') AND kategori = 'Driver' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/emoney/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
                </div>
                <div class="app-menu mt-3">
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('GRAB') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/emoney/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('GRAB DRIVER') AND kategori = 'Driver' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/emoney/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('OVO') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/emoney/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('DANA') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/emoney/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
            </div>
            <div class="app-menu mt-3">
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('SAKUKU') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/emoney/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('LINKAJA') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/emoney/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('I.SAKU') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/emoney/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('MAXIM DRIVER') AND kategori = 'Driver' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/emoney/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
            </div>
            <div class="app-menu mt-4">
                <a href="<?= base_url('order/paypal') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/paypal.png') ?>" alt="Paypal" width="50px">
                        <strong>PAYPAL</strong>
                    </div>
                </a>
                <a href="#" class="item"></a>
                <a href="#" class="item"></a>
                <a href="#" class="item"></a>
            </div>
            <div class="divider mt-3"></div>
        </div>
        <div class="card">
            <div class="p-2 pb-2">
                <div style="font-size: 14px; font-weight: 600;">Tagihan</div>
                <div style="font-size: 12px; opacity: .576">Solusi semua pembayaran Tagihan, hanya di <?= $_CONFIG['title']; ?></div>
            </div>
            <div class="app-menu mt-0">
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('PLN PASCABAYAR') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/pascabayars/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('PDAM') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/pascabayars/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('GAS NEGARA') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/pascabayars/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('PBB') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/pascabayars/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                <?php } ?>
            </div>
            <div class="app-menu mt-3">
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('BPJS KESEHATAN') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/pascabayars/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('INTERNET PASCABAYAR') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/pascabayars/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('MULTIFINANCE') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/pascabayars/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('HP PASCABAYAR') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/pascabayars/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                <?php } ?>
            </div>
            <div class="divider mt-3"></div>
        </div>
        <div class="card">
            <div class="p-2 pb-2">
                <div style="font-size: 14px; font-weight: 600;">Voucher</div>
                <div style="font-size: 12px; opacity: .576">Beli voucher terlengkap, hanya di <?= $_CONFIG['title']; ?></div>
            </div>
            <div class="app-menu mt-0">
                <a href="<?= base_url('order/games') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/games-1.png') ?>" width="50px">
                        <strong>Voucher Games</strong>
                    </div>
                </a>
                <a href="<?= base_url('order/voucher') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/data-1.png') ?>" width="50px">
                        <strong>Voucher Lainnya</strong>
                    </div>
                </a>
                <a href="#" onclick="toastbox('toastComingSoon', 2500)" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/inject.png') ?>" width="50px">
                        <strong>Inject Voucher</strong>
                    </div>
                </a>
                <a href="#" class="item"></a>
            </div>
            <div class="divider mt-3"></div>
        </div>
        <div class="card">
            <div class="p-2 pb-2">
                <div style="font-size: 14px; font-weight: 600;">Layanan Lainnya</div>
                <div style="font-size: 12px; opacity: .576">Lihat layanan lainnya dari <?= $_CONFIG['title']; ?></div>
            </div>
            <div class="app-menu mt-0">
                <a href="#" onclick="toastbox('toastComingSoon', 2500)" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/icon-sosmed.png') ?>" width="50px">
                        <strong>Social Media</strong>
                    </div>
                </a>
                 <a href="#" onclick="toastbox('toastComingSoon', 2500)" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/donasi.png') ?>" width="50px">
                        <strong>Donasi</strong>
                    </div>
                </a>
                <a href="#" class="item"></a>
                <a href="#" class="item"></a>
            </div>
            <div class="divider mt-3"></div>
        </div>
        <div class="card">
            <div class="p-2 pb-2">
                <div style="font-size: 14px; font-weight: 600;">Keagenan</div>
                <div style="font-size: 12px; opacity: .576">Kelola data keagenan anda di <?= $_CONFIG['title']; ?></div>
            </div>
            <div class="app-menu mt-0">
                <a href="<?= base_url('deposit/transfer') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/transfer-saldo.png') ?>" width="50px">
                        <strong>Transfer Saldo</strong>
                    </div>
                </a>
                <a href="<?= base_url('premium') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/tarik-komisi.png') ?>" width="50px">
                        <strong>Tarik Komisi</strong>
                    </div>
                </a>
                <a href="<?= base_url('premium/tukar-poin') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/tukar-poin.png') ?>" width="50px">
                        <strong>Tukar Poin</strong>
                    </div>
                </a>
                <a href="<?= base_url('referral') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/referral-1.png') ?>" width="50px">
                        <strong>Kode Referral</strong>
                    </div>
                </a>
            </div>
            <div class="divider mt-3"></div>
        </div>
        
        <div class="card">
            <div class="p-2 pb-2">
                <div style="font-size: 14px; font-weight: 600;">Bantuan</div>
                <div style="font-size: 12px; opacity: .576">Layanan Bantuan <?= $_CONFIG['title']; ?></div>
            </div>
            <div class="app-menu mt-0">
                <a href="<?= base_url('page/about-us.php') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/help.png') ?>" width="50px">
                        <strong>Hubungi CS</strong>
                    </div>
                </a>
                <a href="<?= base_url('page/price-list.php') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/daftar-harga.png') ?>" width="50px">
                        <strong>Daftar Harga</strong>
                    </div>
                </a>
                <a href="<?= base_url('page/terms-conditions.php') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/s-k.png') ?>" width="50px">
                        <strong>S&K</strong>
                    </div>
                </a>
                <a href="<?= base_url('page/help-center.php') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/pusat-bantuan.png') ?>" width="50px">
                        <strong>Pusat Bantuan</strong>
                    </div>
                </a>
            </div>
             <div class="divider mt-3"></div>
        </div>
    </div>
    
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>
