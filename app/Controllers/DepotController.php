<?php
// Controller pour la page de dépôt de signalement

class DepotController {
    public function index() {

        
        require BASE_PATH . '/app/Views/layout/header.php';
        require BASE_PATH . '/app/Views/Depot/insert.php';
        require BASE_PATH . '/app/Views/layout/footer.php';
        
    }
}