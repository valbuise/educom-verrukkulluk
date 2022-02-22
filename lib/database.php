<?php 

// Aanpassen naar je eigen omgeving
define("USER", "root");
define("PASSWORD", "Ibahps2019");
define("DATABASE", "db");
define("HOST", "127.0.0.1");

class database {

    private $connection;

    public function __construct() {
       $this->connection = mysqli_connect(HOST, 
                                         DATABASE, 
                                         USER, 
                                         PASSWORD);
    }

    public function getConnection() {
        return($this->connection);
    }

}