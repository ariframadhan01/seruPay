<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Daftar Harga';
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-price-list">
        <div class="section pl-1 pr-1 inset mt-2">
            <div class="wide-block mb-2">
                <div class="form-group basic p-0">
                    <div class="input-wrapper">
                        <select class="form-control custom-select" id="type">
                            <option value="0" selected disabled>-> Pilih Kategori Disini <-</option>
                            <?php
                            $search = $call->query("SELECT * FROM category WHERE type != 'shop' GROUP BY type ORDER BY type ASC");
                            while($row = $search->fetch_assoc()) {
                                print '<option value="'.$row['type'].'">'.ucwords(str_replace('-', ' ', $row['type'])).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div id="service">
                
            </div>
            
            <div id="services">
                
            </div>
            
        </div>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>
<script type="text/javascript">
$(document).ready(function() {
    $("#type").change(function() {
        var type = $("#type").val();
        $.ajax({
            url: '<?= ajaxlib('product-list') ?>',
            data: 'type=' + type + '&csrf_token=<?= $csrf_string ?>',
            type: 'POST',
            dataType: 'html',
            beforeSend: () => {
                $('#service').html( '<div class="col-md-6 offset-md-3 text-center text-primary mt-4"><div class="spinner-border avatar-md" role="status"></div></div>' );
            }, 
            success: (msg) => {
                setTimeout( () => {
                    $("#service").html(msg);
                }, 500);
            }
        });
    });
});
</script>