<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link rel="stylesheet" href="/css/game.css">
</head>
<body>
    <div class="game-container">
        <header>
            <h1>WELCOME TO MY PAGE!</h1>
            <a href="{{ route('products.index') }}">Lihat Data</a>
        </header>

        <main>
            <div class="answer-box" id="answer-box">
                <h2 id="message">CLICK 'OPEN' TO REVEAL</h2>
                <h2 id="nama">Muhammad Raufa Hafid Widodo</h2>
            </div>
            <button class="yay-btn" id="buka-btn" onclick="tampilkanNama()">OPEN</button>
            <button id="tutup-btn" onclick="sembunyikanNama()">CLOSE</button>
        </main>

        <footer>
            <div class="hearts">🔥🏰🔥🏰🔥</div>
        </footer>
    </div>

    <script>
        function tampilkanNama() {
            document.getElementById("message").style.display = "none"; 
            const nama = document.getElementById("nama");
            nama.classList.add("show"); 
            document.getElementById("buka-btn").style.display = "none"; 
            document.getElementById("tutup-btn").style.display = "inline-block"; 
        }

        function sembunyikanNama() {
            const nama = document.getElementById("nama");
            nama.classList.remove("show"); 
            setTimeout(() => {
                document.getElementById("message").style.display = "block";
                document.getElementById("buka-btn").style.display = "inline-block";
                document.getElementById("tutup-btn").style.display = "none";
            }, 500); 
        }
    </script>
</body>
</html>
