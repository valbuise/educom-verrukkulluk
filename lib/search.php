<?php 

class zoek {

    private $gerecht;
    
    
    public function __construct($connection) {
        $this->connection = $connection;
        $this->gerecht = new recipe($connection);      
    }


    public function zoek($keyword){

        $zoekterm = strtolower($keyword);
        $gerechtenBieb = $this->gerecht->selectRecipe();

        $gevonden_gerechten = [];

        foreach($gerechtenBieb as $gerecht){

            $gerecht_text = strtolower(json_encode($gerecht));
            $result = strpos($gerecht_text, $zoekterm);

            if($result){
                $gevonden_gerechten[] = $gerecht;
            }
        }

        return $gevonden_gerechten;
    } 


}

?>