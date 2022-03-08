<?php 

class recipe {

   private $connection;
   private $gerecht;
   private $user;
   private $ingredient;
   private $gerecht_info;
   private $record_type;
   private $allRatings;
   private $artikel;
   private $keuken;
   private $type;
   private $keukentype;




   public function __construct($connection){
       $this->connection = $connection;
       $this->user = new user ($connection);
       $this->ingredient = new ingredient ($connection);
       $this->gerecht_info = new recipeinfo ($connection);
       $this->keukentype = new kitchenType ($connection);
       
    
   }


   private function selectUser($user_id){
      $user = $this->user->selectUser($user_id);
      return $user;
   }

   private function selectKitchenType($keuken_type_id){                     
       $keukentype = $this->keukentype->selectKitchenType($keuken_type_id);
       return $keukentype; 
   }

      
   private function selectIngredient($gerecht_id){
       $ingredient = $this->ingredient->selectIngredient($gerecht_id);
       return $ingredient;
   }


   private function selectInfo($gerecht_id, $record_type){
       $gerecht_info = $this->gerecht_info->selectInfo($gerecht_id, $record_type);
       return $gerecht_info;
   }



   private function calcRating($allRatings){

    //guard clause:
    if (count($allRatings) == 0){
        return (0);
    }

    $average = 0;
    $total = 0;

    foreach ($allRatings as $oneRating){

        $total += $oneRating['nummeriekveld'];
    }

    $average = $total / count($allRatings);

    return $average;


   }


   private function calcPrice($ingredient){ 

   $total = 0;
   $totalPrice = 0;

   foreach ($ingredient as $pricePerArt){

        $ingredient = $pricePerArt['prijs'] / $pricePerArt['verpakking'] * $pricePerArt['aantal'];

        $total += $ingredient;

   }
   

    $totalInEuro = $total / 100;

    return $totalInEuro; 
   
   }


   private function calcCalories($totalCalories){ 

    $total = 0;
    
    foreach ($totalCalories as $calPerIngredient){

        $totalCalories = $calPerIngredient['calorie'] / $calPerIngredient['verpakking'] *  $calPerIngredient['aantal'];
                
        $total += $totalCalories;

    }
    
    return $total;

    }   
   
    
    
    public function selectRecipe($gerecht_id = NULL){
  
        $gerechten = [];
          
        
        $sql =  "select * from gerecht"; // geeft fout
    
        if ($gerecht_id != NULL){
    
            $sql .= " where id = $gerecht_id";
        }


    $result = mysqli_query($this->connection, $sql); 
        

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

            $user = $this->selectUser($row['user_id']);

            $type = $this->selectKitchenType($row['type_id']);        

            $keuken = $this->selectKitchenType($row['keuken_id']); 

            $ingredient = $this->selectIngredient($gerecht_id);

            $rating = $this->selectInfo($gerecht_id, 'W');
            
            $steps = $this->selectInfo($gerecht_id, 'B');

            $remarks = $this->selectInfo($gerecht_id, 'O');

            $favorite = $this->selectInfo($gerecht_id, 'F');
            
            $avgRating = $this->calcRating($rating);

            $totalPrice = $this->calcPrice($ingredient);

            $totalCalories = $this->calcCalories($ingredient);    
        

            $gerechten[] = [
                
                "id" => $row['id'],
                "user" => $user['user_name'],
                "datum" => $row['datum_toegevoegd'],
                "titel" => $row['titel'],
                "korte_omschrijving" => $row['korte_omschrijving'],
                "lange_omschrijving" => $row['lange_omschrijving'],
                "afbeelding" =>$row['afbeelding'],
                "type" => $type['omschrijving'],
                "keuken" => $keuken['omschrijving'],
                "ingredient" => $ingredient,
                "rating" => $rating,
                "steps" => $steps,
                "remarks" => $remarks,
                "favorite" => $favorite,       
                "avgrating" => $avgRating,
                "totalprice" => $totalPrice,
                "totalcalories" => $totalCalories,

            ];
            }

            return $gerechten;
    }
        
}