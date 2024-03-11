<?php
$db_connection_status = mysqli_connect("localhost", "root", "", "web_technology_assignment");

if ($db_connection_status === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}

$connection = $db_connection_status;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $sql = "SELECT * FROM cart";
        
        $result = mysqli_query($connection, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $cart = array();
            
            while ($row = mysqli_fetch_assoc($result)) {
                $cart[] = $row;
            }
            echo json_encode($cart);
        } else {
            echo "No records found";
        }
    } 
    // POST request to insert data
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $products = $_POST['products'];
    $quantities = $_POST['quantities'];
    
    $sql = "INSERT INTO cart (user_id, products, quantities) 
            VALUES ('$user_id', '$products', '$quantities')";
    
    if (mysqli_query($connection, $sql)) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }
} 
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    $user_id = $data['user_id'];
    $products = $data['products'];
    $quantities = $data['quantities'];
    
    $sql = "UPDATE cart 
            SET user_id='$user_id', products='$products', quantities='$quantities' 
            WHERE user_id='$user_id'";
    
    if (mysqli_query($connection, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }
}


// DELETE request to delete data
else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    $user_id = $data['user_id'];
    
    $sql = "DELETE FROM cart WHERE user_id='$user_id'";
    
    if (mysqli_query($connection, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }
}

// Close the connection
mysqli_close($connection);
?>