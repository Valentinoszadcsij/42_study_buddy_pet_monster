<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
    <body class="bg-secondary txt-primary">
        <div class="grid-layout">
            <nav class="navbar bg-primary bord-primary">
            <div class="navbar-left">LOGO</div>
            <div class="navbar-center">42Fans</div>
            <div class="navbar-right">
                <?php if($_SESSION['user_password'] !== "verified"): ?>                
                    <a href="/Auth">
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
    <div class="menu bg-primary bord-primary">
        <ul>
            <li class="<?= WHERE_AM_I === 'home' ? 'active' : ''?>">Home</li>
            <li class="<?= WHERE_AM_I === 'UserProfile' ? 'active' : ''?>">My Profile</li>
        </ul>
    </div>
    <div class="main">
        <h2><?php echo $userName?></h2>
    </div>
    <div class="sidebar bg-secondary bord-primary">sidebar here</div>
    <!-- <h1>Register User</h1>
    <form method="POST" action="">
        <label>Name: <input type="text" name="name" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>   
        <button type="submit">Register</button>
    </form> -->
    
    <!-- <p><?php echo $message ?? ''; ?></p> -->
    
    <footer class="footer">Footer</footer>
</div>
<script>console.log(<?php echo json_encode($_SESSION); ?>);</script>
<script>console.log("Session_id: <?php echo session_id(); ?>");</script> 
</body>
</html>