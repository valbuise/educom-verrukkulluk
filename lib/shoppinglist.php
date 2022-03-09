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




    public function addToList($gerecht_id){

     
        $list = [];

        $ingredients = $this->selectIngredient($gerecht_id); 
         
        while($ingredients){                 // dit lijkt een infinite loop te geven? Al snap ik niet waarom (want er zit een max.
                                             // aantal elementen in de array $ingredients?)

            $list[] = [
                "artikel_id" => $ingredients[0]['artikel_id'],
                "verpakking" => $ingredients[0]['verpakking'],
            ];                                          // Hoe ik ook probeer de juiste elementen te 
                                                        //selecteren en toe te voegen, ik kom er (tot nog toe) niet...

        }
      

        return $list;


    }    

}