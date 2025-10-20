<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>42Mochi</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/game.css">
</head>
<body class="bg-secondary">
    <nav class="navbar bg-primary bord-primary">
        <div class="navbar-left">42Mochi</div>
        <div class="navbar-center"></div>
        <div class="navbar-right">
            <form method="POST" action="/Auth/logout">
                <button type="submit" class="icon-btn logout" aria-label="Log out"></button>
            </form>
        </div>
    </nav>

    <main class="game-container">
        <div class="stats-section">
            <div class="intraname"><?php echo $_SESSION['user_email'] ?? 'Intraname'; ?></div>
            <div class="stat-buttons">
                <button class="exp-btn">Exp</button>
                <button class="lvl-btn">Lvl</button>
            </div>
        </div>

        <div class="character-section">
            <canvas id="characterCanvas" width="200" height="200"></canvas>
            <div class="exp-bar">
                <div class="exp-progress"></div>
            </div>
        </div>

        <div class="inventory-section">
            <div class="food-clothes">Food/Clothes</div>
            <div class="inventory">Inventory</div>
        </div>

        <div class="coins">
            <span class="coin-icon">🪙</span>
            <span class="coin-amount">0</span>
        </div>
    </main>
    <script src="/js/character.js"></script>
</body>
</html>
