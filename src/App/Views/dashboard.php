<!DOCTYPE html>
<html>
<head>
    <title>Study Buddy Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f8f8; color: #333; margin: 20px; }
        .profile, .panel { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .coalition { background: <?= htmlspecialchars($color) ?>; color: #fff; padding: 5px 10px; border-radius: 5px; display: inline-block; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border-bottom: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #eee; }
        button { margin: 5px; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; }
        button:hover { opacity: 0.85; }
        .feed { background: #4CAF50; color: white; }
        .snack { background: #8bc34a; color: white; }
        .work { background: #2196F3; color: white; }
        .buy { background: #ff9800; color: white; }
        .level { background: #9c27b0; color: white; }
        .tick { background: #607d8b; color: white; }
        .day { background: #3f51b5; color: white; }
        .refresh { background: #00bcd4; color: white; }
        .earn { background: #795548; color: white; }
        .statbar { height: 15px; border-radius: 5px; background: #ddd; overflow: hidden; }
        .bar { height: 15px; border-radius: 5px; }
        .bar.hp { background: #e91e63; }
        .bar.hunger { background: #4caf50; }
    </style>
</head>
<body>

<div class="profile">
    <h1>Hello, <?= htmlspecialchars($displayname) ?> (<?= htmlspecialchars($login) ?>)</h1>
    <p><strong>Campus:</strong> <?= htmlspecialchars($campus) ?></p>
    <p><strong>Coalition:</strong> <span class="coalition"><?= htmlspecialchars($coalition) ?></span></p>
    <p><strong>XP Level:</strong> <?= htmlspecialchars($level) ?></p>
    <p><strong>First login:</strong> <?= htmlspecialchars($first_login_date) ?></p>
    <form method="POST" style="margin-top:10px;">
        <button name="refresh_data" class="refresh">Refresh 42 Data</button>
    </form>
</div>

<div class="panel">
    <h2>Player Summary</h2>
    <table border="1" cellpadding="8" style="border-collapse:collapse; width:100%;">
        <tr style="background:#eee;">
            <th>First</th><th>Last</th><th>Intra</th><th>Curriculum Lv</th>
            <th>Monster Lv</th><th>HP</th><th>Hunger</th><th>Food</th><th>Coins</th>
        </tr>
        <tr>
            <td><?= htmlspecialchars($first_name) ?></td>
            <td><?= htmlspecialchars($last_name) ?></td>
            <td><?= htmlspecialchars($login) ?></td>
            <td><?= htmlspecialchars($level) ?></td>
            <td><?= htmlspecialchars($monster_level) ?></td>
            <td><?= htmlspecialchars($monster_hp) ?>/100<div class="statbar"><div class="bar hp" style="width: <?= $monster_hp ?>%;"></div></div></td>
            <td><?= htmlspecialchars($hunger) ?>/100<div class="statbar"><div class="bar hunger" style="width: <?= $hunger ?>%;"></div></div></td>
            <td><?= htmlspecialchars($food) ?></td>
            <td><?= htmlspecialchars($total_coins) ?></td>
        </tr>
    </table>
</div>

<div class="panel">
    <h2>Monster Control Panel</h2>
    <form method="POST">
        <button name="tick" class="tick">Tick (–5 Hunger, –5 HP if starving)</button>
        <button name="simulate_day" class="day">🌞 Simulate Day (–20 Hunger, –10 HP if <30)</button><br>
        <button name="feed" class="feed" <?= $food <= 0 ? 'disabled' : '' ?>>Feed</button>
        <button name="snack" class="snack">Snack</button>
        <button name="work" class="work">Work (+50 Coins)</button>
        <button name="buy_food" class="buy" <?= $total_coins < 30 ? 'disabled' : '' ?>>Buy Food</button>
        <button name="level_up" class="level" <?= ($monster_hp < 100 || $hunger < 50) ? 'disabled' : '' ?>>Level Up</button>
    </form>
</div>

<div class="panel">
    <h2>Coin Earning Actions</h2>
    <form method="POST">
        <button name="earn_project" class="earn">Complete Project (+50)</button>
        <button name="earn_evaluation" class="earn">Do Evaluation (+20)</button>
        <button name="earn_streak" class="earn">Daily Streak (+50)</button>
        <button name="earn_milestone" class="earn">Milestone (+200)</button>
    </form>
</div>

<div class="panel">
    <h2>Coin Transaction Log (last <?= count($coin_log) ?>)</h2>
    <table>
        <tr><th>Time</th><th>Action</th><th>Δ Coins</th></tr>
        <?php foreach ($coin_log as $entry): ?>
            <tr>
                <td><?= htmlspecialchars($entry['time']) ?></td>
                <td><?= htmlspecialchars($entry['desc']) ?></td>
                <td style="color:<?= $entry['delta'] >= 0 ? 'green' : 'red' ?>;">
                    <?= $entry['delta'] >= 0 ? '+' : '' ?><?= htmlspecialchars($entry['delta']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>