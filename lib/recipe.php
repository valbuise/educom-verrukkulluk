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

   private function selectKitchenType($gerecht_id){                     // hier argument gerecht_id, omdat er 2 id's nodig zijn 
       $keukentype = $this->keukentype->selectKitchenType($gerecht_id); // om zowel type als keuken terug te krijgen ...
       return $keukentype; 
   }

   
   /*private function selectKitchen($keuken_id){

    $sql = "select * from db . keuken_type where id = $keuken_id and record_type = 'K'";

    $result = mysqli_query($this->connection, $sql);

    $keuken = mysqli_fetch_array($result, MYSQLI_ASSOC);

    return $keuken;

   }

   private function selectType($type_id){

    $sql = "select * from db . keuken_type where id = $type_id and record_type = 'T'";

    $result = mysqli_query($this->connection, $sql);

    $type = mysqli_fetch_array($result, MYSQLI_ASSOC);

    return $type;

  }

*/
     
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

        $totalCalories = $calPerIngredient['calorieën (KCAL)'] / $calPerIngredient['verpakking'] *  $calPerIngredient['aantal'];
                
        $total += $totalCalories;

    }
    
    return $total;

   }


   
   public function selectRecipe($gerecht_id){

        $gerecht = [];

        $sql = "select * from gerecht where id = $gerecht_id";
    
        $result = mysqli_query($this->connection, $sql);

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

            $user = $this->selectUser($row['user_id']);

            $type = $this->selectKitchenType($row['type_id']);      

            $keuken = $this->selectKitchenType($row['keuken_id']);

            $ingredient = $this->selectIngredient($gerecht_id);

            $rating = $this->selectInfo($gerecht_id, 'W');
            
            $steps = $this->selectInfo($gerecht_id, 'B');

            $remarks = $this->selectInfo($gerecht_id, 'O');

            $gerecht[] = array_merge($row, $user, $type, $keuken, $ingredient, $rating, $steps, $remarks);

            

            $avgRating = $this->calcRating($rating);

            $totalPrice = $this->calcPrice($ingredient);

            $totalCalories = $this->calcCalories($ingredient);
        
       
        }

        return [$gerecht, $avgRating, $totalPrice, $totalCalories]; // Is dit op deze manier juist gecombineerd?
       

    }

    // select one or more recipes: onderstaande zijn nog maar wat hersenspinsels over de opdracht:

    public function selectMoreRecipes($aantal){

        $aantal = 0;

        $selectedRecipes = 0;

        while ($aantal < $selectedRecipes){

            $selectedRecipes = $this->selectRecipe($gerecht_id);

            $aantal += $selectedRecipes;
        } 

        //array_merge? 

        return $aantal;

    }

}