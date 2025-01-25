<?php
include("baglanti.php");


if (isset($_GET['sil_id'])) {
    $sil_id = $_GET['sil_id'];
    
    
    $sorgu_sube_alici_gonderici = "SELECT sube_id, alici_id, gonderici_id FROM kargoekle WHERE id = $sil_id";
    $sonuc_sube_alici_gonderici = $baglan->query($sorgu_sube_alici_gonderici);
    if ($sonuc_sube_alici_gonderici->num_rows > 0) {
        $row = $sonuc_sube_alici_gonderici->fetch_assoc();
        $sube_id = $row['sube_id'];
        $alici_id = $row['alici_id'];
        $gonderici_id = $row['gonderici_id'];

        
        $baglan->query("SET foreign_key_checks = 0");

        
        $sil_sorgu = "DELETE FROM kargoekle WHERE id = $sil_id";
        if ($baglan->query($sil_sorgu)) {
            
            $update_sorgu = "UPDATE sube SET kargo_sayisi = kargo_sayisi - 1 WHERE id = $sube_id";
            $baglan->query($update_sorgu);

            
            $sil_alici_sorgu = "DELETE FROM alici WHERE alici_id = $alici_id AND alici_id NOT IN (SELECT alici_id FROM kargoekle WHERE alici_id = $alici_id)";
            $baglan->query($sil_alici_sorgu);

            
            $sil_gonderici_sorgu = "DELETE FROM gonderici WHERE gonderici_id = $gonderici_id AND gonderici_id NOT IN (SELECT gonderici_id FROM kargoekle WHERE gonderici_id = $gonderici_id)";
            $baglan->query($sil_gonderici_sorgu);

            
            $baglan->query("SET foreign_key_checks = 1");

            echo "<script>alert('Kargo, alıcı ve gönderici başarıyla silindi!'); window.location.href='tablo.php';</script>";
        } else {
            echo "<script>alert('Silme işlemi sırasında hata oluştu.');</script>";
        }
    } else {
        echo "<script>alert('Silinecek kargo kaydı bulunamadı.');</script>";
    }

    exit;
}
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kargo Tablosu</title>
    <script src="https://kit.fontawesome.com/22ffbb5dc2.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            position: relative;
        }

        .logout {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .logout i {
            font-size: 24px;
            color: #007bff;
            cursor: pointer;
        }

        .logout i:hover {
            color: #0056b3;
        }

        .table-container {
            width: 90%;
            height: 90%;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .table-wrapper {
            flex: 1;
            overflow-y: auto;
            overflow-x: auto;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #242d74;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        td {
            background-color: #f9f9f9;
        }

        .edit-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        select {
            padding: 5px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 10px;
        }

        button:hover {
            background-color: #218838;
        }

        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        .filter-form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .filter-form input[type="date"] {
            padding: 5px;
            font-size: 16px;
            margin-right: 10px;
        }

        .filter-form button {
            padding: 5px 10px;
            font-size: 16px;
            background-color: gray;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .filter-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="logout">
    <a href="admin.php"><i class="fa-solid fa-right-from-bracket"></i></a>
</div>

<div class="table-container">
    <h2>Kargo Tablosu</h2>
    
    <form class="filter-form" method="GET" action="">
        <input type="date" name="tarih" value="<?php 
            date_default_timezone_set('Europe/Istanbul');
            echo isset($_GET['tarih']) ? $_GET['tarih'] : date('Y-m-d'); 
        ?>" required>
        <button type="submit">Filtrele</button>
    </form>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Kargo Kodu</th>
                    <th>Ürün Adı</th>
                    <th>Adet</th>
                    <th>Kilo (kg)</th>
                    <th>Alıcı Adı Soyadı</th>
                    <th>Alıcı Telefon Numarası</th>
                    <th>Gönderici Adı Soyadı</th>
                    <th>Tarih</th>
                    <th>Durum</th>
                    <th>Gönderim Şekli</th>
                    <th>Nereye Gönderilecek</th>
                    <th>Gönderilecek Şube</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_POST['update_durum'])) {
                    $id = $_POST['id'];
                    $durum = $_POST['durum'];
                    $update_sorgu = "UPDATE kargoekle SET durum = '$durum' WHERE id = $id";

                    if ($baglan->query($update_sorgu)) {
                        echo "<script>alert('Durum başarıyla güncellendi!'); window.location.href='tablo.php';</script>";
                    } else {
                        echo "<script>alert('Durum güncellenirken hata oluştu.');</script>";
                    }
                }

                $tarih_filtre = isset($_GET['tarih']) ? $_GET['tarih'] : date('Y-m-d');

                $sec = "
                    SELECT k.*, a.aliciAdi, a.aliciTelefon, s.sube_adi, g.gondericiAdi 
                    FROM kargoekle k
                    LEFT JOIN alici a ON k.alici_id = a.alici_id 
                    LEFT JOIN sube s ON k.sube_id = s.id 
                    LEFT JOIN gonderici g ON k.gonderici_id = g.gonderici_id
                    WHERE DATE(k.tarih) = '$tarih_filtre'
                ";
                $sonuc = $baglan->query($sec);

                if ($sonuc->num_rows > 0) {
                    while ($cek = $sonuc->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>".$cek['kargoKodu']."</td>
                            <td>".$cek['urunadi']."</td>
                            <td>".$cek['adet']."</td>
                            <td>".$cek['kilo']."</td>
                            <td>".$cek['aliciAdi']."</td>
                            <td>".$cek['aliciTelefon']."</td>
                            <td>".$cek['gondericiAdi']."</td>
                            <td>".$cek['tarih']."</td>
                            <td>".$cek['durum']."</td>
                            <td>".$cek['gonderimSekli']."</td>
                            <td>".$cek['gonderilecekYer']."</td>
                            <td>" . (isset($cek['sube_adi']) ? $cek['sube_adi'] : 'Bilinmiyor') . "</td>
                            <td>
                                <div style='display: flex; flex-direction: column; align-items: center;'>
                                    <form class='edit-form' method='POST'>
                                        <input type='hidden' name='id' value='".$cek['id']."'>
                                        <select name='durum'>
                                            <option value='Hazırlanıyor' ".($cek['durum'] == 'Hazırlanıyor' ? 'selected' : '').">Hazırlanıyor</option>
                                            <option value='Transfer Aşamasında' ".($cek['durum'] == 'Transfer Aşamasında' ? 'selected' : '').">Transfer Aşamasında</option>
                                            <option value='Dağıtım Şubesinde' ".($cek['durum'] == 'Dağıtım Şubesinde' ? 'selected' : '').">Dağıtım Şubesinde</option>
                                            <option value='Dağıtıma Çıkarıldı' ".($cek['durum'] == 'Dağıtıma Çıkarıldı' ? 'selected' : '').">Dağıtıma Çıkarıldı</option>
                                            <option value='Teslim Edildi' ".($cek['durum'] == 'Teslim Edildi' ? 'selected' : '').">Teslim Edildi</option>
                                        </select>
                                        <button type='submit' name='update_durum'>Güncelle</button>
                                    </form>
                                    <a href='?sil_id=".$cek['id']."' class='delete-button' onclick=\"return confirm('Bu kaydı silmek istediğinize emin misiniz?')\">Sil</a>
                                </div>
                            </td>
                        </tr>
                        ";
                    }
                } else {
                    echo "<tr><td colspan='13'>Bu tarihe ait veri bulunmamaktadır.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
