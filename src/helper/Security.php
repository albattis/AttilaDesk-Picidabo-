<?php

namespace helper;

class Security
{
    /**
     * CSRF token generálása és mentése a session-be
     */
    public static function generateCsrfToken()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * CSRF token ellenőrzése
     */
    public static function validateCsrfToken($token)
    {
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            return false;
        }
        return true;
    }

    /**
     * Biztonságos kimenet generálása (XSS védelem)
     */
    public static function escape($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
