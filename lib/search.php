<?php 

$button = isset($_POST['submit']) ? $_POST['submit'] : "";
$search = isset($_POST['search']) ? $_POST['search'] : "";

class search {

    private $search;


    public function __construct($connection){
        $this->connection = $connection;
    }

    public function searchDatabase($search){

        $sql = "select * from gerecht where match(titel, korte_omschrijving, lange_omschrijving, afbeelding) against ('%".$search."%')";
        $result = mysqli_query($this->connection, $sql);
        $foundnum = mysqli_num_rows($result);

        if($foundnum == 0){
            echo "We were unable to find a match with a searchterm of $search";
        }
        else {
            echo "<h1>$foundnum Results found for \"" .$search."\"</h1>";
            $sql = "select * from gerecht where match(titel, korte_omschrijving, lange_omschrijving, afbeelding) against ('%".$search."%')";
            $result = mysqli_query($this->connection, $sql);

            while($row = mysqli_fetch_array($result)){

                echo"<h5 class='card-title'>".$row['titel']."</h5>";
                echo"<h5 class='card-title'>".$row['korte_omschrijving']."</h5>";
                echo"<h5 class='card-title'>".$row['lange_omschrijving']."</h5>";
            }

        }
    }
}

?>