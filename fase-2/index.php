<?php
//// Allereerst zorgen dat de "Autoloader" uit vendor opgenomen wordt:
require_once("../vendor/autoload.php");

/// Twig koppelen:
$loader = new \Twig\Loader\FilesystemLoader("../templates");
/// VOOR PRODUCTIE:
/// $twig = new \Twig\Environment($loader), ["cache" => "./cache/cc"]);

/// VOOR DEVELOPMENT:
$twig = new \Twig\Environment($loader, ["debug" => true ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

/******************************/

/// Next step, iets met je data doen. Ophalen of zo
/// require_once("lib/gerecht.php");
/// $gerecht = new gerecht();
/// $data = $gerecht->selecteerGerecht();

require_once("../lib/database.php");
require_once("../lib/artikel.php");
require_once("../lib/user.php");
require_once("../lib/kitchentype.php");
require_once("../lib/recipeinfo.php");
require_once("../lib/ingredient.php");
require_once("../lib/recipe.php");
require_once("../lib/shoppinglist.php");
require_once("../lib/rating.php");


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

$data = $gerecht->selectRecipe();


/*
URL:
http://localhost/educom-verrukkulluk/fase-2/index.php?gerecht_id=4&action=detail
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
            $rating = $_GET["rating"];
            $gerecht_id = $_GET["gerecht_id"];

            $data = $gerecht->addRating($gerecht_id, $rating);

            header('Content-Type: application/json; charset=utf-8');

            echo json_encode(["succes" => true, "rating" => $rating]);
            break;
        } 

        /// etc

}



/// Onderstaande code schrijf je idealiter in een layout klasse of iets dergelijks
/// Juiste template laden, in dit geval "homepage"
$template = $twig->load($template);


/// En tonen die handel!
echo $template->render(["title" => $title, "data" => $data]);
