<?php

$db_connection_status = mysqli_connect("localhost", "root", "", "web_technology_assignment");

if ($db_connection_status === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}

$connection = $db_connection_status;

// GET Request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        
        $sql = "SELECT * FROM comments";
        
        $result = mysqli_query($connection, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $comments = array();
            
            while ($row = mysqli_fetch_assoc($result)) {
                $comments[] = $row;
            }
            
            echo json_encode($comments);
        } else {
            echo "No records found";
        }
    }

// POST request to insert data
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product = $_POST['product'];
    $user_id = $_POST['user_id'];
    $rating = $_POST['rating'];
    $image = $_POST['image'];
    $text = $_POST['text'];
    
    $sql = "INSERT INTO comments (product, user_id, rating, image, text) 
            VALUES ('$product', '$user_id', '$rating', '$image', '$text')";
    
        if (mysqli_query($connection, $sql)) {
            echo "Record inserted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    }

// PUT to update the data in the table
else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    $product = $data['product'];
    $user_id = $data['user_id'];
    $rating = $data['rating'];
    $image = $data['image'];
    $text = $data['text'];
    
    $sql = "UPDATE comments 
            SET product='$product',
             user_id='$user_id',
             rating='$rating', 
             image='$image',
             text='$text' 
            WHERE user_id='$user_id'";
    
        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    } 


//DELETE request to delete data
else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);

    $user_id = $data['user_id'];
    
    $sql = "DELETE FROM comments WHERE user_id='$user_id'";
    
    if (mysqli_query($connection, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }
} 

mysqli_close($connection);
?>