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

$product->id=$data->id;


$result=$product->readone();

$product_arr=array(

	"id"=>$product->id,
	"name" => $product->name,
    "description" => $product->description,
    "price" => $product->price,
    "category_id" => $product->category_id,
    "category_name" => $product->category_name
);


print_r(json_encode($product_arr));


