<?php 

// Aanpassen naar je eigen omgeving
define("USER", "root");
define("PASSWORD", "");
define("DATABASE", "db");
define("HOST", "127.0.0.1");

//database class wordt aangemaakt, inclusief 'dependency injection'.
class database {

    private $connection;

    public function __construct() {
       $this->connection = mysqli_connect(HOST, 
                                         USER, 
                                         PASSWORD,
                                         DATABASE);
    }

    public function getConnection() {
        return($this->connection);
    }

}