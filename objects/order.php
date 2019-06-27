<?php
class Order{
 
    // database connection and table name
    private $conn;
    private $table_name = "master2";
 
    // object properties
    public $id;
    public $item_code;
	public $item_type;
	public $dimension;
    public $description;
	public $selling_price;
    public $status;
	public $image;
    public $aws;
    public $collection;
    public $submitted_date;
	public $approved_date;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	
	function read(){
		
		// select all query
		$query = 'SELECT * FROM ' . $this->table_name ;
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
}

