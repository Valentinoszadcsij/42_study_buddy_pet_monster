<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Camagru</title>
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/auth.css">
    </head>
    <body class="bg-secondary auth-page">
    <script>console.log(<?php echo json_encode($_SESSION); ?>);</script>   
        <nav class="navbar bg-primary bord-primary">
            <div class="navbar-left">LOGO</div>
            <div class="navbar-center">42Fans</div>
            <div class="navbar-right">
            <?php

            if($_SESSION['user_password'] !== "verified"): ?>                
                <a href="/Auth/">
                    <div class="icon-btn profile"></div>
                </a>
            <?php else: ?>
                <a href="/UserProfile">
                    <div class="icon-btn profile"></div>
                </a>                
                <form method="POST" action="/Auth/logout">
                     <button type="submit" class="icon-btn logout" aria-label="Log out"></button>
                </form>
            <?php endif; ?>                
            </div>
    </nav>
    <div class="auth-form">
        <?php if (!empty($_SESSION['error'])) : ?>
            <?php if ($_SESSION['error'] === "no_user") : ?>
            <p style="color:red;"><?php echo $_SESSION['user_email']; unset($_SESSION['error']); ?> doesn't exist!<br>Try again or <a href="/Auth/register">register</a></p>
            <?php else : ?>
            <p style="color:red;"><?php echo $_SESSION['error']; ?></p>
            <?php endif; ?>
        <?php endif; ?>
        <form method="POST" action="/auth">
            <input type="email" name="email" required><br>
            <button type="submit">Next</button>
        </form>    
        
    </div>
</body>
</html>