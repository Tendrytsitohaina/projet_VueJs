
<?php
require_once __DIR__ . '/../models/Utilisateur.php';

class UtilisateurController {
    private $model;

    public function __construct() {
        $this->model = new Utilisateur();
    }

    public function ajouter($data) {
        return $this->model->ajouter($data['numloc'], $data['nom_loc'], $data['design_voiture'],$data['nbr_jour'], $data['taux_jour']);
    }

    public function lister($q, $tri) {
        return $this->model->lister($q, $tri);
    }

    public function modifier($data) {
        
        return $this->model->modifier($data['numloc'], $data['nom_loc'], $data['design_voiture'],$data['nbr_jour'], $data['taux_jour']);
    }

    public function supprimer($id) {
        return $this->model->supprimer($id);
    }
}
