<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <script src="https://kit.fontawesome.com/22ffbb5dc2.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #242d74;
            color: #fff;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
            height: 100vh;
            align-items: center;
            position: relative;
            overflow: hidden;
            transition: width 0.3s ease-in-out;
        }

        .sidebar:hover {
            width: 300px;
        }

        .sidebar h2 {
            text-align: center;
            font-size: 1.5em;
            color: #fff;
        }

        .sidebar hr {
            border: 0;
            border-top: 2px solid #00bcd4;
            width: 80%;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 15px 20px;
            font-size: 1.1em;
            text-align: center;
            width: 100%;
            border-top: 1px solid #444;
            border-bottom: 1px solid #444;
            transition: background-color 0.3s ease, padding-left 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #00bcd4;
            padding-left: 30px;
        }

        .content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #fff;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
            height: 100vh;
            overflow-x: hidden;
        }

        .container {
            background-color: white;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 100%;
            margin: 20px auto;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #242d74;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Kolya Kargo</h2>
    <hr>
    <a href="masraf.php">
        <i class="fa-solid fa-dollar-sign icon"></i> Masraflar
    </a>
    <a href="stok.php">
        <i class="fa-solid fa-box icon"></i> Stok
    </a>
    <a href="tablo.php">
        <i class="fa-solid fa-truck icon"></i> Kargolar
    </a>
    <a href="sube.php">
        <i class="fa-solid fa-location-dot icon"></i> Şubeler
    </a>
    <a href="iletisim.php">
        <i class="fa-solid fa-address-book icon"></i> İletişim
    </a>
    <a href="index.php">
        <i class="fa-solid fa-right-from-bracket icon"></i> Çıkış
    </a>
</div>

<div class="content">
    <div class="container">
        <h2>Yönetici Takip Sistemi</h2>
        <form method="POST" action="">
            <div class="form-group">
                <input type="text" name="urunadi" placeholder="Ürün Adı" required>
            </div>
            <div class="form-group">
                <input type="number" name="adet" placeholder="Adet" required>
            </div>
            <div class="form-group">
                <input type="number" name="kilo" placeholder="Kilo (kg)" required>
            </div>
            <div class="form-group">
                <input type="text" name="aliciAdi" placeholder="Alıcı Adı Soyadı" required>
            </div>
            <div class="form-group">
                <input type="text" name="aliciTelefon" placeholder="Alıcı Telefon Numarası" required>
            </div>
            <div class="form-group">
                <input type="date" name="tarih" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="form-group">
                <select name="durum" required>
                    <option value="Hazırlanıyor">Hazırlanıyor</option>
                    <option value="Transfer Aşamasında">Transfer Aşamasında</option>
                    <option value="Dağıtım Şubesinde">Dağıtım Şubesinde</option>
                    <option value="Dağıtıma Çıkarıldı">Dağıtıma Çıkarıldı</option>
                    <option value="Teslim Edildi">Teslim Edildi</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="gondericiAdi" placeholder="Gönderici Adı Soyadı" required>
            </div>
            <div class="form-group">
                <select name="gonderimSekli" required>
                    <option value="Tır">Tır</option>
                    <option value="Gemi">Gemi</option>
                    <option value="Uçak">Uçak</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="gonderilecekYer" placeholder="Nereye Gönderilecek" required>
            </div>
            <div class="form-group">
                <select name="sube" required>
                    <?php
                    include("baglanti.php");

                    $sorgu = "SELECT sube_adi FROM sube";
                    $sonuc = $baglan->query($sorgu);

                    if ($sonuc->num_rows > 0) {
                        while ($satir = $sonuc->fetch_assoc()) {
                            echo "<option value='" . $satir['sube_adi'] . "'>" . $satir['sube_adi'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Şube bulunamadı</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit">Kargo Ekle</button>
        </form>
    </div>
</div>

<?php
include("baglanti.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["urunadi"], $_POST["adet"], $_POST["kilo"], $_POST["aliciAdi"], $_POST["aliciTelefon"], $_POST["tarih"], $_POST["durum"], $_POST["gondericiAdi"], $_POST["gonderimSekli"], $_POST["gonderilecekYer"], $_POST["sube"])) {
        $uad = $_POST["urunadi"];
        $adet = $_POST["adet"];
        $kilo = $_POST["kilo"];
        $aad = $_POST["aliciAdi"];
        $atel = $_POST["aliciTelefon"];
        $tarih = $_POST["tarih"];
        $durum = $_POST["durum"];
        $gonadi = $_POST["gondericiAdi"];
        $gonsek = $_POST["gonderimSekli"];
        $gonyer = $_POST["gonderilecekYer"];
        $sube = $_POST["sube"];

        
        $alici_sorgu = "SELECT alici_id FROM alici WHERE aliciAdi = '$aad' AND aliciTelefon = '$atel'";
        $alici_sonuc = $baglan->query($alici_sorgu);

        if ($alici_sonuc->num_rows > 0) {
            
            $alici_kayit = $alici_sonuc->fetch_assoc();
            $alici_id = $alici_kayit["alici_id"];
        } else {
            
            $alici_ekle = "INSERT INTO alici (aliciAdi, aliciTelefon) VALUES ('$aad', '$atel')";
            if ($baglan->query($alici_ekle) === TRUE) {
                $alici_id = $baglan->insert_id; 
            } else {
                echo "Alıcı eklenirken hata: " . $baglan->error;
                exit;
            }
        }


        $gonderici_ekle = "INSERT INTO gonderici (gondericiAdi) VALUES ('$gonadi')";
        if ($baglan->query($gonderici_ekle) === TRUE) {
            $gonderici_id = $baglan->insert_id; 
        } else {
            echo "Gönderici eklenirken hata: " . $baglan->error;
            exit;
        }

        
        $ekle = "INSERT INTO kargoekle (urunadi, adet, kilo, alici_id, tarih, durum, gonderici_id, gonderimSekli, gonderilecekYer, sube_id) 
                 VALUES ('$uad', '$adet', '$kilo', '$alici_id', '$tarih', '$durum', '$gonderici_id', '$gonsek', '$gonyer', (SELECT id FROM sube WHERE sube_adi='$sube'))";
        
        if ($baglan->query($ekle) === TRUE) {
            
            $sube_guncelle = "UPDATE sube SET kargo_sayisi = kargo_sayisi + 1 WHERE sube_adi = '$sube'";
            if ($baglan->query($sube_guncelle) === TRUE) {
                echo "<script>alert('Kargo başarıyla eklendi ve şube bilgisi güncellendi!');</script>";
            } else {
                echo "Şube güncellenirken hata: " . $baglan->error;
            }
        } else {
            echo "Kargo eklenirken hata: " . $baglan->error;
        }
    }
}
?>

</body>
</html>
