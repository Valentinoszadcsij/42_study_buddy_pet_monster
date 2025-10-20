<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>42Mochi</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/game.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body class="bg-secondary">
    <nav class="navbar">
        <div class="nav-buttons">
            <button>Event</button>
            <button>Friends</button>
            <button>Heilbronn 42</button>
        </div>
    </nav>

    <main class="game-container">
        <div class="left-side">
            <div class="ep-counter">
                E.P.: <span id="ep-value">100</span>
            </div>
        </div>

        <div class="center-content">
            <div class="intraname">vpushkar</div>
            <div class="lvl-container">
                <div class="lvl-text">LVL 4 (75%)</div>
                <div class="lvl-bar">
                    <progress class="progress-bar" value="75" max="100"></progress>
                </div>
            </div>
            <div class="character-section">
                <canvas id="characterCanvas" width="256" height="256"></canvas>
                <div class="hp-container">
                    <div class="hp-text">HP (85%)</div>
                    <div class="hp-bar">
                        <progress class="progress-bar" value="85" max="100"></progress>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-side">
            <button>Food</button>
            <button>Clothes</button>
            <button>Inventory</button>
        </div>

        <div class="coins">
            <span class="coin-icon">🪙</span>
            <span class="coin-amount">100</span>
        </div>
    </main>
    <script src="/js/character.js"></script>
</body>
</html>
