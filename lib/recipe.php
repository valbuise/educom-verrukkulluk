<?php 

class recipe {

   private $connection;
   private $gerecht;
   private $user;
   private $ingredient;
   private $gerecht_info;
   private $record_type;
   private $allRatings;



   public function __construct($connection){
       $this->connection = $connection;
       $this->user = new user ($connection);
       $this->ingredient = new ingredient ($connection);
       $this->gerecht_info = new recipeinfo ($connection);
   }


   private function selectUser($user_id){
      $user = $this->user->selectUser($user_id);
      return $user;
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


   
   public function selectRecipe($gerecht_id){

        $sql = "select * from gerecht where id = $gerecht_id";
    
        $result = mysqli_query($this->connection, $sql);

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

            $user = $this->selectUser($row['user_id']);

            $ingredient = $this->selectIngredient($gerecht_id);

            $rating = $this->selectInfo($gerecht_id, 'W');
            
            $avgRating = $this->selectInfo(calcRating($allRatings)); 

            $steps = $this->selectInfo($gerecht_id, 'B');

            $remarks = $this->selectInfo($gerecht_id, 'O');





            
            $gerecht[] = array_merge($row, $user, $ingredient, $rating, $avgRating, $steps, $remarks);


          
            
        }

        return $gerecht;



    }


}