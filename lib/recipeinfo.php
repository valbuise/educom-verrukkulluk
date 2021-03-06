<?php


class recipeinfo{

    //class eigenschappen aanmaken:

    private $connection;
    private $user;
    




    
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

            if ($record_type == 'O' || $record_type == 'F'){      
                
               $user = $this->selectUser($row['user_id']);        
              
               $gerecht_info[] = array_merge($row, $user);  

            } else { 
                
                $gerecht_info[] = $row;

            }

                                                                       
        }

        return($gerecht_info);
    }


    public function addFavorite($gerecht_id, $user_id){            

        $this->deleteFavorite($gerecht_id, $user_id);// de deleteFavorite functie hier callen, zodat een user niet oneindig hetzelfde gerecht kan toevoegen als favoriet;

        $sql = "insert into gerecht_info (record_type, gerecht_id, user_id) values ('F', '$gerecht_id', '$user_id')"; // user (id) slaat gerecht (id) op als F(avoriet);

        $result = mysqli_query($this->connection, $sql);

        return(true);
    }


    public function deleteFavorite($gerecht_id, $user_id){

        $sql = "delete from gerecht_info where record_type = 'F' and gerecht_id = $gerecht_id and user_id = $user_id"; // user (id) verwijderd gerecht (id) als F(avoriet);

        $result = mysqli_query($this->connection, $sql);
        
        return(true);
    }


}