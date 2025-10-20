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
                <div class="lvl-text">EXP: 50%</div>
                <svg class="expbar" xmlns="http://www.w3.org/2000/svg" viewBox="0 -0.5 38 9" shape-rendering="crispEdges">
                    <path stroke="#222034" d="M2 0h34M1 1h1M36 1h1M0 2h1M3 2h32M37 2h1M0 3h1M2 3h1M35 3h1M37 3h1M0 4h1M2 4h1M35 4h1M37 4h1M0 5h1M2 5h1M35 5h1M37 5h1M0 6h1M3 6h32M37 6h1M1 7h1M36 7h1M2 8h34" />
                    <path stroke="#ffffff" d="M2 1h34" />
                    <path stroke="#f2f2f5" d="M1 2h2M35 2h2M1 3h1M36 3h1M1 4h1M36 4h1M1 5h1M36 5h1M1 6h2M35 6h2M2 7h34" />
                    <path stroke="#323c39" d="M3 3h32" />
                    <path stroke="#494d4c" d="M3 4h32M3 5h32" />
                    <svg x="3" y="2.5" width="32" height="3">
                        <rect class="expbar_fill" height="3" />
                        <rect class="expbar_fill expbar_fill-top" height="1" />
                    </svg>
                </svg>
            </div>
            <div class="character-section">
                <canvas id="characterCanvas" width="256" height="256"></canvas>
                            <div class="hp-container">
                <div class="hp-text">HP: 100%</div>
                <svg class="healthbar" xmlns="http://www.w3.org/2000/svg" viewBox="0 -0.5 38 9" shape-rendering="crispEdges">
                    <path stroke="#222034" d="M2 0h34M1 1h1M36 1h1M0 2h1M3 2h32M37 2h1M0 3h1M2 3h1M35 3h1M37 3h1M0 4h1M2 4h1M35 4h1M37 4h1M0 5h1M2 5h1M35 5h1M37 5h1M0 6h1M3 6h32M37 6h1M1 7h1M36 7h1M2 8h34" />
                    <path stroke="#ffffff" d="M2 1h34" />
                    <path stroke="#f2f2f5" d="M1 2h2M35 2h2M1 3h1M36 3h1M1 4h1M36 4h1M1 5h1M36 5h1M1 6h2M35 6h2M2 7h34" />
                    <path stroke="#323c39" d="M3 3h32" />
                    <path stroke="#494d4c" d="M3 4h32M3 5h32" />
                    <svg x="3" y="2.5" width="32" height="3">
                        <rect class="healthbar_fill" height="3" />
                        <rect class="healthbar_fill healthbar_fill-top" height="1" />
                    </svg>
                </svg>
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
    <script src="/js/healthbar.js"></script>
    <script src="/js/expbar.js"></script>
</body>
</html>
