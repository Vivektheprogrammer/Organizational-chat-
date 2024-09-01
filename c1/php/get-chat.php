<?php 
    // Start the PHP session
    session_start();
    
    // Check if the user is logged in
    if(isset($_SESSION['unique_id'])){
        
        // Include the database configuration file
        include_once "config.php";
        
        // Get the outgoing user's unique ID from the session
        $outgoing_id = $_SESSION['unique_id'];
        
        // Get the incoming user's unique ID from the POST request
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        
        // Initialize an empty string to store the HTML output
        $output = "";
        
        // Construct the SQL query to fetch messages between the two users
        $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
        
        // Execute the SQL query
        $query = mysqli_query($conn, $sql);
        
        // Check if there are messages available
        if(mysqli_num_rows($query) > 0){
            
            // Loop through each message
            while($row = mysqli_fetch_assoc($query)){
                
                // Check if the message is outgoing (sent by the current user)
                if($row['outgoing_msg_id'] === $outgoing_id){
                    // If outgoing, display the message on the right side
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                                </div>';
                }else{
                    // If incoming, display the message on the left side along with the sender's image
                    $output .= '<div class="chat incoming">
                                <img src="php/images/'.$row['img'].'" alt="">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                                </div>';
                }
            }
        }else{
            // If no messages available, display a message
            $output .= '<div class="text">No messages are available. Once you send a message, it will appear here.</div>';
        }
        
        // Output the HTML content
        echo $output;
        
    }else{
        // If the user is not logged in, redirect to the login page
        header("location: ../login.php");
    }
?>
