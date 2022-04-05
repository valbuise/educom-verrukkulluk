<?php 

class shoppinglist {

    private $connection;
    private $user;
    private $ingredient;
    private $grocerie;
    private $artikel;
    private $boodschap;


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

    private function calcPrijs($user_id){

        $sql = "select sum(prijs) as sum_prijs from boodschappenlijst where user_id = $user_id";

        $result = mysqli_query($this->connection, $sql);

        $row = mysqli_fetch_assoc($result); 

        $totaalPrijs = $row['sum_prijs'];

        $totaalPrijsInEuro = $totaalPrijs / 100;

        return($totaalPrijsInEuro);
    }
      

    public function addToList($gerecht_id, $user_id){

    $ingredients = $this->selectIngredient($gerecht_id);

    foreach ($ingredients as $ingredient) {  
    
    $afbeelding = $ingredient['afbeelding'];
    $artikel = $ingredient['artikel_id'];
    $titel = $ingredient['naam'];
    $omschrijving = $ingredient['omschrijving'];
    

    $nodig = $ingredient['aantal'] / $ingredient['verpakking'];
    $verpakking = ceil($nodig);
    $aantal = $ingredient['aantal'];
    $prijs = $ingredient['prijs'] * $verpakking;
    $prijs_verpakking = $ingredient['prijs'];

    $opLijst = $this->artikelOnList($ingredient['artikel_id'], $user_id);

        if(!$opLijst) {

        $sql = "insert into boodschappenlijst(user_id, artikel_id, titel, omschrijving, verpakkingen, aantal, prijs, prijsverpakking, afbeelding) values (1, '$artikel', '$titel', '$omschrijving', '$verpakking', '$aantal', '$prijs', '$prijs_verpakking', '$afbeelding')";

        $result = mysqli_query($this->connection, $sql);

                
        } else {
        
        $extra_ingredient = $ingredient['aantal'] + $opLijst['aantal'];
        $extra_nodig = $extra_ingredient / $ingredient['verpakking'];
        $extra_verpakking = ceil($extra_nodig);
        $extra_prijs = ($ingredient['prijs'] * $extra_verpakking) + $oplijst['prijs'];
        

        $sql = "update boodschappenlijst set aantal = $extra_ingredient, verpakkingen = $extra_verpakking, prijs = $extra_prijs where user_id = $user_id and artikel_id = $artikel";

        $result = mysqli_query($this->connection, $sql);
          
        }

    }
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


    
    public function selectList($user_id){

        $boodschappenlijst = [];
        
        $sql = "select * from boodschappenlijst where user_id = $user_id";
            
        $result = mysqli_query($this->connection, $sql);

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

            $totaalPrijs = $this->calcPrijs($row['user_id']);

            $boodschappenlijst[] = [
                "artikel_id" => $row['artikel_id'],
                "titel" => $row['titel'],
                "omschrijving" => $row['omschrijving'],
                "verpakkingen" => $row['verpakkingen'],
                "prijs" => $row['prijs'],
                "prijsverpakking" => $row['prijsverpakking'],
                "afbeelding" => $row['afbeelding'],
                "totaalprijs" => $totaalPrijs,
            ];

        }
            
        return($boodschappenlijst);
    
    }
    

    public function deleteAll(){

        $sql = "delete from boodschappenlijst";

        $result = mysqli_query($this->connection, $sql);

        return($result);
    }


    public function deleteArtikel($artikel_id, $user_id){

        $sql = "select * from boodschappenlijst where user_id = $user_id";

        $result = mysqli_query($this->connection, $sql);

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){    
            
            if ($row['verpakkingen'] <= 0){ 

                $sql = "delete from boodschappenlijst where artikel_id = $artikel_id";

                $result = mysqli_query($this->connection, $sql);

                return($result);

            }
        }
            
            $sql = "update boodschappenlijst set verpakkingen = verpakkingen - 1, prijs = prijs - prijsverpakking where artikel_id = $artikel_id"; 
                
            $result = mysqli_query($this->connection, $sql);

            return($result);

        
    }


    public function updateArtikel($artikel_id){

        $sql = "update boodschappenlijst set verpakkingen = verpakkingen + 1, prijs = prijs + prijsverpakking where artikel_id = $artikel_id";

        $result = mysqli_query($this->connection, $sql);

        return($result);
    }
        
}