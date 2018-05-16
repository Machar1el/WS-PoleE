<?php

namespace App\Controller;

use App\Model\Repository;
use Core\Controller\Controller;

class SearchController extends Controller {
    public function index() {
        if(isset($_POST)) {
            switch ($_POST['level']) {
                case "0":
                    $_SESSION['level'] = 1;
                    $this->levelZeroToOne();
                    break;
                case "1":
                    $_SESSION['level1_counter'] = intval($_SESSION['level1_counter']) + 1;
                    if($_SESSION['level1_counter'] > 2) {
                        $_SESSION['level'] = 2;
                        $this->levelOneToTwo();
                    } else {
                        $this->getSearchResult();
                    }
                    break;
                case "2":
                    echo 'proot';
                    break;
                case "3":
                    break;
                default:
            }
        }
    }

    private function levelZeroToOne() {
        $url = "'" . PATH . "/search/index'";

        echo "
                <div id='search'>
                    <form action=$url method='POST'>
                        <label>Recherche vocale</label>
                        <br/>
                        <input class='form-control' type='text' name='search' placeholder='Dîtes-moi ce que vous voulez...'/>
                        <br/>
                        <a class='btn btn-primary' id=\"validate\" href='#'>Valider</a>
                    </form>
                </div>
            ";
    }

    private function getSearchResult() {
        echo "
                <a href='http://soundcloud.com/momomo'>Résultat de la recherche...</a>
            ";
    }

    private function levelOneToTwo() {
        echo "
                <div id='chat'>
                    
                </div>
            ";
    }

    private function levelTwoToThree() {
        echo "
                <div id='phsysical-assistance'>
                    
                </div>
            ";
    }
}

