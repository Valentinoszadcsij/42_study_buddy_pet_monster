<?php

require_once __DIR__ . '/env.php';

return [
    'client_id' => getenv('CLIENT_ID') ?: $_ENV['CLIENT_ID'] ?? '',
    'client_secret' => getenv('CLIENT_SECRET') ?: $_ENV['CLIENT_SECRET'] ?? '',
    'redirect_uri' => getenv('REDIRECT_URI') ?: $_ENV['REDIRECT_URI'] ?? 'https://localhost:8443/Auth/callback',
    'authorize_url' => getenv('AUTHORIZE_URL') ?: $_ENV['AUTHORIZE_URL'] ?? 'https://api.intra.42.fr/oauth/authorize',
    'token_url' => getenv('TOKEN_URL') ?: $_ENV['TOKEN_URL'] ?? 'https://api.intra.42.fr/oauth/token',
];
?>
