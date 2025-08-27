
<?php
require_once __DIR__ . '/../config/database.php';

class Utilisateur {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function ajouter($numloc, $nom_loc, $design_voiture, $nbr_jour, $taux_jour) {
        $stmt = $this->pdo->prepare("INSERT INTO location (numloc, nom_loc, design_voiture, nbr_jour, taux_jour) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$numloc, $nom_loc, $design_voiture, $nbr_jour, $taux_jour]);
    }

    public function lister($q, $tri) {
        // $allowedTri = ['numloc', 'nom_loc', 'design_voiture', 'nbr_jour' , 'taux_jour' ];

        // if(!in_array($tri, $allowedTri)){
        //     $tri = 'numloc';
        // }
        $sql = "SELECT * FROM location ORDER BY numloc DESC";
        if ($q !== null && $q !== '' ) {
            switch ($tri) {
                
                case 'numloc':
                    $sql = "SELECT * FROM location WHERE numloc LIKE ?";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute(["%$q%"]);
                    break;
                
                case 'nom_loc':
                    $sql = "SELECT * FROM location WHERE nom_loc LIKE ?";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute(["%$q%"]);
                    break;

                case 'design_voiture':
                    $sql = "SELECT * FROM location WHERE design_voiture LIKE ?";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute(["%$q%"]);
                    break;

                case 'nbr_jour':
                    $sql = "SELECT * FROM location WHERE nbr_jour LIKE ?";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute(["%$q%"]);
                    break;

                case 'taux_jour':
                    $sql = "SELECT * FROM location WHERE taux_jour LIKE ?";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute(["%$q%"]);
                    break;

                default:
                    $sql = "SELECT * FROM location WHERE numloc LIKE ?
                                OR nom_loc LIKE ? 
                                OR design_voiture LIKE ?
                                OR nbr_jour LIKE ? 
                                OR taux_jour LIKE ? 
                                ORDER BY numloc DESC";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute(["%$q%", "%$q%", "%$q%", "%$q%", "%$q%"]);
                    break;
            }
            
        } else {
            $stmt = $this->pdo->query($sql);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function modifier($numloc, $nom_loc, $design_voiture, $nbr_jour, $taux_jour) {
        $stmt = $this->pdo->prepare("UPDATE location SET numloc = ?, nom_loc = ?, design_voiture = ?, nbr_jour = ?, taux_jour = ? WHERE numloc = ?");
        return $stmt->execute([$numloc, $nom_loc, $design_voiture, $nbr_jour, $taux_jour, $numloc]);
    }

    public function supprimer($numloc) {
        $stmt = $this->pdo->prepare("DELETE FROM location WHERE numloc = ?");
        return $stmt->execute([$numloc]);
    }
}
