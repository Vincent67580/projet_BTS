<?php 
// Controller pour la page d'accueil

    class HomeController {
    public function index() {

        require BASE_PATH . '/app/Views/layout/header.php';
        require BASE_PATH . '/app/Views/Home/index.php';
        require BASE_PATH . '/app/Views/layout/footer.php';
    }
}
