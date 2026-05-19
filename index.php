<?php
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
session_start();
if (isset($_POST['login']) || isset($_POST['register'])) {
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $_POST['username'] ?? 'TEMP_USER'; 
    $_SESSION['role'] = 'temp'; 
    header("Location: dahboard.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STATIC. - Cinema Glass Flip</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            /* Menggunakan background yang lebih terang sedikit agar efek glass terlihat kontras */
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)), 
                        url('https://images.pexels.com/photos/7991579/pexels-photo-7991579.jpeg?auto=compress&cs=tinysrgb&w=1920');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            perspective: 1500px; /* Memberi kedalaman 3D saat flip */
            margin: 0;
        }

        /* Container Kartu */
        .flip-card {
            width: 420px;
            height: 580px;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .is-flipped {
            transform: rotateY(180deg);
        }

        /* Efek Glassmorphism pada Sisi Kartu */
        .card-face {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            /* Glassmorphism Utama */
            background: rgba(255, 255, 255, 0.07); 
            backdrop-filter: blur(25px) saturate(180%);
            -webkit-backdrop-filter: blur(25px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 3rem;
            display: flex;
            flex-direction: column;
            padding: 3rem;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.8);
        }

        .card-face-back {
            transform: rotateY(180deg);
        }

        /* Header Glow */
        .glow-text {
            text-shadow: 0 0 15px rgba(219, 39, 119, 0.5);
        }

        /* Input Styling */
        input {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            padding: 14px 18px;
            margin: 10px 0;
            width: 100%;
            border-radius: 18px;
            font-size: 13px;
            transition: all 0.3s ease;
        }

        input:focus {
            background: rgba(255, 255, 255, 0.12) !important;
            border-color: #db2777 !important;
            box-shadow: 0 0 20px rgba(219, 39, 119, 0.2);
            outline: none;
        }

        /* Tombol Utama */
        .btn-glass {
            background: #db2777;
            color: white;
            font-size: 11px;
            font-weight: 800;
            padding: 16px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 1.5rem;
            transition: all 0.4s;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-glass:hover {
            background: #be185d;
            box-shadow: 0 0 30px rgba(219, 39, 119, 0.4);
            transform: translateY(-2px);
        }

        /* Switch Link */
        .switch-text {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 2px;
            margin-top: 2.5rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .switch-text span { color: #db2777; transition: 0.3s; }
        .switch-text:hover span { color: #f472b6; text-shadow: 0 0 10px rgba(219, 39, 119, 0.5); }
    </style>
</head>
<body>

    <div class="flip-card" id="flipContainer">
        
        <div class="card-face card-face-front items-center justify-center text-center">
            <div class="mb-10">
                <h1 class="text-4xl font-black italic tracking-tighter glow-text">STA<span class="text-pink-600">TIC.</span></h1>
                <div class="h-1 w-10 bg-pink-600 mx-auto mt-2 rounded-full"></div>
            </div>
            
            <form action="" method="POST" class="w-full space-y-2">
                <div class="relative">
                    <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 text-pink-600 text-xs"></i>
                    <input type="text" name="username" placeholder="USERNAME" class="pl-14" required>
                </div>
                <div class="relative">
                    <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-pink-600 text-xs"></i>
                    <input type="password" name="password" placeholder="PASSWORD" class="pl-14" required>
                </div>
                <button type="submit" name="login" class="btn-glass w-full">Sign In</button>
            </form>

            <div class="switch-text" onclick="flipIt()">
                Don't have an account? <span>Register</span>
            </div>
        </div>

        <div class="card-face card-face-back items-center justify-center text-center">
            <div class="mb-8">
                <h1 class="text-3xl font-black italic tracking-tighter glow-text">SIGN <span class="text-pink-600">UP</span></h1>
                <p class="text-[9px] text-gray-500 tracking-[0.3em] font-bold mt-1 uppercase">Hello You!</p>
            </div>
            
            <form action="" method="POST" class="w-full space-y-1">
                <input type="text" name="username" placeholder="USERNAME" required>
                <input type="email" name="email" placeholder="EMAIL ADDRESS" required>
                <input type="password" name="password" placeholder="PASSWORD" required>
                <button type="submit" name="register" class="btn-glass w-full">Create Account</button>
            </form>

            <div class="switch-text" onclick="flipIt()">
                Already Have Account? <span>Login</span>
            </div>
        </div>

    </div>

    <script>
        function flipIt() {
            document.getElementById('flipContainer').classList.toggle('is-flipped');
        }
    </script>

</body>
</html>