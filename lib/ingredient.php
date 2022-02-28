<?php

class ingredient {

    private $connection;
    private $artikel;


    private function selectArtikel($artikel_id){  
        $artikel = $this->artikel->selectArtikel($artikel_id);
        return $artikel;
    }



    public function __construct($connection){
        $this->connection = $connection;
        $this->artikel = new artikel($connection);
    }



    public function selectIngredient($gerecht_id, $artikel_id){
             
        $sql = "select * from ingredient where gerecht_id = $gerecht_id and artikel_id = $artikel_id";

        $result = mysqli_query($this->connection, $sql);

        $ingredient[] = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $artikel = $this->selectArtikel($artikel_id);

        $artEnIng[] = array_merge($ingredient, $artikel);

        return($artEnIng);
    }

}