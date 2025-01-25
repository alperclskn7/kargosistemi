<?php
include("baglanti.php");


date_default_timezone_set('Europe/Istanbul');


$secilenYil = isset($_GET['yil']) ? $_GET['yil'] : date('Y');


$yillarSorgu = $baglan->query("SELECT DISTINCT YEAR(tarih) AS yil FROM masraf ORDER BY yil DESC");
$yillar = [];
while ($satir = $yillarSorgu->fetch_assoc()) {
    $yillar[] = $satir['yil'];
}


$sorgu = $baglan->prepare("
    SELECT 
        DATE_FORMAT(tarih, '%Y-%m') AS ay,
        SUM(masraf_tutari) AS toplam_masraf
    FROM masraf
    WHERE YEAR(tarih) = ?
    GROUP BY DATE_FORMAT(tarih, '%Y-%m')
    ORDER BY ay ASC
");
$sorgu->bind_param("i", $secilenYil);
$sorgu->execute();
$sonuc = $sorgu->get_result();


$aylar = [];
$masraflar = [];
while ($satir = $sonuc->fetch_assoc()) {
    $aylar[] = $satir['ay'];
    $masraflar[] = $satir['toplam_masraf'];
}


$maxMasraf = !empty($masraflar) ? max($masraflar) : 0;
$minMasraf = !empty($masraflar) ? min($masraflar) : 0;


if (empty($aylar) || empty($masraflar)) {
    echo "<p><strong>Veri bulunamadı. Lütfen başka bir yıl seçin.</strong></p>";
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aylık Masraf Analizi</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/22ffbb5dc2.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .filter-container {
            width: 90%;
            max-width: 1200px;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        .filter-container form select,
        .filter-container form button {
            padding: 10px 15px;
            margin-right: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .chart-container {
            width: 90%;
            max-width: 1200px;
            margin-bottom: 40px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .chart-container canvas {
            width: 100%;
            height: auto;
        }

        .table-container {
            width: 90%;
            max-width: 1200px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #242d74;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .logout-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: #007bff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <main>
        <div class="filter-container">
            <form method="GET" action="">
                <select name="yil" required>
                    <?php foreach ($yillar as $yil): ?>
                        <option value="<?php echo $yil; ?>" <?php if ($yil == $secilenYil) echo 'selected'; ?>>
                            <?php echo $yil; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Filtrele</button>
            </form>
        </div>

        <div class="chart-container">
            <canvas id="masrafGrafik"></canvas>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Ay</th>
                        <th>Toplam Masraf (₺)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($aylar) && !empty($masraflar)): ?>
                        <?php foreach ($aylar as $index => $ay): ?>
                            <tr>
                                <td><?php echo $ay; ?></td>
                                <td><?php echo number_format($masraflar[$index], 2, ',', '.'); ?> ₺</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="2">Veri bulunamadı.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <a href="masraf.php" class="logout-icon">
        <i class="fa-solid fa-right-from-bracket"></i>
    </a>

    <script>
        const aylar = <?php echo json_encode($aylar); ?>;
        const masraflar = <?php echo json_encode($masraflar); ?>;
        const maxMasraf = <?php echo $maxMasraf; ?>;
        const minMasraf = <?php echo $minMasraf; ?>;

        const renkler = masraflar.map(masraf => {
            if (maxMasraf === minMasraf) {
                return 'rgb(100, 150, 255)';
            }
            if (masraf === minMasraf) {
                return 'rgb(0, 255, 0)';
            }
            if (masraf === maxMasraf) {
                return 'rgb(255, 0, 0)';
            }
            const oran = (masraf - minMasraf) / (maxMasraf - minMasraf);
            const r = Math.floor(255 * oran);
            const g = Math.floor(255 * (1 - oran));
            const b = 150;
            return `rgb(${r}, ${g}, ${b})`;
        });

        const ctx = document.getElementById('masrafGrafik').getContext('2d');
        const masrafGrafik = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: aylar,
                datasets: [{
                    label: 'Aylık Masraf (₺)',
                    data: masraflar,
                    backgroundColor: renkler,
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Masraf (₺)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Aylar'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    </script>
</body>
</html>
