<?php 


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 

include_once '../../config/database.php';
include_once  '../../model/product/product.php';


$database=new Database();
$db=$database->connect();

$product=new Product($db);

$data=isset($_GET['S']) ? $_GET['s'] :"";

$result=$product->search($data);

$num=$result->rowCount();

if($num >0)
{

	$product_arr=array();
	
	while ($row =$result->fetch(PDO::FETCH_ASSOC))
	{
		extract($row);
		$product_item=array(
			"id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
		);
		array_push($product_arr,$product_item);
	}
	echo json_encode($product_arr);
}

else 
{
	echo json_encode(array('message'=>'No Result Found'));
}
