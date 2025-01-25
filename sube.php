<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şubeler - Aylık Analiz</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/22ffbb5dc2.js" crossorigin="anonymous"></script>
    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        color: #333;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        transition: background-color 0.3s ease;
    }

    header h1 {
        text-align: center;
        font-size: 48px;
        color: #808080;
        margin-bottom: 20px;
        font-weight: bold;
        animation: fadeIn 1s ease-out;
    }

    .form-container {
        margin-bottom: 20px;
    }

    .form-container form {
        display: flex;
        gap: 10px;
        align-items: center;
        animation: fadeIn 1s ease-out;
    }

    .form-container button {
        padding: 10px 20px;
        background-color: #242d74;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    .form-container button:hover {
        background-color: #0056b3;
        transform: scale(1.1);
    }

    .grafik-container {
        width: 70%;
        max-width: 600px;
        margin: 20px 0;
        opacity: 0;
        animation: fadeInUp 1s forwards;
    }

    table {
        border-collapse: collapse;
        width: 80%;
        margin: 20px auto;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    th {
        background-color: #242d74;
        color: white;
    }

    td:hover {
        background-color: #f1f1f1;
        cursor: pointer;
    }

    .logout-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 24px;
        color: #007bff;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .logout-icon:hover {
        color: #0056b3;
    }

    
    @keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>

<body>
    <a href="admin.php">
        <i class="fa-solid fa-right-from-bracket logout-icon"></i>
    </a>
    <header>
        <h1>Şubeler - Aylık Kargo Analizi</h1>
    </header>

    
    <div class="form-container">
        <form method="GET" action="">
            <label for="ay">Ay Seçin:</label>
            <input type="month" id="ay" name="ay" required>
            <button type="submit">Filtrele</button>
        </form>
    </div>

    
    <div class="grafik-container">
        <canvas id="kargoGrafik"></canvas>
    </div>

    
    <table>
        <thead>
            <tr>
                <th>Şube</th>
                <th>Kargo Sayısı</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include("baglanti.php");

            
            $kosul = "";
            if (isset($_GET['ay']) && !empty($_GET['ay'])) {
                $ay = $_GET['ay'];
                
                $yil = substr($ay, 0, 4);
                $ay = substr($ay, 5, 2);
                $kosul = "WHERE MONTH(tarih) = '$ay' AND YEAR(tarih) = '$yil'";
            }

            
            $sorgu = "
                SELECT sube.sube_adi, COUNT(kargoekle.id) AS kargo_sayisi
                FROM kargoekle
                INNER JOIN sube ON kargoekle.sube_id = sube.id
                $kosul
                GROUP BY sube.sube_adi
            ";
            $sonuc = $baglan->query($sorgu);

            $grafikVerisi = [];
            if ($sonuc->num_rows > 0) {
                
                while ($satir = $sonuc->fetch_assoc()) {
                    echo "<tr><td>{$satir['sube_adi']}</td><td>{$satir['kargo_sayisi']}</td></tr>";
                    $grafikVerisi[] = $satir;
                }
            } else {
                echo "<tr><td colspan='2'>Veri bulunamadı</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        
        <?php
        echo "const kargoData = " . json_encode($grafikVerisi) . ";";
        ?>

        
        const labels = kargoData.map(item => item.sube_adi);
        const kargoSayilari = kargoData.map(item => item.kargo_sayisi);

        
        const ctx = document.getElementById('kargoGrafik').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Kargo Sayısı',
                    data: kargoSayilari,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(54, 162, 235, 0.6)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,  
                            callback: function(value) {  
                                return value % 1 === 0 ? value : ''; 
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
