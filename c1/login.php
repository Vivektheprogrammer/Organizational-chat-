<?php 
  session_start();
  // Redirect to users.php if user is already logged in
  if(isset($_SESSION['unique_id'])){
    header("location: users.php");
  }
?>

<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <!-- Login form section -->
    <section class="form login">
      <!-- Header with the title of the chat app -->
      <header>Realtime Chat App</header>
      <!-- Login form -->
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <!-- Error message display area -->
        <div class="error-text"></div>
        <!-- Email address input field -->
        <div class="field input">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="Enter your email" required>
        </div>
        <!-- Password input field -->
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter your password" required>
          <!-- Password visibility toggle icon -->
          <i class="fas fa-eye"></i>
        </div>
        <!-- Submit button field -->
        <div class="field button">
          <input type="submit" name="submit" value="Continue to Chat">
        </div>
      </form>
      <!-- Link to signup page for users who are not yet signed up -->
      <div class="link">Not yet signed up? <a href="index.php">Signup now</a></div>
    </section>
  </div>
  
  <!-- JavaScript file for password visibility toggle -->
  <script src="javascript/pass-show-hide.js"></script>
  <!-- JavaScript file for login form validation and submission -->
  <script src="javascript/login.js"></script>

</body>
</html>
