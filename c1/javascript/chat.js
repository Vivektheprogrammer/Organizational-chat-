const form = document.querySelector(".typing-area"),  // Select the form with class 'typing-area'
incoming_id = form.querySelector(".incoming_id").value,  // Get the value of the hidden input field with class 'incoming_id'
inputField = form.querySelector(".input-field"),  // Select the input field with class 'input-field'
sendBtn = form.querySelector("button"),  // Select the send button inside the form
chatBox = document.querySelector(".chat-box");  // Select the chat box element with class 'chat-box'

form.onsubmit = (e) => {
    e.preventDefault();  // Prevent the form from submitting the traditional way
}

inputField.focus();  // Focus the input field when the page loads
inputField.onkeyup = () => {
    if(inputField.value != ""){  // Check if the input field is not empty
        sendBtn.classList.add("active");  // Add 'active' class to the send button
    } else {
        sendBtn.classList.remove("active");  // Remove 'active' class from the send button
    }
}

sendBtn.onclick = () => {
    let xhr = new XMLHttpRequest();  // Create a new XMLHttpRequest object
    xhr.open("POST", "php/insert-chat.php", true);  // Open a POST request to 'insert-chat.php'
    xhr.onload = () => {
      if(xhr.readyState === XMLHttpRequest.DONE){  // Check if the request is complete
          if(xhr.status === 200){  // Check if the status is OK
              inputField.value = "";  // Clear the input field
              scrollToBottom();  // Scroll to the bottom of the chat box
          }
      }
    }
    let formData = new FormData(form);  // Create a FormData object with the form data
    xhr.send(formData);  // Send the form data to the server
}

chatBox.onmouseenter = () => {
    chatBox.classList.add("active");  // Add 'active' class to the chat box when the mouse enters
}

chatBox.onmouseleave = () => {
    chatBox.classList.remove("active");  // Remove 'active' class from the chat box when the mouse leaves
}

setInterval(() => {
    let xhr = new XMLHttpRequest();  // Create a new XMLHttpRequest object
    xhr.open("POST", "php/get-chat.php", true);  // Open a POST request to 'get-chat.php'
    xhr.onload = () => {
      if(xhr.readyState === XMLHttpRequest.DONE){  // Check if the request is complete
          if(xhr.status === 200){  // Check if the status is OK
            let data = xhr.response;  // Get the response data
            chatBox.innerHTML = data;  // Update the chat box with the new data
            if(!chatBox.classList.contains("active")){  // Check if the chat box is not active
                scrollToBottom();  // Scroll to the bottom of the chat box
            }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  // Set the request header for form data
    xhr.send("incoming_id=" + incoming_id);  // Send the 'incoming_id' to the server
}, 500);  // Repeat every 500 milliseconds

function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;  // Scroll to the bottom of the chat box
}
