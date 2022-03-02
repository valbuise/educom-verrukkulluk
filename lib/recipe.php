<?php 

class recipe {

   private $connection;
   private $gerecht;
   private $user;
   private $ingredient;
   private $gerecht_info;
   private $record_type;



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


   public function selectRating($gerecht_info_id){
       
        $sql = "select * from gerecht_info where id = $gerecht_info_id";

        $result = mysqli_query($this->connection, $sql);
       
        $array = mysqli_fetch_array($result, MYSQLI_ASSOC);

        //return $array;

            if ($array['record_type'] == 'W'){

            $sql = "select nummeriekveld from gerecht_info where id = $gerecht_info_id";

            $result = mysqli_query($this->connection, $sql);
            
            $rating = mysqli_fetch_array($result, MYSQLI_ASSOC);

            return $rating;        
            
                        
            }
        }



    public function selectSteps($gerecht_id){

        $sql = "select * from gerecht_info where id = $gerecht_id";

        $result = mysqli_query($this->connection, $sql);

        $array = mysqli_fetch_array($result, MYSQLI_ASSOC);

        //return $array;
        
        while ($array['record_type'] == 'B'){

            $sql = "select nummeriekveld, tekstveld from gerecht_info";

            $result = mysqli_query($this->connection, $sql);

            $steps = mysqli_fetch_array($result, MYSQLI_ASSOC);

            return $steps;
        }
    }    




   public function selectRecipe($gerecht_id, $record_type){

        $sql = "select * from gerecht where id = $gerecht_id";
    
        $result = mysqli_query($this->connection, $sql);

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

            $user = $this->user->selectUser($row['user_id']);

            $ingredient = $this->ingredient->selectIngredient($gerecht_id);

            

            if ($record_type == 'O' || $record_type == 'B' || $record_type == 'W'){ 

                $gerecht_info = $this->gerecht_info->selectInfo($gerecht_id, $record_type);
                
                $gerecht[] = array_merge($row, $user, $ingredient, $gerecht_info);
                
                        
               
                //$gerecht_info = array_merge($row, $user);          
             }

            
            $gerecht[] = array_merge($row, $user, $ingredient);


          
            
        }

        return $gerecht;



    }


}