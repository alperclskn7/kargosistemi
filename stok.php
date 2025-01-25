<?php
include("baglanti.php");


ini_set('display_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['sil_malzeme_id'])) {
    $sil_id = $_POST['sil_malzeme_id'];
    $sil = "DELETE FROM malzeme WHERE id = '$sil_id'";
    if ($baglan->query($sil) === TRUE) {
        echo "<script>alert('Malzeme başarıyla silindi!');</script>";
    } else {
        echo "Hata: " . $baglan->error;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["malzeme_turu"], $_POST["malzeme_sayisi"])) {
        $malz_tur = $_POST["malzeme_turu"];
        $malz_say = $_POST["malzeme_sayisi"];
        
        
        $ekle = "INSERT INTO malzeme (malzeme_turu, malzeme_sayisi) 
                 VALUES ('$malz_tur', '$malz_say')";
        
        if ($baglan->query($ekle) === TRUE) {
            echo "<script>alert('Malzeme başarıyla eklendi!');</script>";
        } else {
            echo "Hata: " . $baglan->error;
        }
    }

    
    if (isset($_POST["guncelle_malzeme_id"], $_POST["guncelle_malzeme_sayisi"])) {
        $malzeme_id = $_POST["guncelle_malzeme_id"];
        $yeni_sayi = $_POST["guncelle_malzeme_sayisi"];
        
        
        $guncelle = "UPDATE malzeme SET malzeme_sayisi = '$yeni_sayi' WHERE id = '$malzeme_id'";
        
        if ($baglan->query($guncelle) === TRUE) {
            echo "<script>alert('Malzeme sayısı başarıyla güncellendi!');</script>";
        } else {
            echo "Hata: " . $baglan->error;
        }
    }
}


$sec = "SELECT * FROM malzeme";
$sonuc = $baglan->query($sec);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kolya Kargo Malzeme Stok Takibi</title>
    <script src="https://kit.fontawesome.com/22ffbb5dc2.js" crossorigin="anonymous"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background-image: url('Ekran görüntüsü 2024-11-07 174912.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            overflow-x: hidden;
        }
        .container {
            width: 100%;
            max-width: 700px;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        h1 {
            color: #353434;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }
        select, input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }
        button {
            background-color: #28a745;
            color: #fff;
            padding: 8px 12px;
            font-size: 0.8em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-bottom: 10px;
        }
        button:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
            font-size: 0.9em;
        }
        th {
            background-color: #f8f8f8;
            color: #333;
        }
        td {
            background-color: #ffffff;
        }
        .logout-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
            color: #007bff;
        }
        .logout-icon:hover {
            color: #0056b3;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: space-between;
        }
        .action-buttons .delete {
            background-color: #dc3545; 
            color: #fff;
        }
        .action-buttons .delete:hover {
            background-color: #c82333; 
        }
        .action-buttons .edit {
            background-color: #28a745; 
            color: #fff;
        }
        .action-buttons .edit:hover {
            background-color: #218838; 
        }
        .update-form {
            display: none; 
            margin-top: 10px;
        }
        .update-form button {
            background-color: #007bff;
            color: #fff;
            padding: 8px 12px;
            font-size: 0.8em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .update-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <a href="admin.php">
        <i class="fa-solid fa-right-from-bracket logout-icon"></i>
    </a>
    <div class="container">
        <h1>Kolya Kargo Malzeme Stok Takibi</h1>
        
        <form method="POST">
            <div class="form-group">
                <label>Malzeme Türü</label>
                <select name="malzeme_turu" required>
                    <option value=" Bant">Bant</option>
                    <option value="Koli">Koli</option>
                    <option value="Boardmarker">Boardmarker</option>
                    <option value="Streç">Streç</option>
                    <option value="Etiket">Etiket</option>
                </select>
            </div>
            <div class="form-group">
                <label>Malzeme Sayısı</label>
                <input type="number" name="malzeme_sayisi" min="1" required>
            </div>
            <button type="submit">Malzeme Ekle</button>
        </form>

        
        <h2>Malzemeler Listesi</h2>
        <table>
            <thead>
                <tr>
                    <th>Malzeme Türü</th>
                    <th>Malzeme Sayısı</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($sonuc->num_rows > 0) {
                    while ($cek = $sonuc->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>".$cek['malzeme_turu']."</td>
                            <td>".$cek['malzeme_sayisi']."</td>
                            <td>
                                <form method='POST' style='display:block;'>
                                    <div class='action-buttons'>
                                        <button type='submit' name='sil_malzeme_id' value='".$cek['id']."' class='delete'>Sil</button>
                                        <button type='button' class='edit' onclick='showEditForm(".$cek['id'].", ".$cek['malzeme_sayisi'].")'>Düzenle</button>
                                    </div>
                                </form>
                                <form id='updateForm_".$cek['id']."' class='update-form' method='POST'>
                                    <input type='hidden' name='guncelle_malzeme_id' value='".$cek['id']."'>
                                    <input type='number' name='guncelle_malzeme_sayisi' min='1' value='".$cek['malzeme_sayisi']."' required>
                                    <button type='submit'>Güncelle</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Henüz malzeme eklenmedi.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function showEditForm(id, sayi) {
            var form = document.getElementById("updateForm_" + id);
            form.style.display = "block"; 
            var editButton = form.previousElementSibling.querySelector(".edit");
            editButton.style.display = "none"; 
        }
    </script>
</body>
</html>
