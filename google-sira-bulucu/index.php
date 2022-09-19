<?php
/*
Plugin Name: Google Sıra Bulucu
Plugin URI: https://leventemre.com
Description: Anahtar kelimenizin sırasını istediğiniz zaman eklenti üzerinden takip edin.
Version: 1.0
Author: Levent Emre PAÇAL
Author URI: https://leventemre.com
*/


add_action("admin_menu", "sira_bulucu_menu");

function sira_bulucu_menu() {
    add_menu_page("Sıra Bulucu", "Sıra Bulucu", "manage_options", 'google-sira-bulucu', "sira_bulucu_form");
}

function ham_url_v4($url) {
$url = explode("/", $url);
$url = str_replace("https://", "", $url[2]);
$url = str_replace("http://", "", $url);
$url = str_replace("www.", "", $url);
    
return $url;
}

function sira_bulucu($anahtar_kelime, $site_adresi, $lokasyon) {
$anahtar_kelime = preg_replace('/\s+/', '+', $anahtar_kelime);
$lokasyon = 'w+CAIQICI'.base64_encode($lokasyon);

$googlegir_v4 = curl_init();
curl_setopt($googlegir_v4, CURLOPT_URL, "https://www.google.com/search?num=100&q=".$anahtar_kelime."&uule=".$lokasyon);
curl_setopt($googlegir_v4, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36");
curl_setopt($googlegir_v4, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($googlegir_v4, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($googlegir_v4, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($googlegir_v4, CURLOPT_SSL_VERIFYPEER, false);

$cikti_v4 = curl_exec($googlegir_v4);

preg_match_all('@<div class="yuRUbf"><a href="(.*?)"@si', $cikti_v4, $sorgu);

if(empty(count($sorgu[1]))) { echo '<div class="notice inline notice-error notice-alt"><p>Sunucu ip adresi Google tarafından captcha sorgulamasına takıldı. Daha sonra tekrar deneyiniz.</p></div>'; exit; }

echo '<h3 id="sonuc"></h3><br><div class="mod_table">';
$sira = 0;
foreach($sorgu[1] as $veri) {
$sira++;
$site_adresi_sira = ham_url_v4($veri);
if($site_adresi_sira==$site_adresi) {
echo '<div class="list active"><strong>Siteniz '.$sira.'. sirada > '.htmlspecialchars($site_adresi_sira).'</strong></div><input type="hidden" id="bulunan_sira" value="'.$sira.'">';
} else {
echo '<div class="list"><strong>'.$sira.'. sirada > '.htmlspecialchars($site_adresi_sira).'</strong></div>';
}
}

echo '</div>
<script type="text/javascript">
var bulunan_sira = document.getElementById("bulunan_sira").value;
if(bulunan_sira==undefined || bulunan_sira=="") {
document.getElementById("sonuc").innerHTML = "Siteniz sıralama içerisinde bulunamadı.";
} else {
document.getElementById("sonuc").innerHTML = "Siteniz "+bulunan_sira+". sırada bulunuyor.";
}
</script>';
}

function sira_bulucu_form() {
?>
<style type="text/css">
.sira_bulucu_form {
text-align:center;
}

.aranan_site {

color:#4285f4;
display:inline-block!important;

}

.google1 {

color:#4285f4;
display:inline-block!important;

}
.google2 {

color:#ea4335;
display:inline-block!important;

}
.google3 {

color:#fbbc05;
display:inline-block!important;

}
.google4 {

color:#4285f4;
display:inline-block!important;

}
.google5{

color:#34a853;
display:inline-block!important;

}
.google6 {

color:#ea4335;
display:inline-block!important;

}

.mod_table{
border:1px solid #ddd;
margin-top: -1;
margin-top: ‒10;
margin-top: 0px;
border-top-width: 0px;
padding-top: 4px;
padding-bottom: 17px;
padding-left: 185px;
padding-right: 169px;
}
.mod_table .list {
padding:10px; 
border-top:1px solid #ddd; 
border-bottom:1px solid #ddd: 
background:#ddd !important;
color:#black;
font-weight:bold;
border-left:10px solid #8a8a8a;
}
.mod_table .list:nth-child(even){background:#E2F1FF}
.mod_table .list:hover{ cursor:pointer; background:#359FFF; color:#black}
.mod_table .list.active{background:#fff !important; color:#black; font-weight:bold; border-left:30px solid #12b5bd}
</style>
<div class="sira_bulucu_form">
<h1><span class="google1">G</span><span class="google2">o</span><span class="google3">o</span><span class="google4">g</span><span class="google5">l</span><span class="google6">e</span> Sıra Bulucu - <a href="https://obir.ninja">obir.ninja</a></h1>
<form action="" method="POST">
<input type="text" name="site_adresi" placeholder="site adresi" value="<?php if(empty(trim(get_option("site_adresi")))) { echo $_SERVER["SERVER_NAME"]; } else { echo get_option(htmlspecialchars("site_adresi")); } ?>">
<input type="text" name="anahtar_kelime" placeholder="anahtar kelime" value="<?php echo get_option("anahtar_kelime"); ?>"><br><br><select name="lokasyon">
      <option value="türkiye">Türkiye Geneli</option>
      <option value="istanbul">İstanbul</option>
      <option value="adana">Adana</option>
      <option value="adıyaman">Adıyaman</option>
      <option value="afyon">Afyon</option>
      <option value="ağrı">Ağrı</option>
      <option value="amasya">Amasya</option>
      <option value="ankara">Ankara</option>
      <option value="antalya">Antalya</option>
      <option value="artvin">Artvin</option>
      <option value="aydın">Aydın</option>
      <option value="balıkesir">Balıkesir</option>
      <option value="bilecik">Bilecik</option>
      <option value="bingöl">Bingöl</option>
      <option value="bitlis">Bitlis</option>
      <option value="bolu">Bolu</option>
      <option value="burdur">Burdur</option>
      <option value="bursa">Bursa</option>
      <option value="çanakkale">Çanakkale</option>
      <option value="çankırı">Çankırı</option>
      <option value="çorum">Çorum</option>
      <option value="denizli">Denizli</option>
      <option value="diyarbakır">Diyarbakır</option>
      <option value="edirne">Edirne</option>
      <option value="elazığ">Elazığ</option>
      <option value="erzincan">Erzincan</option>
      <option value="erzurum">Erzurum</option>
      <option value="eskişehir">Eskişehir</option>
      <option value="gaziantep">Gaziantep</option>
      <option value="giresun">Giresun</option>
      <option value="gümüşhane">Gümüşhane</option>
      <option value="hakkari">Hakkari</option>
      <option value="hatay">Hatay</option>
      <option value="ısparta">Isparta</option>
      <option value="mersin">Mersin</option>
      <option value="izmir">İzmir</option>
      <option value="kars">Kars</option>
      <option value="kastamonu">Kastamonu</option>
      <option value="kayseri">Kayseri</option>
      <option value="kırklareli">Kırklareli</option>
      <option value="kırşehir">Kırşehir</option>
      <option value="kocaeli">Kocaeli</option>
      <option value="konya">Konya</option>
      <option value="kütahya">Kütahya</option>
      <option value="malatya">Malatya</option>
      <option value="manisa">Manisa</option>
      <option value="kahramanmaraş">K.maraş</option>
      <option value="mardin">Mardin</option>
      <option value="muğla">Muğla</option>
      <option value="muş">Muş</option>
      <option value="nevşehir">Nevşehir</option>
      <option value="niğde">Niğde</option>
      <option value="ordu">Ordu</option>
      <option value="rize">Rize</option>
      <option value="sakarya">Sakarya</option>
      <option value="samsun">Samsun</option>
      <option value="siirt">Siirt</option>
      <option value="sinop">Sinop</option>
      <option value="sivas">Sivas</option>
      <option value="tekirdağ">Tekirdağ</option>
      <option value="tokat">Tokat</option>
      <option value="trabzon">Trabzon</option>
      <option value="tunceli">Tunceli</option>
      <option value="şanlıurfa">Şanlıurfa</option>
      <option value="uşak">Uşak</option>
      <option value="van">Van</option>
      <option value="yozgat">Yozgat</option>
      <option value="zonguldak">Zonguldak</option>
      <option value="aksaray">Aksaray</option>
      <option value="bayburt">Bayburt</option>
      <option value="karaman">Karaman</option>
      <option value="kırıkkale">Kırıkkale</option>
      <option value="batman">Batman</option>
      <option value="şırnak">Şırnak</option>
      <option value="bartın">Bartın</option>
      <option value="ardahan">Ardahan</option>
      <option value="ığdır">Iğdır</option>
      <option value="yalova">Yalova</option>
      <option value="karabük">Karabük</option>
      <option value="kilis">Kilis</option>
      <option value="osmaniye">Osmaniye</option>
      <option value="düzce">Düzce</option>
     </select><br><br>
<button class="button button-primary" type="submit" name="ayarlari_guncelle">Ayarları Güncelle</button>
<?php wp_nonce_field("sira_bulucu_post", "sira_bulucu_post"); ?>
</form>
<?php
if(isset($_POST["ayarlari_guncelle"])){
if (!isset($_POST["sira_bulucu_post"]) || ! wp_verify_nonce($_POST["sira_bulucu_post"], "sira_bulucu_post")) {
    echo '<div class="notice inline notice-error notice-alt"><p>Bu sayfaya erişiminiz yok!</p></div>';
exit;
} else {

if(empty(trim($_POST["anahtar_kelime"] and $_POST["site_adresi"] and $_POST["lokasyon"]))) {
echo '<div class="notice inline notice-error notice-alt"><p>Anahtar kelimeniz boş olmamalı.</p></div>';
} else {
$anahtar_kelime = sanitize_text_field($_POST["anahtar_kelime"]);
$site_adresi = sanitize_text_field($_POST["site_adresi"]);
$lokasyon = sanitize_text_field($_POST["lokasyon"]);
update_option("anahtar_kelime", $anahtar_kelime);
update_option("site_adresi", $site_adresi);
update_option("lokasyon", $lokasyon);
echo '<div class="updated"><p><strong>Ayarlarınız başarılı bir şekilde güncellendi.</strong></p></div>';
}
}
}
if(!empty(trim(get_option("anahtar_kelime") and get_option("site_adresi") and get_option("lokasyon")))) {
sira_bulucu(get_option("anahtar_kelime"), get_option("site_adresi"), get_option("lokasyon"));
}
echo '</div>';
}
?>
