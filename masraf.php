<?php
include("baglanti.php");


date_default_timezone_set('Europe/Istanbul');


ini_set('display_errors', 1);
error_reporting(E_ALL);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["tarih"], $_POST["masraf"], $_POST["masrafTutari"])) {
        $tarih = $_POST["tarih"];
        $masraf_adi = $_POST["masraf"];
        $masraf_tutari = $_POST["masrafTutari"];
        
        
        $ekle = "INSERT INTO masraf (masraf_adi, tarih, masraf_tutari) VALUES ('$masraf_adi', '$tarih', '$masraf_tutari')";
        
        if ($baglan->query($ekle) === TRUE) {
            echo "<script>alert('Masraf başarıyla eklendi!');</script>";
        } else {
            echo "Hata: " . $baglan->error;
        }
    }
}


if (isset($_GET['sil_id'])) {
    $sil_id = $_GET['sil_id'];
    $sil = "DELETE FROM masraf WHERE id = '$sil_id'";

    if ($baglan->query($sil) === TRUE) {
        echo "<script>alert('Masraf başarıyla silindi!');</script>";
    } else {
        echo "Hata: " . $baglan->error;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kolya Kargo Günlük Masraf Tablosu</title>
    <script src="https://kit.fontawesome.com/22ffbb5dc2.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            position: relative;
            background-image: url('Ekran görüntüsü 2024-11-07 173423.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        h1 {
            color: #4a4a4a;
        }

        .form-container, .table-container {
            width: 100%;
            max-width: 600px;
            margin: -15px 1px; 
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
        }

        .form-container label, 
        .form-container input, 
        .form-container button {
            width: 100%;
            display: block;
            margin-bottom: 10px;
        }

        .form-container input {
            padding: 10px;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 2px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #242d74;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        button {
            padding: 10px;
            background-color: #242d74;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 5px;
        }

        button:hover {
            background-color: #0056b3;
        }

        nav {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        nav i {
            font-size: 24px;
            color: #007bff;
            cursor: pointer;
        }

        nav i:hover {
            color: #0056b3;
        }

        .analyze-button {
            padding: 10px 20px;
            background-color: gray;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .analyze-button:hover {
            background-color: #242d74;
        }

        .delete-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545; 
            color: white;
            text-decoration: none; 
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
            cursor: pointer;
            border: none;
        }

        .delete-button:hover {
            background-color: #c82333; 
        }

        .delete-button:active {
            background-color: #b02a2a; 
        }
    </style>
</head>
<body>
    
    <nav>
        <a href="admin.php"><i class="fa-solid fa-right-from-bracket"></i></a>
    </nav>

    <h1>Kolya Kargo Masraf Tablosu</h1>

    
    <a href="analiz.php" class="analyze-button">Aylık Masraf Analizi</a>

    
    <div class="form-container">
        <form method="POST">
            <label for="tarih">Tarih:</label>
            <input type="date" id="tarih" name="tarih" value="<?php echo date('Y-m-d'); ?>" required>
            
            <label for="masraf">Masraf:</label>
            <input type="text" id="masraf" name="masraf" required>
            
            <label for="masrafTutari">Masraf Tutarı:</label>
            <input type="number" id="masrafTutari" name="masrafTutari" step="0.01" required>

            <button type="submit">Ekle</button>
        </form>
    </div>

    
    <div class="form-container">
        <form method="GET">
            <label for="filtreTarih">Tarih Filtrele:</label>
            <input type="date" id="filtreTarih" name="tarih" value="<?php echo isset($_GET['tarih']) ? $_GET['tarih'] : date('Y-m-d'); ?>" required>
            <button type="submit">Filtrele</button>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Tarih</th>
                    <th>Masraf</th>
                    <th>Masraf Tutarı</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                $tarih_filtre = isset($_GET['tarih']) ? $_GET['tarih'] : date('Y-m-d');
                $sec = "SELECT * FROM masraf WHERE DATE(tarih) = '$tarih_filtre'";
                $sonuc = $baglan->query($sec);
                
                if ($sonuc->num_rows > 0) {
                    while ($cek = $sonuc->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>".$cek['tarih']."</td>
                            <td>".$cek['masraf_adi']."</td>
                            <td>".$cek['masraf_tutari']."</td>
                            <td><a href='?sil_id=".$cek['id']."' class='delete-button' onclick='return confirm(\"Bu kaydı silmek istediğinizden emin misiniz?\");'>Sil</a></td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Bu tarihe ait masraf bulunamadı.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
