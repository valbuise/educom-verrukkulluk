<?php 

class rating {

    private $connection;
    private $gerecht_info;
    private $gerecht_id;
    private $rating;


    public function __construct($connection){
        $this->connection = $connection;
        $this->gerecht_info = new recipeinfo ($connection);
    }

    public function set_url($url) {                         // experimenteel; dit zou niet moeten hoeven met een werkende AJAX call?
        echo("<script>history.replaceState({},'','$url');</script>");
    }

    public function addRating($gerecht_id, $rating){
        
        $sql = "insert into gerecht_info (record_type, gerecht_id, user_id, nummeriekveld) values ('W', '$gerecht_id', '1', '$rating')"; 

        $result = mysqli_query($this->connection, $sql);

        //$url_set = $this->set_url("index.php?gerecht_id=$gerecht_id&action=detail"); // experimenteel; dit zou niet moeten hoeven met een werkende AJAX call?     

        return(true);
    }
  
}

