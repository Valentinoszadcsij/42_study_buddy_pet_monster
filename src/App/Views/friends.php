<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Friends | 42Buddy</title>
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/game.css">
  <link rel="stylesheet" href="/css/friends.css">
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>

<body class="bg-secondary">
  <nav class="navbar">
    <div class="nav-buttons">
      <button onclick="window.location.href='/home'">42Buddy</button>
      <button onclick="window.location.href='/pairup'">PairUp</button>
      <button class="active" onclick="window.location.href='/friends'">Friends</button>
      <button onclick="window.location.href='#'">Store</button>
      <button onclick="window.location.href='#'">Inventory</button>
    </div>
  </nav>

  <main class="friends-container">
    <h1>Friends Network</h1>

    <!-- 🔹 Online Friends -->
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

    <!-- 🔹 Friend Requests -->
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

    <!-- 🔹 Activity Feed -->
    <section class="friends-section">
      <h2>Activity Feed</h2>
      <div class="activity-feed">
        <p>&gt; mrazem finished minishell</p>
        <p>&gt; vpushkar reached Level 4!</p>
        <p>&gt; voszadcs found a segmentation fault and survived</p>
      </div>
    </section>

    <!-- 🔹 Add Friend -->
    <section class="friends-section">
      <h2>➕ Add Friend</h2>
      <button class="btn btn-primary" onclick="openAddFriendModal()">Add New Buddy</button>
    </section>
  </main>

  <!-- 🔹 Add Friend Modal -->
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
