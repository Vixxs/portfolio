<?php
final class DataBase{
    static function connectdb() {
        $host = "mysql";
        $port = "3306";
        $db = "hotdb";
        $username = "hotuser";
        $password = "hotpassword";

        try {
            $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db","$username","$password");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de donnée :" . $e->getMessage();
        }
    }
}
