<?php
require_once '../vendor/autoload.php'; 

use \Firebase\JWT\JWT;

class Auth {
    // Generate JWT token
    public static function generateToken($user_id) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  
        $payload = array(
            "iss" => "vending_machine_system",
            "sub" => $user_id,
            "iat" => $issuedAt,
            "exp" => $expirationTime
        );

        return JWT::encode($payload, JWT_SECRET, 'HS256');
    }

    // Validate the JWT token
    public static function validateToken($token) {
        try {
            $decoded = JWT::decode($token, JWT_SECRET);
            return (object) $decoded;  
        } catch (Exception $e) {
            return null; 
        }
    }
}
