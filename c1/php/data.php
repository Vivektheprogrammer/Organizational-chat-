<?php
    // Loop through each row fetched from the query result
    while($row = mysqli_fetch_assoc($query)){
        
        // Construct SQL query to fetch the latest message for this user
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']}
                OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id} 
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
        
        // Execute the SQL query
        $query2 = mysqli_query($conn, $sql2);
        
        // Fetch the result row from the query result
        $row2 = mysqli_fetch_assoc($query2);
        
        // Determine the latest message content or display a default message if none exists
        (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="No message available";
        
        // Shorten the message content if it exceeds 28 characters
        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
        
        // Determine if the message is sent by the current user or received from another user
        if(isset($row2['outgoing_msg_id'])){
            ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
        }else{
            $you = "";
        }
        
        // Determine the status of the user (online or offline)
        ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
        
        // Determine if the user is the current user (hide current user's own profile)
        ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";

        // Generate HTML content for displaying user profile in the list
        $output .= '<a href="chat.php?user_id='. $row['unique_id'] .'">
                    <div class="content">
                    <img src="php/images/'. $row['img'] .'" alt="">
                    <div class="details">
                        <span>'. $row['fname']. " " . $row['lname'] .'</span>
                        <p>'. $you . $msg .'</p>
                    </div>
                    </div>
                    <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                </a>';
    }
?>
