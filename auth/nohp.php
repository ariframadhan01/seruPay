<div class="carousel-slider owl-carousel owl-theme pt-5">
    <div class="item p-2 pb-0">
        <div class="iconedbox imaged w-75 square pb-5">
            <img src="<?= assets('mobile/icon/online_store_.svg'); ?>" style="height: 11rem">
        </div>
        <h3 class="text-light">Transaksi Lebih Mudah</h3>
        <p style="font-size: 15px">Belanja kebutuhan Kamu dimana saja dan kapan saja</p>
    </div>
    <div class="item p-2 pb-0">
        <div class="iconedbox imaged w-75 square pb-5">
            <img src="<?= assets('mobile/icon/online_payment_.svg'); ?>" style="height: 11rem">
        </div>
        <h3 class="text-light">Pembayaran Cepat Dan Aman</h3>
        <p style="font-size: 15px">Proteksi langsung secara Real-Time pembayaran dan semua transaksi kamu</p>
    </div>
    <div class="item p-2 pb-0">
        <div class="iconedbox imaged w-75 square pb-5">
            <img src="<?= assets('mobile/icon/revenue_.svg'); ?>" style="height: 11rem">
        </div>
        <h3 class="text-light">Keuntungan Melimpah</h3>
        <p style="font-size: 15px">Banyak layanan murah dan bagus yang membuat dompet kamu tetap aman</p>
    </div>
</div>
<div class="login-form pb-2" style="position: absolute; bottom: 0; left: 0; right: 0;">
    <div class="section center mt-1 text-light">
        <h3 style="font-weight: 400; font-size: 15px;" class="text-light">Masukkan <span class="bold">Nomor HP</span> kamu untuk lanjut.</h3>
    </div>
    <div class="section m-2">
        <div class="form-group">
            <div class="form-control-wrap">
                <div class="form-icon form-icon-left ml-1">
                    <img src="<?= assets('mobile/icon/indonesia.svg'); ?>" class="imaged w24" style="border: 1px solid darkseagreen; border-radius: 4px;">
                    <span class="bold text-dark pl-1">+62</span>
                </div>
                <a href="#" data-toggle="modal" data-target="#inputNumberPhone" class="form-control form-control-sm" style="color: #6c757d; padding-left: 4.89rem; border-radius: 8px">812-3456-7890</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modalbox" id="inputNumberPhone" data-backdrop="static" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-primary">
            <div class="modal-header bg-primary" style="border-bottom: 0; font-size: 26px">
                <a href="javascript:;" class="text-light" data-dismiss="modal">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
                <img src="<?= assets('mobile/img/Logo/logo.png'); ?>" alt="logo" class="logo" style="max-height: 118px;">
                <span> </span>
            </div>
            <div class="modal-body">
                <div class="login-form">
                    <div class="section center mt-3 pb-3 text-light">
                        <h4 style="font-weight: 400" class="text-light">Masukkan <span class="bold">Nomor HP</span> kamu untuk lanjut.</h4>
                    </div>
                    <div class="section mb-3">
                        <form id="FormCheckPhone" method="POST">
                            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-left ml-1">
                                        <img src="<?= assets('mobile/icon/indonesia.svg'); ?>" class="imaged w24" style="border: 1px solid darkseagreen; border-radius: 4px;">
                                        <span class="bold text-dark pl-1">+62</span>
                                    </div>
                                    <input type="tel" data-inputmask="'mask': '999[-9999][-99999]', 'placeholder': ''" onkeyup="CheckNumber();" class="form-control" id="phone" name="user" style="padding-left: 5rem; border-radius: 8px" placeholder="812-3456-7890">
                                </div>
                            </div>
                            <div class="form-button-group bg-primary" style="min-height: 55px !important">
                                <button type="submit" id="SubmitNumber" name="login" class="btn btn-block btn-lg  text-white" style="font-weight: bold; background: transparent !important; font-size: 15px;" disabled="">Lanjut</button>
                            </div>
                        </form>
                    </div>
                    <div class="section center mt-1 text-light">
                        <p style="font-weight: 400; font-size: 13px" class="text-light">Dengan melanjutkan, kamu setuju dengan <span class="bold">Syarat & Ketentuan</span> dan <span class="bold">Kebijakan Privasi</span> kami</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(isset($_SESSION['phoneError'])): ?>
<div class="modal fade dialogbox" id="msgDialog" data-backdrop="static" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px">
            <div class="modal-header"></div>
            <div class="modal-body text-dark">
                <div class="form-group" style="margin-bottom: 4px;">
                    <div class="input-wrapper">
                        <input type="text" class="form-control text-center" id="phone_1" name="phone" value="<?= $_SESSION['phoneError']['phone']; ?>" style="letter-spacing: 3px; font-size: 20px; background-color: #fff" readonly="">
                    </div>
                </div>
                <p class="text-danger" style="margin-bottom: .45rem;">Nomor ini tidak terdaftar</p>
                <p style="text-align: left; line-height: 20px" class="mb-0">Silahkan daftar terlebih dahulu. Klik Lanjut untuk Daftar</p>
            </div>
            <div class="modal-footer" style="border-top: 0">
                <div class="d-flex justify-content-between pl-2 pr-2 pb-2">
                    <a href="#" class="btn btn-sm btn-link text-dark" style="border-right: 0 !important; width: 42%; font-size: 13px" data-dismiss="modal">Tutup</a>
                    <a href="javascript:;" data-toggle="modal" data-target="#register" data-dismiss="modal" class="btn btn-sm btn-primary" style="width: 42%; font-size: 13px">Lanjut</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#msgDialog').modal('show');
</script>
<?php 
unset($_SESSION['phoneError']);
endif;
?>
<script>
    function CheckNumber() {
        var phone = document.getElementById('phone').value;
        if(phone.length > 11) {
            $('#SubmitNumber').prop('disabled', false);
        } else {
            $('#SubmitNumber').prop('disabled', true);
        }
    }
</script>