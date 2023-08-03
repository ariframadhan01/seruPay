    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-pending-transaksi mt-5">
        <div class="section">

            <div class="text-center">
                <button type="button" class="btn btn-icon btn-lg">
                    <ion-icon name="checkmark-done-outline"></ion-icon>
                </button>
                <h2 class="text-white">Pembayaran Berhasil</h2>
                <small>Transaksi Kamu Sedang Dalam Proses</small>
                <small class="mt-3" style="display: block">TOTAL PEMBAYARAN</small>
                <h3 class="text-white">Rp <?= currency($_SESSION['success']['price']) ?></h3>
            </div>

            <div class="form-button-group rgs-detail-transfer bg-primary text-center">
                <a href="<?= base_url('order/detail/'.$_SESSION['success']['trxid']) ?>" class="text-white"><small><u>Lihat Rincian</u></small></a>
                <a href="<?= base_url() ?>" class="btn rounded shadowed btn-block btn-lg mt-2 mb-2">Selesai</a>
            </div>

        </div>
    </div>
    <!-- * App Capsule -->