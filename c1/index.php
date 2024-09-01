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
    <!-- Signup form section -->
    <section class="form signup">
      <!-- Header with the title of the chat app -->
      <header>Realtime Chat App</header>
      <!-- Signup form -->
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <!-- Error message display area -->
        <div class="error-text"></div>
        <!-- First and last name fields -->
        <div class="name-details">
          <!-- First name input field -->
          <div class="field input">
            <label>First Name</label>
            <input type="text" name="fname" placeholder="First name" required>
          </div>
          <!-- Last name input field -->
          <div class="field input">
            <label>Last Name</label>
            <input type="text" name="lname" placeholder="Last name" required>
          </div>
        </div>
        <!-- Email address input field -->
        <div class="field input">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="Enter your email" required>
        </div>
        <!-- Password input field -->
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter new password" required>
          <!-- Password visibility toggle icon -->
          <i class="fas fa-eye"></i>
        </div>
        <!-- Image upload field -->
        <div class="field image">
          <label>Select Image</label>
          <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
        </div>
        <!-- Submit button field -->
        <div class="field button">
          <input type="submit" name="submit" value="Continue to Chat">
        </div>
      </form>
      <!-- Link to login page for already signed up users -->
      <div class="link">Already signed up? <a href="login.php">Login now</a></div>
    </section>
  </div>

  <!-- JavaScript file for password visibility toggle -->
  <script src="javascript/pass-show-hide.js"></script>
  <!-- JavaScript file for signup form validation and submission -->
  <script src="javascript/signup.js"></script>

</body>
</html>
