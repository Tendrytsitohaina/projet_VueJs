
<?php
class Database {
    public static function connect() {
        try {
            return new PDO("mysql:host=localhost;dbname=locationvoiture;charset=utf8", "root", "");
        } catch (PDOException $e) {
            die(json_encode(['message' => 'Erreur de connexion à la base de données']));
        }
    }
}
