<?php 
// if(in_array($page, ['Isi Saldo', 'Pilih Metode Pembayaran', 'Konfirmasi Deposit', 'Rincian Transaksi', 'Menunggu Pembayaran', 'Transfer Saldo', 'Konfirmasi Transfer', 'Pembayaran Berhasil', 'Syarat & Ketentuan', 'Kebijakan Privasi', 'Pusat Bantuan', 'Tentang Kami', 'Ubah Profil', 'Ganti PIN', 'Pemberitahuan', 'Kembali', 'Upgrade Level', 'Coming Soon', 'Daftar Harga', 'Login', 'Verifikasi OTP', 'Verifikasi PIN', 'Daftar', 'Detail Berita', 'Tarik Komisi', 'Konfirmasi Penarikan', 'Pulsa Reguler', 'Paket Internet', 'Games', 'Pulsa Transfer', 'E-Money', 'Token PLN', 'Voucher', 'Pascabayar']))
?>
<style>
    /*.appBottomMenu .item .action-button:before {
        border: 3px solid red;
    }
    .appBottomMenu .item .action-button:after {
        border: 3px solid red;
    }*/
    .appBottomMenu .item .col.sp {
        padding: 0;
    }
    .appBottomMenu .item .bd {
        width: 100%;
        background-color: transparent;
        border-bottom-left-radius: 100%;
        border-bottom-right-radius: 100%;
        border-bottom: 1px solid #e1e1e1;
        position: relative;
        bottom: 9px;
    }
    .appBottomMenu .item .col strong, .appBottomMenu .item .col ion-icon {
        color: #afafaf;
    }
    .appBottomMenu .item {
        border-top: 1px solid #e1e1e1
    }
</style>
<?php if(in_array($page, ['Dashboard', 'Akun Saya'])): ?>
    <!-- App Bottom Menu -->
    <div class="appBottomMenu app shadowed bg-white">
        <a href="<?= base_url() ?>" class="item<?= $page === 'Dashboard' ? ' active' : '' ?>">
            <div class="col">
                <ion-icon name="home"></ion-icon>
                <strong>Home</strong>
            </div>
        </a>
        <a href="<?= base_url('page/riwayat.php'); ?>" class="item<?= $page === 'Riwayat' ? ' active' : '' ?>" style="border-top-right-radius: 30px">
            <div class="col">
                <ion-icon name="receipt"></ion-icon>
                <strong>Riwayat</strong>
            </div>
        </a>
        <a href="<?= base_url('shop/'); ?>" class="item" style="opacity: 1; border-top: 0">
            <div class="col sp">
                <div class="bd">
                    <div class="action-button bg-primary" style="border: 0; top: -9px; height: 52px; width: 52px; box-shadow: 0px 5px 10px 0px rgba(0,0,0,0.3);">
                        <ion-icon name="storefront" style="color: #FFF !important;"></ion-icon>
                    </div>
                </div>
            </div>
        </a>
        <a href="<?= base_url('page/event.php'); ?>" class="item<?= $page === 'Coming Soon' ? ' active' : '' ?>" style="border-top-left-radius: 30px">
            <div class="col">
                <ion-icon name="gift"></ion-icon>
                <strong>Event</strong>
            </div>
        </a>
        <a href="<?= base_url('account/profile.php') ?>" class="item<?= $page === 'Akun Saya' ? ' active' : '' ?>">
            <div class="col">
                <ion-icon name="person"></ion-icon>
                <strong>Profile</strong>
            </div>
        </a>
    </div>
    <!-- * App Bottom Menu -->
<?php endif ?>

<? require _DIR_('library/modal') ?>
    <!-- ///////////// Js Files ////////////////////  -->
    <script type="module" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="<?= assets('mobile/') ?>js/plugins/jquery-marquee/jquery.marquee.min.js"></script>
    <script src="<?= assets('mobile/') ?>js/plugins/owl-carousel/owl.carousel.min.js"></script>
    <!-- jQuery Circle Progress -->
    <script src="<?= assets('mobile/') ?>js/plugins/jquery-circle-progress/circle-progress.min.js"></script>
    <!-- Base Js File -->
        <script src="<?= assets('mobile/') ?>js/plugins/jquery-inputmask/inputmask.min.js"></script>
    <script src="<?= assets('mobile/') ?>js/plugins/jquery-inputmask/bindings/inputmask.binding.js"></script>

    <script src="<?= assets('mobile/') ?>js/base.js?=<?= time() ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.13.0/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.marquee').marquee({
                duration: 4100,
                delayBeforeStart: 1500,
                direction: 'left',
            });

            if($('#successResult').length) {
                $('#successResult').modal('show');
            } else if($('#errorResult').length) {
                $('#errorResult').modal('show');
            }
        });
    </script>
    <script>
        $('#name, #nohp').keyup(function() {
            var name = $('#name').val().length;
            var nohp = $('#nohp').val().length;
            if(name > 4 && nohp > 10) {
                $('#next-step').attr('disabled', false);
            } else {
                $('#next-step').attr('disabled', true);
            }
        });
    </script>
<?php if($page === 'Coming Soon'): ?>
    <!-- jQuery Countdown -->
    <script src="<?= assets('mobile/') ?>js/plugins/jquery-countdown/jquery.countdown.min.js"></script>
    <!-- jQuery Countdown Settings -->
    <script>
        var date = "2021/12/20"; 
        $('#countDown').countdown(date, function (event) {
            $(this).html(event.strftime(
                '<div>%D<span>Days</span></div>'
                +
                '<div>%H<span>Hours</span></div>'
                +
                '<div>%M<span>Minutes</span></div>'
                +
                '<div>%S<span>Seconds</span></div>'
            ));
        });
    </script>
    
<?php endif; ?>
    <script type="text/javascript">
        function depositNominal(value) {
            $('input[name="nominal"]').val(value);
        }
        function copyToClipboard(value) {
            var tempInput = document.createElement('input');
            tempInput.value = value;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            toastbox('toastCopy', 1000).show();
        }
        function Loader() {
            $('body').html('<div id="loader"><div class="spinner-border text-primary" role="status"></div></div>');
        }
        function disabled() {
            var e = this;
            setTimeout(function(){
                e.disabled=true;
            }, 0);
            return true;
        }
    </script>
    
    <div id="toastCopy" class="toast-box toast-center bg-secondary">
        <div class="in">
            <div class="text">
                Berhasil Salin Ke Clipboard
            </div>
        </div>
    </div>
    
    <div id="toastComingSoon" class="toast-box toast-center bg-secondary">
        <div class="in">
            <div class="text">
                Fitur Belum Tersedia!
            </div>
        </div>
    </div>
    
</body>

</html>