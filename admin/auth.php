<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('CONTENT_JSON_PATH', dirname(__DIR__) . '/content.json');
define('UPLOADS_DIR', dirname(__DIR__) . '/uploads');
define('UPLOADS_URL_PREFIX', '/uploads');
define('CREDENTIALS_PATH', __DIR__ . '/credentials.php');

function get_credentials() {
    if (file_exists(CREDENTIALS_PATH)) {
        $creds = require CREDENTIALS_PATH;
        if (is_array($creds) && isset($creds['username'], $creds['password'])) {
            return $creds;
        }
    }
    return ['username' => 'admin', 'password' => 'admin'];
}

function require_login() {
    if (empty($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: login.php');
        exit;
    }
}
