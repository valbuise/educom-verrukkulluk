<?php 

class shoppinglist {

    private $connection;
    private $user;
    private $ingredient;


    public function __construct($connection) {
        $this->connection = $connection;
        $this->user = new user($connection);
        $this->ingredient = new ingredient($connection);

    }

    private function selectUser($user_id){
        $user = $this->user->selectUser($user_id);
        return $user;
     }

    private function selectIngredient($gerecht_id){
        $ingredient = $this->ingredient->selectIngredient($gerecht_id);
        return $ingredient;
    }




    public function addToList($gerecht_id, $user_id){

    $ingredients = $this->selectIngredient($gerecht_id);

    $total = 0;

    foreach ($ingredients as $ingredient) {

        if($this->artikelOnList($ingredient['artikel_id'], $user_id));{

        /* onderstaande doet wel iets, maar 2 problemen: 

        1: site blijft loopen (terwijl er wel iets wordt aangepast in de database).

        2: alleen de verpakking van het eerste artikel van de ingredienten wordt vermeerderd, niet ieder artikel. */

        $total_bijgewerkt = 0;
             
        while ($ingredient['aantal'] > $ingredient['verpakking']) {

            $artikel_id = $ingredient['artikel_id'];

            $extra_verpakking = $ingredient['verpakking'] + $ingredient['verpakking'];

            $sql = "update boodschappenlijst set verpakking = $extra_verpakking where user_id = $user_id and artikel_id = $artikel_id";

            $result = mysqli_query($this->connection, $sql);

            $total_bijgewerkt += $result;

            }

        return(true);
        
        

        }

        $artikel = $ingredient['artikel_id'];
        $verpakking = $ingredient['verpakking'];
        $aantal = $ingredient['aantal'];
        $prijs = $ingredient['prijs'];

        $sql = "insert into boodschappenlijst(user_id, artikel_id, verpakking, aantal, prijs) values (1, $artikel, $verpakking, $aantal, $prijs)";

        $result = mysqli_query($this->connection, $sql);

        $total += $result;
        
    }

    return(true);

    }   
        

    // onderstaande functie is getest en werkt!

    public function artikelOnList($artikel_id, $user_id){

        $sql = "select * from boodschappenlijst where user_id = $user_id";

        $result = mysqli_query($this->connection, $sql);

        $groceries = mysqli_fetch_all($result, MYSQLI_ASSOC);                 

        foreach($groceries as $grocerie){

            if ($grocerie['artikel_id']==$artikel_id){

                return $grocerie;

            }
        

        }

        return(false);
    }

}