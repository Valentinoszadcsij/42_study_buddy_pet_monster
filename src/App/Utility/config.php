<?php

return[
    'client_id' => getenv('CLIENT_ID') ?: $_ENV['CLIENT_ID'] ?? '',
    'client_secret' => getenv('CLIENT_SECRET') ?: $_ENV['CLIENT_SECRET'] ?? '',
    'redirect_uri' => 'http://168.119.183.211:8443/Auth/callback',
    'authorize_url' => 'https://api.intra.42.fr/oauth/authorize',
    'token_url' => 'https://api.intra.42.fr/oauth/token',
]
?>
