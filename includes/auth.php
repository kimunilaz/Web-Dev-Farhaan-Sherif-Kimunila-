<?php
/**
 * Session + authentication helpers.
 * Included at the top of every page (via header.php) so
 * $_SESSION is always available.
 */

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', '1');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function is_logged_in(): bool {
    return isset($_SESSION['user_id'], $_SESSION['username']);
}

function login_user(array $user): void {
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int) $user['id'];
    $_SESSION['username'] = (string) $user['username'];
}

function logout_user(): void {
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $cookie = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires' => time() - 42000,
            'path' => $cookie['path'],
            'domain' => $cookie['domain'],
            'secure' => $cookie['secure'],
            'httponly' => $cookie['httponly'],
            'samesite' => $cookie['samesite'] ?? 'Lax',
        ]);
    }

    session_destroy();
}

/**
 * Build a URL from the application root, whether the current page is in
 * the project root or in the heroes directory.
 */
function app_url(string $path = ''): string {
    $script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/');
    $app_path = dirname($script_name);

    if (basename($app_path) === 'heroes') {
        $app_path = dirname($app_path);
    }

    $app_path = $app_path === '/' ? '' : rtrim($app_path, '/');

    return $app_path . '/' . ltrim($path, '/');
}

/**
 * Return a usable hero image URL, falling back when a local file is absent.
 */
function hero_image_url(?string $image_url, string $hero_name): string {
    $image_url = trim((string) $image_url);
    $scheme = strtolower((string) parse_url($image_url, PHP_URL_SCHEME));

    if ($image_url !== '' && in_array($scheme, ['http', 'https'], true)) {
        return $image_url;
    }

    if ($image_url !== '') {
        $relative_path = ltrim(str_replace('\\', '/', $image_url), '/');
        $file_path = dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative_path);

        if (is_file($file_path)) {
            return app_url($relative_path);
        }
    }

    return 'https://placehold.co/500x500/0f172a/06b6d4?text=' . urlencode($hero_name);
}

/**
 * Call this at the top of any page that requires authentication
 * (edit.php, delete.php). Anonymous visitors get bounced to login.php.
 */
function require_login(): void {
    if (!is_logged_in()) {
        header('Location: ' . app_url('login.php'));
        exit;
    }
}

function redirect_if_logged_in(): void {
    if (is_logged_in()) {
        header('Location: ' . app_url('index.php'));
        exit;
    }
}
