<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kargo Takip</title>
    <script src="https://kit.fontawesome.com/22ffbb5dc2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <style>
        
        .img-fluid.mt100 {
            margin-left: 120px; 
            max-width: 100%; 
            height: auto; 
        }
        .responsive-img {
            width: 600px; 
            height: auto; 
            margin-left: 120px; 
        }
    </style>
</head>
<body>
    <section id="Menu">
        <div id="logo"> KOLYA KARGO </div>
        <nav>
            <a href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
            <a href="#hakkimizda"><i class="fa-solid fa-info ikon"></i>Hakkımızda</a>
            <a href="#iletisim"><i class="fa-solid fa-map-pin"></i>İletişim</a>
            <a href="musteri.php"><i class="fa-solid fa-truck-fast"></i> Kargo Takip</a>
            
        </nav>
    </section>
    <section id="Anasayfa">
        <div id="black"></div>
        <div id="İçerik"> 
            <h2> Kargo Taşıma Detayları</h2>
            <hr width="390" align="left">
            <p>Yurt dışına kargolarınızın güvenli ve hızlı ulaşımı <br>için kara, hava ve deniz yolu seçeneklerimizle Moskova, <br> Kazakistan, Azerbaycan noktalarına ulaşım sağlıyoruz. <br> Tır, uçak ve gemi ile taşımacılık hizmetlerimizle <br>gönderileriniz en güvenli rotalardan size ulaşıyor.</p>
        </div>
    </section>  
    <section id="hakkimizda">
    <div class="container">
        <div class="header-section">
            <h3>HAKKIMIZDA</h3>
            <p>
                2016 yılında taşımacılık sektöründe başlayan serüvenimiz, güvenli ve hızlı kargo hizmetiyle müşterilerimize kaliteli hizmet sunmayı amaçlıyor. 
                Kazakistan, Azerbaycan ve Rusya gibi önemli merkezlere taşıma sağlamaktayız.
            </p>
        </div>
        <div class="content-section">
            <div class="feature-box">
                <i class="fa-solid fa-truck-fast icon"></i>
                <h4>Hızlı Taşıma</h4>
                <p>
                    Hava, kara ve deniz taşımacılığındaki uzmanlığımızla gönderilerinizi zamanında ulaştırıyoruz.
                </p>
            </div>
            <div class="feature-box">
                <i class="fa-solid fa-shield-halved icon"></i>
                <h4>Güvenilir Hizmet</h4>
                <p>
                    Taşıma sürecinizin her adımında şeffaflık ve güven sağlıyoruz. Müşteri memnuniyeti önceliğimizdir.
                </p>
            </div>
            <div class="feature-box">
                <i class="fa-solid fa-globe icon"></i>
                <h4>Küresel Erişim</h4>
                <p>
                    Lojistik ağımızla birçok ülkeye ulaşım sağlıyoruz.
                </p>
            </div>
        </div>
    </div>
</section>



    <section id="subeler">
    <h3>ŞUBELER</h3>
    <div class="container">
        <div class="sube-card">
            <h5>Türkiye</h5>
            <p>İstanbul</p>
        </div>
        <div class="sube-card">
            <h5>Azerbaycan</h5>
            <p>Bakü</p>
        </div>
        <div class="sube-card">
            <h5>Rusya</h5>
            <p>Moskova</p>
        </div>
        <div class="sube-card">
            <h5>Kazakistan</h5>
            <p>Almatı</p>
        </div>
    </div>
</section>
    <section id="tasimalar">
        <div class="container">
            <h3>Taşıma Yöntemleri</h3>
            <div>
                <div class="card"><img src="css/istockphoto-499277049-612x612.jpg" alt="" class="img-fluid"><h5 class="baslikcard">Uçak</h5><p class="cardp">Gönderileriniz ortalama 2 gün <br>içerisinde teslim edilecektir.</p></div>
                <div class="card"><img src="css/Kamyon-ve-tir-ölcüleri-Seraytrans.jpeg" alt="" class="img-fluid"><h5 class="baslikcard">Tır</h5><p class="cardp">Gönderileriniz ortalama 5 gün <br>içerisinde teslim edilecektir.</p></div>
                <div class="card"><img src="css/istockphoto-1474410944-612x612.jpg" alt="" class="img-fluid"><h5 class="baslikcard">Gemi</h5><p class="cardp">Gönderileriniz ortalama 2 hafta <br>içerisinde teslim edilecektir.</p></div>
            </div>
        </div>
    </section>
    <section id="iletisim">
        <div class="container">
            <h3 id="h3iletisim">İletişim</h3>
            <form action="index.php" method="post">
                <div id="iletisimopak">
                    <div id="formgroup">
                        <div id="solform">
                            <input type="text" name="ad_soyad" placeholder="Ad Soyad" required class="form-control">
                            <input type="text" name="telefon_no" placeholder="Telefon Numarası" required class="form-control">
                        </div>
                        <div id="sağform">
                            <input type="email" name="mail_adres" placeholder="Email Adresiniz" required class="form-control">
                            <input type="text" name="konu" placeholder="Konu Başlığı" required class="form-control">
                        </div>
                        <textarea name="mesaj" placeholder="Mesaj Giriniz" rows="10" required class="form-control"></textarea>
                        <input type="hidden" name="olusturulma_tarihi" value="<?php echo date('Y-m-d H:i:s'); ?>">
                        <input type="submit" value="Gönder">
                    </div>
                    <div id="adres">
                        <h4>Adres:</h4>
                        <p>LALELİ / İSTANBUL<br><br>Mimar Kemalettin Mah.<br><br>Kocaraggıppaşa Cad.<br><br>İkbal Sok.</p>
                        <p>Metropol Center No: 77</p>
                        <p>+90 530 978 86 05</p>
                        <p>E-posta: kolyakargo@gmail.com</p>
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>
</html>

<?php
include("baglanti.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (!empty($_POST["ad_soyad"]) && !empty($_POST["mail_adres"]) && 
        !empty($_POST["telefon_no"]) && !empty($_POST["konu"]) && 
        !empty($_POST["mesaj"]) && !empty($_POST["olusturulma_tarihi"])) {
        
        
        $adsoyad = $_POST["ad_soyad"];
        $mail = $_POST["mail_adres"];
        $telefon = $_POST["telefon_no"];
        $konu = $_POST["konu"];
        $mesaj = $_POST["mesaj"];
        $tarih = $_POST["olusturulma_tarihi"];
        
        
        $ekle = "INSERT INTO iletisim (ad_soyad, mail_adres, telefon_no, konu, mesaj, olusturulma_tarihi) 
                 VALUES ('$adsoyad', '$mail', '$telefon', '$konu', '$mesaj', '$tarih')";
        
        if ($baglan->query($ekle) === TRUE) {
            echo "<script>alert('Mesajınız başarıyla gönderildi.')</script>";
        } else {
            echo "<script>alert('Hata oluştu: {$baglan->error}')</script>";
        }
    } else {
        echo "<script>alert('Lütfen tüm alanları doldurun.')</script>";
}
}
?>
