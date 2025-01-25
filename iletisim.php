<?php

include("baglanti.php");


ini_set('display_errors', 1);
error_reporting(E_ALL);


if (isset($_GET['sil_id'])) {
    $sil_id = $_GET['sil_id'];
    $sil_sorgu = "DELETE FROM iletisim WHERE id = $sil_id";
    if ($baglan->query($sil_sorgu)) {
        echo "<script>alert('Mesaj başarıyla silindi!');</script>";
    } else {
        echo "<script>alert('Silme işlemi sırasında hata oluştu.');</script>";
    }
}


$sec = "SELECT * FROM iletisim ORDER BY olusturulma_tarihi DESC";
$sonuc = $baglan->query($sec);


if (!$sonuc) {
    echo "Sorgu hatası: " . $baglan->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim Tablosu</title>
    

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        
        .header {
            background-color: #242d74;
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h2 {
            margin: 0;
            font-size: 24px;
        }

        .logout-btn {
            font-size: 16px;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #242d74;
            border-radius: 4px;
            border: none;
        }

        .logout-btn:hover {
            background-color: #242d74;
        }

        /* Tablo Düzeni */
        table {
            width: 95%;
            margin: 20px auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-collapse: collapse;
        }

        th, td {
            padding: 16px 20px;
            text-align: left;
            border-bottom: 1px solid #ccc; 
            word-wrap: break-word; 
            word-break: break-word;
        }

        th {
            background-color: #242d74;
            color: white;
            font-weight: 600;
            border-right: 1px solid #ccc; 
        }

        td {
            max-width: 250px; 
            overflow: hidden;
            text-overflow: ellipsis; 
        }

        td, th {
            border-right: 1px solid #ccc; 
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        /* Silme Butonu */
        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

    </style>
</head>
<body>


<div class="header">
    <h2>İletişim Verileri Tablosu</h2>
    <a href="admin.php" class="logout-btn"><i class="fas fa-right-from-bracket"></i> Çıkış</a>
</div>

<table>
    <thead>
        <tr>
            <th>Ad Soyad</th>
            <th>Mail Adresi</th>
            <th>Telefon Numarası</th>
            <th>Konu Başlığı</th>
            <th>Mesaj</th>
            <th>Oluşturulma Tarihi</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($sonuc && $sonuc->num_rows > 0) {
            while ($cek = $sonuc->fetch_assoc()) {
                echo "
                <tr>
                    <td>".$cek['ad_soyad']."</td>
                    <td>".$cek['mail_adres']."</td>
                    <td>".$cek['telefon_no']."</td>
                    <td>".$cek['konu']."</td>
                    <td>".$cek['mesaj']."</td>
                    <td>".$cek['olusturulma_tarihi']."</td>
                    <td>
                        <a href='?sil_id=".$cek['id']."'><button class='delete-button'>Sil</button></a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Veritabanında kayıtlı hiçbir veri bulunamadı.</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>