<?php
    // Start the PHP session
    session_start();

    // Include the database configuration file
    include_once "config.php";

    // Sanitize and retrieve form data
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if all required fields are not empty
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        // Validate email format
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            // Check if the email already exists in the database
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0){
                // If the email already exists, return an error message
                echo "$email - This email already exists!";
            }else{
                // Handle image upload if provided
                if(isset($_FILES['image'])){
                    // Retrieve image details
                    $img_name = $_FILES['image']['name'];
                    $img_type = $_FILES['image']['type'];
                    $tmp_name = $_FILES['image']['tmp_name'];
                    
                    // Extract image extension
                    $img_explode = explode('.',$img_name);
                    $img_ext = end($img_explode);
    
                    // Define allowed extensions
                    $extensions = ["jpeg", "png", "jpg"];
                    
                    // Check if the uploaded file is an image
                    if(in_array($img_ext, $extensions) === true){
                        // Define allowed image types
                        $types = ["image/jpeg", "image/jpg", "image/png"];
                        
                        // Check if the image type is allowed
                        if(in_array($img_type, $types) === true){
                            // Generate unique file name
                            $time = time();
                            $new_img_name = $time.$img_name;
                            
                            // Move the uploaded file to the server
                            if(move_uploaded_file($tmp_name,"images/".$new_img_name)){
                                // Generate a random unique ID for the user
                                $ran_id = rand(time(), 100000000);
                                
                                // Set user status to active
                                $status = "Active now";
                                
                                // Encrypt the password
                                $encrypt_pass = md5($password);
                                
                                // Insert user data into the database
                                $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                                                    VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
                                if($insert_query){
                                    // Retrieve user data from the database
                                    $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                    if(mysqli_num_rows($select_sql2) > 0){
                                        $result = mysqli_fetch_assoc($select_sql2);
                                        // Set session with user's unique ID
                                        $_SESSION['unique_id'] = $result['unique_id'];
                                        // Return success message
                                        echo "success";
                                    }else{
                                        echo "This email address does not exist!";
                                    }
                                }else{
                                    echo "Something went wrong. Please try again!";
                                }
                            }
                        }else{
                            echo "Please upload an image file - jpeg, png, jpg";
                        }
                    }else{
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                }
            }
        }else{
            echo "$email is not a valid email!";
        }
    }else{
        echo "All input fields are required!";
    }
?>
