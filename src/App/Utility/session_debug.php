<?php
function debug_session_to_console() {
    if (php_sapi_name() === 'cli') return; // Don't run in CLI

    echo "<script>";
    echo "console.log('--- PHP Session Data ---');";
    foreach ($_SESSION as $key => $value) {
        $jsKey = json_encode($key);
        $jsValue = json_encode($value, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        echo "console.log($jsKey, $jsValue);";
    }
    echo "</script>";
}
?>