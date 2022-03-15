<?php 

class shoppinglist {

    private $connection;
    private $user;
    private $ingredient;
    private $grocerie;


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
            
    $artikel = $ingredient['artikel_id'];
    $nodig = $ingredient['aantal'] / $ingredient['verpakking'];
    $verpakking = ceil($nodig);
    $aantal = $ingredient['aantal'];
    $prijs = $ingredient['prijs'];

        if(!$this->artikelOnList($ingredient['artikel_id'], $user_id)) {

        $sql = "insert into boodschappenlijst(user_id, artikel_id, verpakking, aantal, prijs) values (1, $artikel, $verpakking, $aantal, $prijs)";

        $result = mysqli_query($this->connection, $sql);

                
        } else {
        
        $grocerie = $this->artikelOnList($ingredient['artikel_id'], 1);
        $extra_ingredient = $ingredient['aantal'] + $grocerie['aantal'];
        $extra_nodig = $extra_ingredient / $ingredient['verpakking'];
        $extra_verpakking = ceil($extra_nodig);

        $sql = "update boodschappenlijst set aantal = $extra_ingredient, verpakking = $extra_verpakking where user_id = $user_id and artikel_id = $artikel";

        $result = mysqli_query($this->connection, $sql);
          
        }

    }

    $total ++;

    } 


    public function artikelOnList($artikel_id, $user_id){

        $sql = "select * from boodschappenlijst where user_id = $user_id";
        $result = mysqli_query($this->connection, $sql);
        $groceries = mysqli_fetch_all($result, MYSQLI_ASSOC);                 

        foreach( $groceries as $grocerie ){

            if ( $grocerie['artikel_id'] == $artikel_id ){

                return $grocerie;

            }
        }

        return(false);
    }
}