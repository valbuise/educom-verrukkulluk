<?php 

class kitchenType {
    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
    }

    public function selectKitchenType($keuken_type_id){  

        $sql = "select * from keuken_type where id = $keuken_type_id";

        $result = mysqli_query($this->connection, $sql);
        
        $keuken_type = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($keuken_type);

    }
}
