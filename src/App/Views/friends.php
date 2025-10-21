<?php
// === Utility: Brightness adjustment ===
function adjustBrightness($hex, $steps) {
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) !== 6) return '#888888';

    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));

    return sprintf("#%02x%02x%02x", $r, $g, $b);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>42Mochi | Friends - <?= htmlspecialchars($displayname ?? 'Guest') ?></title>

  <!-- Styles -->
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/game.css">
  <link rel="stylesheet" href="/css/friends.css">
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

  <!-- Coalition Color Theme -->
  <style>
    :root {
      --coalition-color: <?= htmlspecialchars($coalition_color ?? '#6abc3a') ?>;
      --coalition-color-light: <?= htmlspecialchars(adjustBrightness($coalition_color ?? '#6abc3a', 30)) ?>;
      --coalition-color-dark: <?= htmlspecialchars(adjustBrightness($coalition_color ?? '#6abc3a', -40)) ?>;
    }
  </style>
</head>

<body class="bg-secondary" data-coalition="<?= htmlspecialchars($coalition ?? 'None') ?>">
  <nav class="navbar">
    <div class="nav-buttons">
      <button onclick="window.location.href='/home'">42Mochi</button>
      <button onclick="window.location.href='/teamup'">TeamUp</button>
      <button class="active" onclick="window.location.href='/friends'">Friends</button>
    </div>
  </nav>

  <main class="friends-container">
    <h1>Friends Network</h1>

    <!-- 🟢 Online Friends -->
    <section class="friends-section">
      <h2>🟢 Online Friends</h2>
      <div class="friends-list">
        <div class="friend-card online">
          <span class="avatar">👾</span>
          <div class="friend-info">
            <strong>vpushkar</strong>
            <small>Lvl 9 • Coding Minishell</small>
          </div>
          <span class="status-dot green"></span>
        </div>

        <div class="friend-card offline">
          <span class="avatar">🐱</span>
          <div class="friend-info">
            <strong>mrazem</strong>
            <small>Lvl 6 • Offline</small>
          </div>
          <span class="status-dot red"></span>
        </div>

        <div class="friend-card coding">
          <span class="avatar">🤖</span>
          <div class="friend-info">
            <strong>voszadcs</strong>
            <small>Lvl 12 • Refactoring push_swap</small>
          </div>
          <span class="status-dot yellow"></span>
        </div>
      </div>
    </section>

    <!-- 🤝 Friend Requests -->
    <section class="friends-section">
      <h2>Friend Requests</h2>
      <div class="requests-list">
        <div class="request-card">
          <strong>friendat42</strong> sent you a request.
          <div class="request-buttons">
            <button class="btn accept">Accept</button>
            <button class="btn decline">Decline</button>
          </div>
        </div>
        <div class="request-card">
          You sent a request to <strong>catdev</strong> — pending.
        </div>
      </div>
    </section>

    <!-- 📰 Activity Feed -->
    <section class="friends-section">
      <h2>Activity Feed</h2>
      <div class="activity-feed">
        <p>&gt; mrazem finished minishell</p>
        <p>&gt; vpushkar reached Level 4!</p>
        <p>&gt; voszadcs found a segmentation fault and survived</p>
      </div>
    </section>

    <!-- ➕ Add Friend -->
    <section class="friends-section">
      <h2>➕ Add Friend</h2>
      <button class="btn btn-primary" onclick="openAddFriendModal()">Add New Buddy</button>
    </section>
  </main>

  <!-- ➕ Add Friend Modal -->
  <div id="addFriendModalOverlay" class="modal-overlay" onclick="closeModal(event)">
    <div class="modal-base add-friend-modal" onclick="event.stopPropagation()">
      <h3>Add a New Friend</h3>
      <form onsubmit="addFriend(event)">
        <input type="text" id="friendIntra" placeholder="Enter intraname..." required>
        <div class="modal-buttons">
          <button type="submit" class="btn btn-primary">Send Request</button>
          <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <script src="/js/friends.js"></script>
</body>
</html>
