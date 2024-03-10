<?php

$db_connection_status = mysqli_connect("localhost", "root", "", "web_technology_assignment");

if ($db_connection_status === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}

$connection = $db_connection_status;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // SQL query to select all data from the user table
        $sql = "SELECT * FROM user";
        
        // Execute the query
        $result = mysqli_query($connection, $sql);
        
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            // Array to store the rows
            $users = array();
            
            // Fetch rows and add them to the users array
            while ($row = mysqli_fetch_assoc($result)) {
                $users[] = $row;
            }
            
            // Output the data as JSON
            echo json_encode($users);
        } else {
            // No rows found
            echo "No records found";
        }
    } else {
        // Method not allowed
        http_response_code(405);
        echo "Method not allowed";
    }

// Step 2: Handle POST request to insert data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $purchase_history = $_POST['purchase_history'];
    $shipping_address = $_POST['shipping_address'];
    
    // SQL query to insert data into the user table
    $sql = "INSERT INTO user (email, password, username, purchase_history, shipping_address) 
            VALUES ('$email', '$password', '$username', '$purchase_history', '$shipping_address')";
    
    // Execute the query
    if (mysqli_query($connection, $sql)) {
        // Insertion successful
        echo "Record inserted successfully";
    } else {
        // Insertion failed
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }
} else {
    // Method not allowed
    http_response_code(405);
    echo "Method not allowed";
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Parse JSON data from the request body
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Extract data
    $user_id = $data['user_id'];
    $email = $data['email'];
    $password = $data['password'];
    $username = $data['username'];
    $purchase_history = $data['purchase_history'];
    $shipping_address = $data['shipping_address'];
    
    // SQL query to update data in the user table
    $sql = "UPDATE user 
            SET email='$email', password='$password', username='$username', 
            purchase_history='$purchase_history', shipping_address='$shipping_address' 
            WHERE user_id='$user_id'";
    
    // Execute the query
    if (mysqli_query($connection, $sql)) {
        // Update successful
        echo "Record updated successfully";
    } else {
        // Update failed
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }
} else {
    // Method not allowed
    http_response_code(405);
    echo "Method not allowed";
}


// Step 2: Handle DELETE request to delete data
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Parse JSON data from the request body
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Extract username
    $username = $data['username'];
    
    // SQL query to delete data from the user table based on username
    $sql = "DELETE FROM user WHERE username='$username'";
    
    // Execute the query
    if (mysqli_query($connection, $sql)) {
        // Deletion successful
        echo "Record deleted successfully";
    } else {
        // Deletion failed
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }
} else {
    // Method not allowed
    http_response_code(405);
    echo "Method not allowed";
}

// Close the connection
mysqli_close($connection);
    ?>