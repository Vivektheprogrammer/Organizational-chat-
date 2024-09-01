const searchBar = document.querySelector(".search input"),  // Select the input element inside the search class
searchIcon = document.querySelector(".search button"),  // Select the button element inside the search class
usersList = document.querySelector(".users-list");  // Select the element that contains the list of users

searchIcon.onclick = () => {  // Add a click event listener to the search button
  searchBar.classList.toggle("show");  // Toggle the "show" class on the search input
  searchIcon.classList.toggle("active");  // Toggle the "active" class on the search button
  searchBar.focus();  // Focus on the search input
  if(searchBar.classList.contains("active")){  // If the search input has the "active" class
    searchBar.value = "";  // Clear the search input value
    searchBar.classList.remove("active");  // Remove the "active" class from the search input
  }
}

searchBar.onkeyup = () => {  // Add a keyup event listener to the search input
  let searchTerm = searchBar.value;  // Get the current value of the search input
  if(searchTerm != ""){  // If the search input is not empty
    searchBar.classList.add("active");  // Add the "active" class to the search input
  } else {
    searchBar.classList.remove("active");  // Remove the "active" class from the search input
  }
  let xhr = new XMLHttpRequest();  // Create a new XMLHttpRequest object for AJAX
  xhr.open("POST", "php/search.php", true);  // Initialize a POST request to 'search.php'
  xhr.onload = () => {  // Define a function to handle the response when the request completes
    if(xhr.readyState === XMLHttpRequest.DONE){  // Check if the request is complete
        if(xhr.status === 200){  // Check if the response status is 'OK' (200)
          let data = xhr.response;  // Get the response data from the server
          usersList.innerHTML = data;  // Update the users list with the response data
        }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  // Set the request header for form data
  xhr.send("searchTerm=" + searchTerm);  // Send the search term to the server
}

setInterval(() => {  // Set an interval to execute a function repeatedly
  let xhr = new XMLHttpRequest();  // Create a new XMLHttpRequest object for AJAX
  xhr.open("GET", "php/users.php", true);  // Initialize a GET request to 'users.php'
  xhr.onload = () => {  // Define a function to handle the response when the request completes
    if(xhr.readyState === XMLHttpRequest.DONE){  // Check if the request is complete
        if(xhr.status === 200){  // Check if the response status is 'OK' (200)
          let data = xhr.response;  // Get the response data from the server
          if(!searchBar.classList.contains("active")){  // If the search input does not have the "active" class
            usersList.innerHTML = data;  // Update the users list with the response data
          }
        }
    }
  }
  xhr.send();  // Send the request to the server
}, 500);  // Repeat every 500 milliseconds
