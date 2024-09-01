const form = document.querySelector(".signup form"),  // Select the form element within the signup form
continueBtn = form.querySelector(".button input"),  // Select the input button within the button class in the form
errorText = form.querySelector(".error-text");  // Select the element for displaying error text

form.onsubmit = (e) => {  // Add an event listener to the form's submit event
    e.preventDefault();  // Prevent the default form submission behavior
}

continueBtn.onclick = () => {  // Add an event listener to the continue button for the click event
    let xhr = new XMLHttpRequest();  // Create a new XMLHttpRequest object for AJAX
    xhr.open("POST", "php/signup.php", true);  // Initialize a POST request to 'signup.php'
    xhr.onload = () => {  // Define a function to handle the response when the request completes
        if(xhr.readyState === XMLHttpRequest.DONE){  // Check if the request is complete
            if(xhr.status === 200){  // Check if the response status is 'OK' (200)
                let data = xhr.response;  // Get the response data from the server
                if(data === "success"){  // Check if the response data indicates success
                    location.href = "users.php";  // Redirect to 'users.php' on successful signup
                }else{
                    errorText.style.display = "block";  // Display the error text element
                    errorText.textContent = data;  // Set the error text content to the response data
                }
            }
        }
    }
    let formData = new FormData(form);  // Create a FormData object from the form element
    xhr.send(formData);  // Send the form data to the server
}
