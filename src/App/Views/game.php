<?php
// Function to adjust color brightness
function adjustBrightness($hex, $steps) {
    // Remove # if present
    $hex = str_replace('#', '', $hex);

    // Convert to RGB
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    // Adjust brightness
    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));

    // Convert back to hex
    return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT)
              . str_pad(dechex($g), 2, '0', STR_PAD_LEFT)
              . str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>42Mochi - <?= htmlspecialchars($displayname ?? 'Guest') ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/game.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        :root {
            --coalition-color: <?= htmlspecialchars($coalition_color ?? '#6abc3a') ?>;
            --coalition-color-dark: <?= htmlspecialchars(adjustBrightness($coalition_color ?? '#6abc3a', -20)) ?>;
            --coalition-color-light: <?= htmlspecialchars(adjustBrightness($coalition_color ?? '#6abc3a', 30)) ?>;
        }
    </style>
</head>
<body class="bg-secondary" data-coalition="<?= htmlspecialchars($coalition ?? 'None') ?>">
    <nav class="navbar">
        <div class="nav-buttons">
		    <button>42Mochi</button>
            <button>Projects</button>
            <button>Friends</button>
            </div>
    </nav>

    <main class="game-container">
        <div class="left-side">
            <div class="ep-counter">
                </div>
        </div>

        <div class="center-content">
            <div class="intraname"><?= htmlspecialchars($displayname ?? 'Guest') ?></div>
            <div class="coalition-badge" style="background-color: var(--coalition-color);">
                <?= htmlspecialchars($coalition ?? 'No Coalition') ?>
            </div>
            <div class="character-section">
                <canvas id="characterCanvas" width="256" height="256" data-sprite-type="<?= htmlspecialchars($sprite_type ?? 'green') ?>"></canvas>
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
                <div class="days-container">
                    <div class="days-text">Days Alive: 0</div>
                </div>
                <div class="coins">
                    <div class="lvl-text">COINS: </div>
                    <span class="coin-icon">🪙</span>
                    <span class="coin-amount">100</span>
                </div>
            </div>
        </div>

        <div class="right-side">
            <button onclick="toggleModal('store')">Store</button>
            <button onclick="toggleModal('inventory')">Inventory</button>
        </div>

        <div id="store-modal" class="modal hidden">
            <div class="modal-content">
                <button class="modal-close" onclick="toggleModal('store')">&times;</button>
                <h2>Store</h2>
                <div class="store-tabs">
                    <button class="tab-button active" onclick="openTab('store-food')">Food</button>
                    <button class="tab-button" onclick="openTab('store-clothes')">Clothes</button>
                </div>
                <div id="store-food" class="tab-content active">
                    <div class="store-item" data-item="int_food" data-price="5">
                        <span class="item-icon">🥣</span>
                        <span class="item-name" title="A soup that causes integer overflow. Caution: May exceed 2,147,483,647 calories!">Int Soup</span>
                        <button class="buy-button">5 💰</button>
                    </div>
                    <div class="store-item" data-item="char_food" data-price="3">
                        <span class="item-icon">🍪</span>
                        <span class="item-name" title="Binary chocolate chips (01001000) baked in.">Char Cookies</span>
                        <button class="buy-button">3 💰</button>
                    </div>
                </div>
                <div id="store-clothes" class="tab-content">
                    <p>Clothes items will be listed here.</p>
                </div>
            </div>
        </div>

        <div id="inventory-modal" class="modal hidden">
            <div class="modal-content">
                <button class="modal-close" onclick="toggleModal('inventory')">&times;</button>
                <h2>Inventory</h2>
                <div class="inventory-grid">
                    <!-- Inventory items will be dynamically added here -->
                </div>
            </div>
        </div>
    </main>
    <script src="/js/character.js"></script>
    <script src="/js/healthbar.js"></script>
    <script src="/js/ui.js"></script>
    <script src="/js/mochi-state.js"></script>
 </body>
</html>
