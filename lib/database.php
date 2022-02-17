<?php 

// Aanpassen naar je eigen omgeving
define("USER", "root");
define("PASSWORD", "root");
define("DATABASE", "verrukkulluk");
define("HOST", "localhost");

class database {

    private $connection;

    public function __construct() {
       $this->connectie = mysqli_connect(HOST, 
                                         DATABASE, 
                                         USER, 
                                         PASSWORD);
    }

    public function getConnection() {
        return($this->connection);
    }

}