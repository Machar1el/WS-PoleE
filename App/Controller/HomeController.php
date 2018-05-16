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
        $this->render('home/index');
    }

    public function accueil() {
        $this->template = 'default';
        $this->render('home/accueil');
    }

    public function search() {
        if(!empty($_POST)) {

            if( isset( $_POST['search'] ) )
            {
                $search = $_POST['search'];
                $users = $adminrepo->getUsersBySearch($search);
                echo '<table class="table">';
                echo '<thead class="thead-inverse">';
                echo '<tr>';
                echo '<th>ID</th>';
                echo '<th>Nom</th>';
                echo '<th>Prenom</th>';
                echo '<th>Email</th>';
                echo '</tr>';
                echo '<tbody>';
                foreach ($users as $key => $user) {
                    echo '<tr class="dab page-content">';
                    echo '<th scope="row">'.$user->getId() .'</th>';
                    echo '<td>'. $user->getNom().'</td>';
                    echo '<td>'. $user->getPrenom().'</td>';
                    echo '<td>'. $user->getEmail().'</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                die;
            }

            if(isset($_POST['userid'])) {
                $userid = $_POST['userid'];
            } else {
                $userid = 'null';
            }
            if(isset($_POST['annonce'])) {
                $annonce = $_POST['annonce'];
            } else {
                $annonce = 'null';
            }
            if(isset($_POST['surcout'])) {
                if(!empty($_POST['surcout'])) {
                    $surcout = $_POST['surcout'];
                } else {
                    $surcout = 0;
                }
            }

            if($userid != 'null' && $annonce != 'null') {

                if($adminrepo->setPaiementCheque($annonce, $userid)) {
                    $annonceod = $annonceodrepo->getAnnonceOD($annonce);
                    $acheteur = new Personne($userid);
                    $vendeur = $annonceod->getPersonne();

                    $mail= new \PHPMailer();
                    $mail->CharSet = 'UTF-8';
                    $mail->Debugoutput = 'html';
                    $mail->IsHTML(true);
                    $mail->Host = HOSTMAIL;
                    $mail->Port = 587;
                    $mail->Username = USERMAIL;
                    $mail->Password = PASSWORDMAIL;
                    $mail->setFrom('webmaster@sites-chirdent.net', '['.VARWEB.']');
                    $mail->addAddress(EMAIL_LAURENT);
                    $mail->addAddress(EMAIL_ROBERT);
                    $mail->Subject = 'TRANSACTION EN COURS SUR '.VARWEB.' ';
                    $mail->Body = 'Le paiement par chèque pour l\'article : '.$annonceod->getTitre_annonce().' vient d\'être effectué. <br /> Le prix est de : '.$annonceod->getPrix_annonce().'. Le type d\'expédition est : '.$annonceod->getTypeexpedition()->getLibelle_typeexpedition().'. <br /> Le vendeur est : '.$vendeur->getNom().' '.$vendeur->getPrenom().' '.$vendeur->getEmail().' '.$vendeur->getAdresse().' '.$vendeur->getCodepostal().' '.$vendeur->getVille().' '.$vendeur->getTelephone().' '.$vendeur->getMobile().' '.$vendeur->getPays()->getLibelleFRPays().' . <br /> L\'acheteur est : '.$acheteur->getNom().' '.$acheteur->getPrenom().' '.$acheteur->getEmail().' '.$acheteur->getAdresse().' '.$acheteur->getCodepostal().' '.$acheteur->getVille().' '.$acheteur->getTelephone().' '.$acheteur->getMobile().' '.$acheteur->getPays()->getLibelleFRPays().' ';
                    //send the message, check for errors
                    if (!$mail->send()) {
                        echo "Mailer Error: " . $mail->ErrorInfo;
                    }

                    $mail2 = new \PHPMailer();
                    $mail2->CharSet = 'UTF-8';
                    $mail2->Debugoutput = 'html';
                    $mail2->Host = HOSTMAIL;
                    $mail2->Port = 587;
                    $mail2->Username = USERMAIL;
                    $mail2->Password = PASSWORDMAIL;
                    $mail2->setFrom('webmaster@sites-chirdent.net', '['.VARWEB.']');
                    $mail2->addAddress($acheteur->getEmail());
                    $mail2->Subject = 'Votre achat sur '.VARWEB.'.';
                    $message = file_get_contents(PATH . '/App/Views/Mails/achat.html');
                    $message = str_replace('%unsubscribe%', PATH . 'home/index', $message);
                    $message = str_replace('%titre%', 'Votre achat', $message);
                    $message = str_replace('%content%', 'Cher(e) membre, <br /> Merci d\'avoir effectué un achat sur notre site '.VARWEB.'. <br /> Nous avons bien pris en compte votre demande de paiement. <br /> Nous vous invitons à prendre contact avec le vendeur. <br /> Informations vendeur : '.$vendeur->getNom().' '.$vendeur->getPrenom().'; '.$vendeur->getEmail().'; '.$vendeur->getAdresse().' '.$vendeur->getCodepostal().' '.$vendeur->getVille().'; '.$vendeur->getTelephone().' '.$vendeur->getMobile().'; '.$vendeur->getPays()->getLibelleFRPays().'. <br /> Vous pouvez consulter vos transactions dans la section "transaction" de votre compte en cliquant sur le lien suivant :', $message);
                    if($annonceod->getTypeexpedition()->getId_typeexpedition() == 1) {
                        $message = str_replace('%expe%', 'Votre type d\'expedition est en colis suivi.', $message);
                    }
                    elseif($annonceod->getTypeexpedition()->getId_typeexpedition() == 2) {
                        $message = str_replace('%expe%', 'Il est prévu que vous alliez récupérer le matériel sur site. <br /> Merci de contacter et de vous arranger avec le vendeur dans les plus brefs délais.', $message);
                    }
                    else {
                        $message = str_replace('%expe%', 'Il est prévu que le matériel soit installé directement par le vendeur. <br /> Merci de contacter celui-ci et de vous arranger avec lui dans les plus brefs délais.', $message);
                    }
                    $message = str_replace('%path%', PATH . '/personne/achats' , $message);
                    $mail2->MsgHTML($message);

                    //send the message, check for errors
                    if (!$mail2->send()) {
                        echo "Mailer Error: " . $mail2->ErrorInfo;
                    }

                    $mail3 = new \PHPMailer();
                    $mail3->CharSet = 'UTF-8';
                    $mail3->Debugoutput = 'html';
                    $mail3->Host = HOSTMAIL;
                    $mail3->Port = 587;
                    $mail3->Username = USERMAIL;
                    $mail3->Password = PASSWORDMAIL;
                    $mail3->setFrom('webmaster@sites-chirdent.net', '['.VARWEB.']');
                    $mail3->addAddress($vendeur->getEmail());
                    $mail3->Subject = 'Votre vente sur '.VARWEB.'.';
                    $message = file_get_contents(PATH . '/App/Views/Mails/achat.html');
                    $message = str_replace('%unsubscribe%', PATH . 'home/index', $message);
                    $message = str_replace('%titre%', 'Votre vente', $message);
                    $message = str_replace('%content%', 'Cher(e) membre, <br /> Votre vente a correctement été effectuée pour l\'article '.$annonceod->getTitre_annonce().'. <br /> Nous vous invitons à prendre contact avec le l\'acheteur. <br /> Informations acheteur : '.$acheteur->getNom().' '.$acheteur->getPrenom().'; '.$acheteur->getEmail().'; '.$acheteur->getAdresse().' '.$acheteur->getCodepostal().' '.$acheteur->getVille().'; '.$acheteur->getTelephone().' '.$acheteur->getMobile().'; '.$acheteur->getPays()->getLibelleFRPays().'. </br > Vous pouvez consulter vos transactions dans la section "transaction" de votre compte en cliquant sur le lien suivant :', $message);
                    if($annonceod->getTypeexpedition()->getId_typeexpedition() == 1) {
                        $message = str_replace('%expe%', 'Votre type d\'expedition est en colis suivi. <br /> Merci de réaliser l\'envoi dans les plus bref délais.', $message);
                    }
                    elseif($annonceod->getTypeexpedition()->getId_typeexpedition() == 2) {
                        $message = str_replace('%expe%', 'Il est prévu que l\'acheteur vienne récupérer le matériel sur site. <br /> Merci de contacter et de vous arranger avec le l\'acheteur dans les plus brefs délais.', $message);
                    }
                    else {
                        $message = str_replace('%expe%', 'Il est prévu que le matériel soit installé directement par le vendeur. <br /> Merci de contacter l\'acheteur et de vous arranger avec lui dans les plus brefs délais.', $message);
                    }
                    $message = str_replace('%path%', PATH . '/personne/ventes' , $message);
                    $mail3->MsgHTML($message);
                    //send the message, check for errors
                    if (!$mail3->send()) {
                        echo "Mailer Error: " . $mail3->ErrorInfo;
                    }

                    $error = "<div class=\"alerta alert alert-success\" role=\"alert\"> Le paiement est validé.</div>";
                }

            } else {
                $error = "<div class=\"alerta alert alert-danger\" role=\"alert\"> <strong>Erreur: </strong>Sélectionnez un utilisateur et une annonce</div>";
            }

        }

    }
}

