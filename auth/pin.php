<div class="login-form">
    <div class="section mt-5 mb-5">
        <h4 class="text-light">Silahkan masukkan PIN untuk melanjutkan.</h4>
    </div>
    <div class="section mb-5">
        <div class="form-group boxed" style="padding-left: 12px; padding-right: 12px">
            <div class="input-wrapper d-flex justify-content-between" style="font-size: 35px; color: #FFF">
                <ion-icon name="radio-button-off-outline" class="bulb-2"></ion-icon>
                <ion-icon name="radio-button-off-outline" class="bulb-2"></ion-icon>
                <ion-icon name="radio-button-off-outline" class="bulb-2"></ion-icon>
                <ion-icon name="radio-button-off-outline" class="bulb-2"></ion-icon>
                <ion-icon name="radio-button-off-outline" class="bulb-2"></ion-icon>
                <ion-icon name="radio-button-off-outline" class="bulb-2"></ion-icon>
            </div>
        </div>
        <a href="#" class="text-white bold" id="changepin" onclick="changepin()">LUPA PIN?</a>
    </div>
    <div class="section full mt-2" style="position: absolute; bottom: 0; left: 0; right: 0; padding-bottom: 2rem;">
        <div class="d-flex justify-content-around">
            <button type="button" onclick="NumberButton(this.value)" value="1" class="number-box">1</button>
            <button type="button" onclick="NumberButton(this.value)" value="2" class="number-box">2</button>
            <button type="button" onclick="NumberButton(this.value)" value="3" class="number-box">3</button>
        </div>
        <div class="d-flex justify-content-around pt-2">
            <button type="button" onclick="NumberButton(this.value)" value="4" class="number-box">4</button>
            <button type="button" onclick="NumberButton(this.value)" value="5" class="number-box">5</button>
            <button type="button" onclick="NumberButton(this.value)" value="6" class="number-box">6</button>
        </div>
        <div class="d-flex justify-content-around pt-2">
            <button type="button" onclick="NumberButton(this.value)" value="7" class="number-box">7</button>
            <button type="button" onclick="NumberButton(this.value)" value="8" class="number-box">8</button>
            <button type="button" onclick="NumberButton(this.value)" value="9" class="number-box">9</button>
        </div>
        <div class="d-flex justify-content-around pt-2">
            <div class="p-4"></div>
            <button type="button" onclick="NumberButton(this.value)" value="0" class="number-box">0</button>
            <button type="button" onclick="NumberButton(this.value)" value="backspace" class="number-box"><ion-icon name="close"></ion-icon></button>
        </div>
    </div>
</div>
<div class="modal fade dialogbox" id="confirmDialog" data-backdrop="static" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px">
            <form method="POST">
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                <input type="hidden" id="pin" name="pin">
                <div class="modal-header"></div>
                <div class="modal-body text-dark">
                    <p style="margin-bottom: .45rem; font-weight: bold">Konfirmasi PIN</p>
                    <p style="line-height: 20px" class="mb-0">Klik Lanjutkan untuk konfirmasi PIN.</p>
                </div>
                <div class="modal-footer" style="border-top: 0">
                    <div class="d-flex justify-content-between pl-2 pr-2 pb-2">
                        <a href="#" class="btn btn-sm btn-link text-dark goCancel" style="border-right: 0 !important; width: 42%; font-size: 13px">Tutup</a>
                        <button type="submit" class="btn btn-sm btn-primary" name="verifPin" style="width: 42%; font-size: 13px">Lanjut</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.goCancel').click(function(e) {
            e.preventDefault();
            $('#pin').val('');
            $('#confirmDialog').modal('hide');
            $('.bulb-2').attr('name', 'radio-button-off-outline');
        })
    });
    function NumberButton(key) {
        let input = document.querySelector('#pin'),
            bulb = document.querySelectorAll('.bulb-2');
        if(key != "backspace"){
            for (i = 0; i < key.length; i++) {
                input.value = input.value + event.currentTarget.value;
            }
        } else {
            for (i=input.value.length-1; i>=0;  i--) {
                 bulb[i].setAttribute("name", "radio-button-off-outline");
            }
            input.value = input.value.substring(0, input.value.length -1);
        }
        let pin = input.value.replace(/[^0-9]/g, '');
        for (i = 0; i < pin.length;  i++) {
            bulb[i].setAttribute("name", "radio-button-on-outline");
        }
        if(pin.length === 6) {
            $('#confirmDialog').modal('show');
        }
    }
</script>