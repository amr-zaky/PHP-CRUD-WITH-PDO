<?php 


class Product
{
	
	private $conn;
	private $table='products';
	public $id;
	public $name;
	public $description;
	public $price;
	public $category_id;
	public $crated;
	public $modified;

	
	function __construct($db)
	{
		$this->conn=$db;
	}

	public function read()
	{

		$sql='SELECT c.name as category_name ,p.id,p.name,p.description,p.price,p.category_id,p.created FROM  '.$this->table.' p LEFT JOIN categories c ON p.category_id=c.id ORDER BY p.created DESC';

		$res=$this->conn->prepare($sql);
		$res->execute();

		return $res; 
	}


	public function creat()
	{

		$sql='INSERT INTO '.$this->table.' SET 
			name=:name,
			description =:description,
			price =:price,
			category_id =:category_id,
			created=:created
		';

		$res=$this->conn->prepare($sql);
		$this->name =htmlspecialchars(strip_tags($this->name));
		$this->description =htmlspecialchars(strip_tags($this->description));
		$this->price =htmlspecialchars(strip_tags($this->price));
		$this->category_id=htmlspecialchars(strip_tags($this->category_id));
		$this->created =htmlspecialchars(strip_tags($this->created));

		$res->bindParam(':name',$this->name);
		$res->bindParam(':description',$this->description);
		$res->bindParam(':price',$this->price);
		$res->bindParam(':category_id',$this->category_id);
		$res->bindParam(':created',$this->created);

		if($res->execute())
		{
			return true ;
		}

		return false;


	}


	public function readone()
	{
		$sql='SELECT c.name as category_name ,p.id,p.name,p.description,p.price,p.category_id,p.created FROM  '.$this->table.' p LEFT JOIN categories c ON p.category_id=c.id WHERE p.id= ? LIMIT 0,1';

		$res=$this->conn->prepare($sql);

		$this->id=htmlspecialchars(strip_tags($this->id));

		$res->bindParam(1,$this->id);


		$res->execute();

		$row=$res->fetch(PDO::FETCH_ASSOC);
		$this->name=$row['name'];
		$this->price=$row['price'];
		$this->description=$row['description'];
		$this->category_id=$row['category_id'];
		$this->category_name=$row['category_name'];

		}


	public function update()
	{
		$sql='UPDATE '.$this->table.' SET 

			name=:name,
			description =:description,
			price =:price,
			category_id =:category_id,
			created=:created 
			WHERE 
			id=:id
			';


		$res=$this->conn->prepare($sql);
		$this->id=htmlspecialchars(strip_tags($this->id));
		$this->name =htmlspecialchars(strip_tags($this->name));
		$this->description =htmlspecialchars(strip_tags($this->description));
		$this->price =htmlspecialchars(strip_tags($this->price));
		$this->category_id=htmlspecialchars(strip_tags($this->category_id));
		$this->created =htmlspecialchars(strip_tags($this->created));

		$res->bindParam(':id',$this->id);
		$res->bindParam(':name',$this->name);
		$res->bindParam(':description',$this->description);
		$res->bindParam(':price',$this->price);
		$res->bindParam(':category_id',$this->category_id);
		$res->bindParam(':created',$this->created);

		if($res->execute())
		{
			return true ;
		}

		return false;		

	}



	public function delete($keyword)
	{

		$sql='DELETE FROM '.$this->table.' WHERE id=:id';
		$res=$this->conn->prepare($sql);
		$this->id=htmlspecialchars(strip_tags($this->id));
		$res->bindParam(':id',$this->id);

		if($res->execute())
		{
			return true ;
		}

		return false;
	}	

	public function search($keyword)
	{

		$sql="SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table. " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
            ORDER BY
                p.created DESC";





	    $res=$this->conn->prepare($sql);
	 	$keyword=htmlspecialchars(strip_tags($keyword));
	 	$keyword="%{$keyword}%";			 
	 	
	 	$res->bindParam(1,$keyword);
	 	$res->bindParam(2,$keyword);
	 	$res->bindParam(3,$keyword);

	 	$res->execute();
		return $res;


	}
}

