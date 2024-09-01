<?php 
  // Start the PHP session and include the database configuration file
  session_start();
  include_once "php/config.php";
  
  // Redirect to login page if the user is not logged in
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }
?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <!-- Chat Area Section -->
    <section class="chat-area">
      <header>
        <?php 
          // Get the user ID of the chat partner from the URL query parameter
          $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
          
          // SQL query to retrieve information about the chat partner
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
          
          // Check if the user exists
          if(mysqli_num_rows($sql) > 0){
            // Fetch user details
            $row = mysqli_fetch_assoc($sql);
          }else{
            // Redirect to the users page if the user does not exist
            header("location: users.php");
          }
        ?>
        <!-- Header with chat partner details -->
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="php/images/<?php echo $row['img']; ?>" alt="">
        <div class="details">
          <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
          <p><?php echo $row['status']; ?></p>
        </div>
      </header>
      <!-- Chat box to display messages -->
      <div class="chat-box">

      </div>
      <!-- Form for typing messages -->
      <form action="#" class="typing-area">
        <!-- Hidden input field to store the ID of the chat partner -->
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <!-- Input field for typing messages -->
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <!-- Button to send messages -->
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <!-- JavaScript file for handling chat functionality -->
  <script src="javascript/chat.js"></script>

</body>
</html>
