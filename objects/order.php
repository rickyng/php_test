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
	// create product
	function create(){
	 
		// query to insert record
		$query = "INSERT INTO
					" . $this->table_name . "
				SET
					name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->price=htmlspecialchars(strip_tags($this->price));
		$this->description=htmlspecialchars(strip_tags($this->description));
		$this->category_id=htmlspecialchars(strip_tags($this->category_id));
		$this->created=htmlspecialchars(strip_tags($this->created));
	 
		// bind values
		$stmt->bindParam(":name", $this->name);
		$stmt->bindParam(":price", $this->price);
		$stmt->bindParam(":description", $this->description);
		$stmt->bindParam(":category_id", $this->category_id);
		$stmt->bindParam(":created", $this->created);
	 
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}
}

