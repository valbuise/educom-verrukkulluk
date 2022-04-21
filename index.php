<?php

//// Allereerst zorgen dat de "Autoloader" uit vendor opgenomen wordt:
require_once("vendor/autoload.php");

/// Twig koppelen:
$loader = new \Twig\Loader\FilesystemLoader("templates");
/// VOOR PRODUCTIE:
/// $twig = new \Twig\Environment($loader), ["cache" => "./cache/cc"]);

/// VOOR DEVELOPMENT:
$twig = new \Twig\Environment($loader, ["debug" => true ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

/******************************/

/// Next step, iets met je data doen. Ophalen of zo
/// require_once("lib/gerecht.php");


require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/kitchentype.php");
require_once("lib/recipeinfo.php");
require_once("lib/ingredient.php");
require_once("lib/recipe.php");
require_once("lib/shoppinglist.php");
require_once("lib/rating.php");
require_once("lib/search.php");

/// INIT

$db = new database();
$usr = new user ($db->getConnection());
$art = new artikel($db->getConnection());
$kt = new kitchentype($db->getConnection());
$rcpi = new recipeinfo($db->getConnection());
$ing = new ingredient($db->getConnection());
$gerecht = new recipe($db->getConnection()); 
$shp = new shoppinglist($db->getConnection());
$rat = new rating($db->getConnection());
$zoek = new zoek($db->getConnection());

/// VERWERK 

//$data_usr = $usr->selectUser(1);
//$data_art = $art->selectArtikel(2);
//$data_kt = $kt->selectKitchenType(8);
//$data_rcpi = $rcpi->selectInfo(5, 'W');
//$data_favo = $rcpi->addFavorite(5, 1);
//$data_delfavo = $rcpi->deleteFavorite(3, 1);
//$data_ing = $ing->selectIngredient(3);
//$data_rec = $rec->selectRecipe(5);
//$data_rating = $rcpi->selectRating(15);
//$data_steps = $rec->selectSteps(4);
//$data_shp = $shp->addToList(3, 1);
//$data_on_shp = $shp->artikelOnList(2, 1);
//$data_rat = $rat->addRating(3, 3);

$data = $gerecht->selectRecipe();


/*
URL:
http://localhost/educom-verrukkulluk/index.php?gerecht_id=4&action=detail
*/

$gerecht_id = isset($_GET["gerecht_id"]) ? $_GET["gerecht_id"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";



switch($action) {

        case "homepage": {
            $data = $gerecht->selectRecipe();
            $template = 'homepage.html.twig';
            $title = "homepage";
            break;
        }

        case "detail": {
            $data = $gerecht->selectRecipe($gerecht_id);
            $template = 'detail.html.twig';
            $title = "detail pagina";
            break;
        }

        case "rating": {      

            $rating = isset($_POST['rating']) ? $_POST['rating'] : "";     
            $rat->addRating($gerecht_id, $rating);            
            $data = $gerecht->selectRecipe($gerecht_id); 
            $avgRating =  $data[0]['avgrating'];
            
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(["success" => true, "gerecht"=> $gerecht_id, "rating" => $rating, "avgRating" => $avgRating]);
            exit();
            break;
        } 

        case "list": { 

            $shp->addToList($gerecht_id, '1');
            $data = $gerecht->selectRecipe($gerecht_id);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(["success" => true, "gerecht"=> $gerecht_id]);
            exit();
            break;
        }

        case "shoppinglist": { 

            $data = $shp->selectList(1);
            $template = 'shop.html.twig';
            $title = "boodschappenlijst";
            break;

        }

        case "deleteAll": {

            $shp->deleteAll();
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(["success" => true]);
            exit();
            break;
        }

        case "deleteArtikel": {

            $artikel_id = isset($_POST['artikel']) ? $_POST['artikel'] : "";
            $shp->deleteArtikel($artikel_id, 1);
            
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(["success" => true]);
            exit();
            break;
        }

        case "updateArtikel": {

            $artikel_id = isset($_POST['artikel']) ? $_POST['artikel'] : "";
            $shp->updateArtikel($artikel_id);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(["success" => true]);
            exit();
            break;
        }

        case "search": {

            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
            $data = $zoek->zoek($keyword);
            $template = 'homepage.html.twig';
            $title = "homepage";
            break;
        }

        /// etc

}


/// Onderstaande code schrijf je idealiter in een layout klasse of iets dergelijks
/// Juiste template laden, in dit geval "homepage"
$template = $twig->load($template);


/// En tonen die handel!
echo $template->render(["title" => $title, "data" => $data]);


/// RETURN

//echo "<pre>"; //preserve text formatting
//var_dump($data);
