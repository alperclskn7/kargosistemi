<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/22ffbb5dc2.js" crossorigin="anonymous"></script>
    <title>Kargo Takip Sistemi</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('Ekran görüntüsü 2024-11-07 175535.png') no-repeat center center fixed; 
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        
        .kargo-container {
            background-color: rgba(255, 255, 255, 0.8); 
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 100%;
            max-width: 600px;
            margin-right: -550px;
        }

        
        .kargo-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        
        .input-container {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-container input,
        .input-container select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        
        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }


        .durum-mesaji {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
        .logout-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            color: #007bff;
            cursor: pointer;
        }

        .logout-icon:hover {
            color: #0056b3;
        }

        
        .kargo-container {
            background-color: rgba(255, 255, 255, 0.8); 
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 100%;
            max-width: 600px;
            margin-right: -550px;
        }

        
        .kargo-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        
        .input-container {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-container input,
        .input-container select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        
        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        
        .durum-mesaji {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>

    <a href="index.php">
        <i class="fa-solid fa-right-from-bracket logout-icon"></i>
    </a>

    
    <div class="kargo-container">
        <h2>Kargo Takip Sistemi</h2>
        <form method="POST" action="">
            <div class="input-container">
                <label for="kargoKodu">Kargo Kodu</label>
                <input type="text" id="kargoKodu" name="kargoKodu" placeholder="Kargo Kodunuzu Girin" required>
            </div>
            <div class="input-container">
                <label for="gonderimSekli">Gönderim Şekli</label>
                <select id="gonderimSekli" name="gonderimSekli" required>
                    <option value="" disabled selected>Seçin</option>
                    <option value="ucak">Uçak</option>
                    <option value="gemi">Gemi</option>
                    <option value="tir">Tır</option>
                </select>
            </div>
            <button type="submit" class="btn-submit">Sorgula</button>
        </form>

        <div class="durum-mesaji">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "kargok";

                $conn = new mysqli($servername, $username, $password, $dbname);

                
                if ($conn->connect_error) {
                    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
                }

                
                $kargoKodu = trim($_POST['kargoKodu']);
                $gonderimSekli = trim($_POST['gonderimSekli']);

                
                $sql = "SELECT durum FROM kargoekle WHERE kargoKodu = ? AND gonderimSekli = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $kargoKodu, $gonderimSekli);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "Durum: " . htmlspecialchars($row['durum']);

                    
                    if ($gonderimSekli == "ucak") {
                        switch ($row['durum']) {
                            case "Hazırlanıyor":
                                echo "<br>Ortalama Teslim Süresi: 2-4 gün";
                                break;
                            case "Transfer Aşamasında":
                                echo "<br>Ortalama Teslim Süresi: 2 gün";
                                break;
                            case "Dağıtım Şubesinde":
                                echo "<br>Ortalama Teslim Süresi: 1 gün";
                                break;
                            case "Dağıtıma Çıkarıldı":
                                echo "<br>Tahmini Teslim: Bugün";
                                break;
                            case "Teslim Edildi":
                                    echo "<br>";
                                    break;
                            default:
                                echo "<br>Varış bilgisi mevcut değil.";
                        }
                    } elseif ($gonderimSekli == "gemi") {
                        switch ($row['durum']) {
                            case "Hazırlanıyor":
                                echo "<br>Ortalama Teslim Süresi: 2-3 hafta";
                                break;
                            case "Transfer Aşamasında":
                                echo "<br>Ortalama Teslim Süresi: 2 hafta";
                                break;
                            case "Dağıtım Şubesinde":
                                echo "<br>Ortalama Teslim Süresi: 1-2 gün";
                                break;
                            case "Dağıtıma Çıkarıldı":
                                echo "<br>Tahmini Teslim: Bugün";
                                break;
                            case "Teslim Edildi":
                                    echo "<br>";
                                    break;
                                default:
                                echo "<br>Varış bilgisi mevcut değil.";
                        }
                    } elseif ($gonderimSekli == "tir") {
                        switch ($row['durum']) {
                            case "Hazırlanıyor":
                                echo "<br>Ortalama Teslim Süresi: 5-7 gün";
                                break;
                            case "Transfer Aşamasında":
                                echo "<br>Ortalama Teslim Süresi: 5 gün";
                                break;
                            case "Dağıtım Şubesinde":
                                echo "<br>Ortalama Teslim Süresi: 1-2 gün";
                                break;
                            case "Dağıtıma Çıkarıldı":
                                echo "<br>Tahmini Teslim: Bugün";
                                break;
                            case "Teslim Edildi":
                                    echo "<br>";
                                    break;
                            default:
                                echo "<br>Varış bilgisi mevcut değil.";
                        }
                    }
                } else {
                    echo "Kargo bulunamadı. Lütfen bilgilerinizi kontrol edin.";
                }

                $stmt->close();
                $conn->close();
            }
            ?>
        </div>
    </div>
</body>
</html>
