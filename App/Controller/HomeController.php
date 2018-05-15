<?php

namespace App\Controller;

use App\Model\Repository;
use Core\Controller\Controller;

class HomeController extends Controller
{
    public function index() {
        if(isset($_POST[''])) {
        }
        $this->template = 'default';
        $this->render('home/index', compact('var', 'toto'));
    }
}

