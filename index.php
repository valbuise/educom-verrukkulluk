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
            $avgRating =  $data["avgrating"]; // Werkt dit zo?
            
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(["success" => true, "rating" => $rating, 'avgRating' => $avgRating]);
            
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

// echo "<pre>"; //preserve text formatting
// var_dump($data_rat);
