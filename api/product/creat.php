<?php 


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 

include_once '../../config/database.php';
include_once  '../../model/product/product.php';


$database=new Database();
$db=$database->connect();

$product=new Product($db);

 $data=json_decode(file_get_contents("php://input"));

$product->name=$data->name;
$product->description=$data->description;
$product->price=$data->price;
$product->created=date('Y-m-d');
$product->category_id=$data->category_id;


if ($product->creat()) 
{
	echo json_encode(array('message'=>'Product Created '));
}

else 
{
	echo json_encode(array('message'=>'Product Not Created '));
}




