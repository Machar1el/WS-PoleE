<?php

namespace App\Controller;

use App\Model\Repository;
use Core\Controller\Controller;

class SearchController extends Controller {
    public function index() {
        if(isset($_POST)) {
            echo '
                <div id="search">
                    <form action="<?= PATH ?>search/index" method="POST">
                        <label>Recherche vocale</label>
                        <br/>
                        <input type="text" name="search" placeholder="Dîtes-moi ce que vous voulez..."/>
                        <br/>
                        <br/>
                        <input type="submit" value="Valider"/>
                    </form>
                </div>
            ';
        }
    }
}

