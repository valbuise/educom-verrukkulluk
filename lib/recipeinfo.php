<?php


class recipeinfo{

    //class eigenschappen aanmaken:

    private $connection;
    private $user;
    private $favorite;




    // de 'setters':

    public function __construct($connection){
        $this->connection = $connection;
        $this->user = new user($connection);
    }




    private function selectUser($user_id){  
        $user = $this->user->selectUser($user_id);
        return $user;
    }




    public function selectInfo($gerecht_id, $record_type){
        
       $gerecht_info = []; 
       
        $sql = "select * from gerecht_info where gerecht_id = $gerecht_id and record_type = '$record_type'";
        
        $result = mysqli_query($this->connection, $sql);
        
        
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){ 
     
            $gerecht_info[] = $row;                               

            if ($record_type == 'O' || $record_type == 'F'){      
                
               $user = $this->selectUser($row['user_id']);        
              
               $gerecht_info = array_merge($row, $user);          
            }

                                                                       
        }

        return($gerecht_info);
    }


    public function addFavorite($gerecht_id, $user_id){ //volgorde nog niet definitief: gehele functie dient straks nog getest te worden.           

        $favorite = [];

        $sql = //hier ga ik een regel schrijven waar er een F wordt toegevoegd aan record_type, voor welk user_id dit is en welk gerecht_id;

        $result = mysqli_query($this->connection, $sql);

        $favorite[] = $result;

        return($favorite);
    }


    public function deleteFavorite($recept_id, $user_id){

        
        return($favorite);

    }


}