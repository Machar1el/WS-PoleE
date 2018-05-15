<?php

namespace App\Controller;

use App\Model\Repository;
use Core\Controller\Controller;

class SearchController extends Controller {
    public function index() {
        echo 'total';
        if(isset($_POST)) {
            echo "proot";
            var_dump($_POST);
            $this->template = 'default';
            $this->render('search/index', compact('_POST'));
        }
    }
}

