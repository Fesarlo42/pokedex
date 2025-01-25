<?php

/**
 * Authentication model
 * 
 */
class Authentication extends DatabaseConnection {

    public function login(string $username, string $pass): bool {}

    public function logout(): bool {}

    public function isLoggedIn():bool {}

    public function hasPermission(string $requiredRole): bool {}
    
}
?>