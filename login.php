<?php

$host = "localhost";
$db_name = "kargok";
$username = "root";  
$password = "";      


try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}


$error_message = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kullanici_adi = $_POST['username'];
    $sifre = $_POST['password'];

    
    if (empty($kullanici_adi) || empty($sifre)) {
        $error_message = "Kullanıcı adı veya şifre hatalı."; 
    } else {
        
        $query = "SELECT * FROM yönetim_paneli WHERE kullanici_adi = :username AND sifre = :password";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $kullanici_adi);
        $stmt->bindParam(':password', $sifre);
        
        
        $stmt->execute();

        
        if ($stmt->rowCount() > 0) {
            header("Location: admin.php");
            exit;
        } else {
            $error_message = "Kullanıcı adı veya şifre hatalı."; 
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/22ffbb5dc2.js" crossorigin="anonymous"></script>
    <title>Yönetici Paneli Giriş Ekranı</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: url('Ekran görüntüsü 2024-11-07 193708.png') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.9); 
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            animation: fadeIn 1s ease-out;
            position: relative;
            right: 0; 
            margin-left: 700px;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 26px;
            color: #333;
            letter-spacing: 1px;
        }

        .input-container {
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f3f3f3;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            background-color: #e6f0ff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-login {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 10px;
            width: 100%;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }

        .btn-login:hover {
            background-color: #0056b3;
            box-shadow: 0 5px 20px rgba(0, 123, 255, 0.5);
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

        /* Hata mesajı için stil */
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
            font-size: 16px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .login-container {
                width: 80%;
                padding: 30px;
            }

            h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <a href="index.php">
        <i class="fa-solid fa-right-from-bracket logout-icon"></i>
    </a>
    <div class="login-container">
        <h2>Giriş Ekranı</h2>
        <form action="login.php" method="post">
            <div class="input-container">
                <input type="text" name="username" placeholder="Kullanıcı adı" required>
            </div>
            <div class="input-container">
                <input type="password" name="password" placeholder="Parola" required>
            </div>
            
            <button type="submit" class="btn-login">Giriş</button>
        </form>
        
        <!-- Hata mesajı yalnızca giriş başarısız olduğunda görünür -->
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
