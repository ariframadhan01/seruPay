<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Detail Saldo';

$search = $call->query("SELECT * FROM deposit WHERE status = 'unpaid' AND user = '$sess_username'");
$rowDepo = $search->fetch_assoc();
if($search->num_rows == 1) redirect(1,base_url('deposit/invoice/'.$rowDepo['rid']));

require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="listview-title pb-0"></div>
        <ul class="listview image-listview">
            <li>
                <a href="<?= base_url('deposit/deposit'); ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="wallet-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Isi Saldo</div>
                    </div>
                </a>
            </li>
        </ul>
        <div class="listview-title pb-0"></div>
        <ul class="listview image-listview">
            <li>
                <a href="<?= base_url('deposit/transfer'); ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="send-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Transfer Saldo</div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>