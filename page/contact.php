<?php 
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Hubungi Kami';
require _DIR_('library/header/user');

function card($i, $title, $konten) {
    return '<div class="item">
                <div class="accordion-header">
                    <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#faq'.$i.'">
                        '.$title.'
                    </button>
                </div>
                <div id="faq'.$i.'" class="accordion-body collapse" data-parent="#general">
                    <div class="accordion-content">
                        '.$konten.'
                    </div>
                </div>
            </div>';
}
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-other">
        <div class="section text-center">
            <img src="<?= assets('mobile/img/svg/question.svg'); ?>" alt="image" class="imaged w200">
        </div>

        <div class="section full">
            <div class="section-title">Nomer Bantuan SeruPay</div>
            <div class="wide-block pt-2 pb-2">
                Ada pertanyaan atau butuh bantuan hubungi kami sekarang.<br>
                <br>
                <b>Whatsapp :</b> 085772972011<br>
                <b>Telegram :</b> @serupay<br>
                <b>Email :</b> ramdoni14@gmail.com<br>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>