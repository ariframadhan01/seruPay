<?php 
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Kebijakan Privasi';
require _DIR_('library/header/user');

function UlLi($x) {
    $out = ''; $no = 1; foreach($x as $key => $value) {
        $out .= '<p><button type="button" class="btn btn-primary">'.$no.'. '.ucwords(strtolower($key)).'</button>';
        for($i = 0; $i <= count($value)-1; $i++) $out .= '<p><b>'.($i+1).'.</b> '.$value[$i].'</p>';
        $out .= '</p>'; $no++;
    } return $out;
}
?>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section full">
            <div class="wide-block pt-2 pb-1">
            <p>Sebagai penyedia layanan/Distributor & Agen Pulsa Murah All Operator, kami SeruPay sangat menjunjung tinggi privasi customer/member. Hal ini karena informasi pribadi merupakan hal yang sangat krusial dan tidak boleh diketahui siapapun. Berikut akan kami jelaskan mengenai informasi apa saja yang kami terima dan kami kumpulkan pada saat Anda mengunjungi situs SeruPay. Serta, tentang bagaimana kami menyimpan dan menjaga informasi tersebut. Kami tegaskan bahwa kami tidak akan pernah memberikan informasi tersebut kepada siapapun.</p>
<br>
<div class="terms-box">
		<h3>Tentang file log</h3>	
			<ul class="simple-list">
<p class="p-lg">Seperti situs lain pada umumnya, kami mengumpulkan dan menggunakan data yang terdapat pada file log. Informasi yang terdapat pada file log termasuk alamat IP (Internet Protocol) Anda, ISP (Internet Service Provider), browser yang Anda gunakan, waktu pada saat Anda berkunjung serta halaman mana saja yang Anda buka selama berkunjung di SeruPay.</p>
</ul>
	</div>
<br>
<div class="terms-box">
		<h3>Tentang cookies</h3>	
			<ul class="simple-list">
<p class="p-lg">Situs kami menggunakan cookies untuk menyimpan berbagai informasi seperti preferensi pribadi pada saat mengunjungi situs SeruPay serta informasi login. SeruPay juga menggunakan layanan tracking dari pihak ketiga untuk mendukung situs kami. Beberapa layanan tersebut mungkin menggunakan cookies ketika melakukan tracking di situs kami. SeruPay bekerja sama dengan layanan tracker seperti Google AdWords, Google Analytics, AdRoll serta CrazyEgg. Dimana informasi yang dikirim dapat berupa alamat IP, ISP, browser, sistem operasi yang Anda pakai, dan sebagainya. Hal ini tentu saja memiliki tujuan yaitu digunakan untuk penargetan iklan berdasarkan relevansi informasi.</p>
</ul>
	</div>
<br>
<br>
<h3>Diperbaharui: 07 November 2021</h3>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>