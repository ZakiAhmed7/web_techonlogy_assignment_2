<?php

$db_connection_status = mysqli_connect("localhost", "root", "", "web_technology_assignment");

if ($db_connection_status === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}

$connection = $db_connection_status;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $sql = "SELECT * FROM orders";
    
        $result = mysqli_query($connection, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $orders = array();
            
            while ($row = mysqli_fetch_assoc($result)) {
                $orders[] = $row;
            }
            
            echo json_encode($orders);
        } else {
            echo "No records found";
        }
    }

// POST
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $order_number = $_POST['order_number'];
    $recording_of_a_sale = $_POST['recording_of_a_sale'];
    
    $sql = "INSERT INTO orders (user_id, product_id, order_number, recording_of_a_sale) 
            VALUES ('$user_id', '$product_id', '$order_number', '$recording_of_a_sale')";
    
    if (mysqli_query($connection, $sql)) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }
} 
//uPDATE order details - PUT 
else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $data = json_decode(file_get_contents("php://input"), true);
    
    $user_id = $data['user_id'];
    $product_id = $data['product_id'];
    $order_number = $data['order_number'];
    $recording_of_a_sale = $data['recording_of_a_sale'];
    
    $sql = "UPDATE user 
            SET user_id='$user_id', 
                product_id='$product_id',
                order_number='$order_number', 
                recording_of_a_sale='$recording_of_a_sale' 
            WHERE user_id='$user_id'";
    
        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    }


//DELETE  delete data
else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    $order_number = $data['order_number'];
    
    $sql = "DELETE FROM orders WHERE order_number='$order_number'";
    
        if (mysqli_query($connection, $sql)) {
            echo "Record deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    }


mysqli_close($connection);
?>