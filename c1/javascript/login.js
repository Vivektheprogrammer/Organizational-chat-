const form = document.querySelector(".login form"),  // Select the form element inside the element with class 'login'
continueBtn = form.querySelector(".button input"),  // Select the input button inside the form with class 'button'
errorText = form.querySelector(".error-text");  // Select the element with class 'error-text' inside the form

form.onsubmit = (e) => {
    e.preventDefault();  // Prevent the form from submitting the traditional way to handle submission via AJAX
}

continueBtn.onclick = () => {
    let xhr = new XMLHttpRequest();  // Create a new XMLHttpRequest object for AJAX request
    xhr.open("POST", "php/login.php", true);  // Open a POST request to 'login.php'
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {  // Check if the request is complete
            if (xhr.status === 200) {  // Check if the status is OK (200)
                let data = xhr.response;  // Get the response data from the server
                if (data === "success") {  // Check if the response data is "success"
                    location.href = "users.php";  // Redirect to 'users.php' if login is successful
                } else {
                    errorText.style.display = "block";  // Display the error text element
                    errorText.textContent = data;  // Show the error message from the server response
                }
            }
        }
    }
    let formData = new FormData(form);  // Create a FormData object from the form data
    xhr.send(formData);  // Send the form data to the server
}
