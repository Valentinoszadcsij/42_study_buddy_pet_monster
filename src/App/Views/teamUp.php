<?php
// === Utility: Adjust brightness for coalition color ===
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
  <title>42Mochi | TeamUp - <?= htmlspecialchars($displayname ?? 'Guest') ?></title>

  <!-- Styles -->
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/game.css">
  <link rel="stylesheet" href="/css/teamup.css">
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
      <button class="active" onclick="window.location.href='/teamup'">TeamUp</button>
      <button onclick="window.location.href='/friends'">Friends</button>
    </div>
  </nav>

  <main class="content-box">
    <h1>TeamUp</h1>

    <!-- 🔹 Find a Partner -->
    <section>
      <h2>Find a Partner</h2>

      <div class="card post" onclick="openViewModal('Minishell','JohnDoe','Looking for a partner with solid heredoc & signals handling. Bonus if you’ve done parsing!')">
        <div class="card-title"><strong>Minishell</strong></div>
        <div class="card-meta">👤 JohnDoe</div>
        <div class="card-summary">Looking for a partner — must know signals & heredoc handling.</div>
      </div>

      <div class="card post" onclick="openViewModal('MiniRT','Jane42','Seeking someone experienced with MLX, vector math, and raycasting basics.')">
        <div class="card-title"><strong>MiniRT</strong></div>
        <div class="card-meta">👤 Jane42</div>
        <div class="card-summary">Need teammate for MLX + camera work.</div>
      </div>

      <div class="card post" onclick="openViewModal('Philosophers','MarkR','Looking for someone to help debug race conditions and deadlocks in philosophers.')">
        <div class="card-title"><strong>Philosophers</strong></div>
        <div class="card-meta">👤 MarkR</div>
        <div class="card-summary">Need help debugging deadlocks & timing issues.</div>
      </div>
    </section>

    <!-- 🔹 My Open Posts -->
    <section>
      <h2>My Open Posts</h2>

      <div class="card post" onclick="openViewModal('Push_swap','Me','Need evaluator or tester for push_swap, focusing on edge cases and radix sort efficiency.')">
        <div class="card-title"><strong>Push_swap</strong></div>
        <div class="card-meta">👤 Me</div>
        <div class="card-summary">Need evaluator for push_swap.</div>
      </div>
    </section>

    <!-- 🔹 Create New Post -->
    <section>
      <h2>➕ Create a New Post</h2>
      <button class="btn btn-primary new-post-btn" onclick="openCreateModal()">+ New Post</button>
    </section>
  </main>

  <!-- 🔹 View Post Modal -->
  <div id="viewModalOverlay" class="modal-overlay" onclick="closeModal(event)">
    <div class="modal-base" id="viewModalBox">
      <h3 id="modalProject"></h3>
      <p><strong>Author:</strong> <span id="modalAuthor"></span></p>
      <p id="modalContent"></p>
      <button class="btn btn-secondary" onclick="closeModal()">Close</button>
    </div>
  </div>

  <!-- 🔹 Create Post Modal -->
  <div id="createModalOverlay" class="modal-overlay" onclick="closeModal(event)">
    <div class="modal-base new-post-modal" id="createModalBox" onclick="event.stopPropagation()">
      <h3>Create a New Post</h3>
      <form onsubmit="submitPost(event)">
        <label for="projectName">Project Name:</label>
        <input type="text" id="projectName" placeholder="e.g. Minishell" required>

        <label for="projectSummary">Short Summary:</label>
        <input type="text" id="projectSummary" placeholder="1-line summary" required>

        <label for="projectDetails">Details:</label>
        <textarea id="projectDetails" rows="5" placeholder="Describe your project or what kind of partner you’re looking for..." required></textarea>

        <div class="modal-buttons">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <script src="/js/teamup.js"></script>
</body>
</html>
