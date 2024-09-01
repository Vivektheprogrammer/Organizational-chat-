const pswrdField = document.querySelector(".form input[type='password']"),  // Select the password input field inside the element with class 'form'
toggleIcon = document.querySelector(".form .field i");  // Select the icon inside the element with class 'field' in the form

toggleIcon.onclick = () => {  // Add an event listener to the icon for the 'click' event
  if (pswrdField.type === "password") {  // Check if the password field's type is 'password'
    pswrdField.type = "text";  // Change the type to 'text' to make the password visible
    toggleIcon.classList.add("active");  // Add the 'active' class to the icon to indicate the password is visible
  } else {
    pswrdField.type = "password";  // Change the type back to 'password' to hide the password
    toggleIcon.classList.remove("active");  // Remove the 'active' class from the icon
  }
}
