<?php
    $db_connection_status = mysqli_connect("localhost", "root", "", "web_technology_assignment");

    if ($db_connection_status === false) {
        die("Error: Could not connect. " . mysqli_connect_error());
    }

    //Read
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        $sql_query = "SELECT * FROM product";

        $result = mysqli_query($db_connection_status, $sql_query);

        if(mysqli_num_rows($result) > 0) {
            $products = array();

            while($row = mysqli_fetch_assoc($result)) {
                $products[] = $row;
            }
            echo json_encode($products);
        } else {
            echo "No record found";
        }
    } else {
        echo "Method not allowed";
    }

    // Create
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $product_name = $_POST['product_name'];
        $description = $_POST['description'];
        $image = $_POST['image'];
        $pricing = $_POST['pricing'];
        $shipping_cost = $_POST['shipping_cost'];
    

        $sql_query = "INSERT INTO product (product_name, description, image, pricing, shipping_cost)
                    VALUES ('
                    $product_name', '$description', '$image', '$pricing', '$shipping_cost')";
    
        if(mysqli_query($db_connection_status, $sql_query)) {
            echo "Record inserted successfully";
        } else {
            echo "Error: " . $sql . "<br>". mysqli_error($db_connection_status); 
        }
    } else {
        echo "Method not allowed";
    }

    //update
    if($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $data = json_decode(file_get_contents("php://input"), true);

        $product_id = data['product_id'];
        $product_name = $data['product_name'];
        $description = $data['description'];
        $image = $data['image'];
        $pricing = $data['pricing'];
        $shipping_cost = $data['shipping_cost'];

        $sql_query = "UPDATE product 
                        SET product_id='$product_id',
                        product_name='product_name',
                        description='$description',
                        image='$image',
                        pricing='$pricing',
                        shipping_cost='$shipping_cost'";

        if(mysqli_query($db_connection_status, $sql_query)) {
            echo "Recorde update successfully";
        } else {
            echo "Error: " . $sql. "<br>" . mysqli_error($db_connection_status);
        }
    } else {
        echo "Method not provided";
    }

    // Delete
    if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $data = json_decode(file_get_contents("php://input"), true);

        $product_id = $data['product_id'];

        $sql_query = "DELETE FROM product WHERE product_id='$product_id'";

        if(mysqli_query($db_connection_status, $sql_query)) {
            echo "Record deleted successfully";
        } else {
            echo "Error:  " .$sql. "<br>". mysqli_error($db_connection_status);
        }
    } else {
        echo "Method not allowed";
    }

    mysqli_close($db_connection_status);
?>