const signUpButton=document.getElementById('signUpButton');
const signInButton=document.getElementById('signInButton');
const signInForm=document.getElementById('signIn');
const signUpForm=document.getElementById('signup');

signUpButton.addEventListener('click',function(){
    signInForm.style.display="none";
    signUpForm.style.display="block";
})
signInButton.addEventListener('click', function(){
    signInForm.style.display="block";
    signUpForm.style.display="none";
})
document.getElementById('password').addEventListener('input', function(event) {
    const password = event.target.value;
    let messages = [];
    if (!/[A-Z]/.test(password)) {
        messages.push('Use at least one uppercase letter.');
    }
    if (!/[a-z]/.test(password)) {
        messages.push('Use at least one lowercase letter.');
    }
    if (!/[0-9]/.test(password)) {
        messages.push('Use at least one number.');
    }
    if (!/[@$!%*#?&]/.test(password)) {
        messages.push('Use at least one special character like @$!%*#?&.');
    }
    if (password.length <=8) {
        messages.push('Password must be at least 8 characters long.');
    }

    document.getElementById('passwordHelp').innerHTML = messages.join('<br>');
    document.getElementById('passwordHelp').style.color = messages.length > 0 ? 'red' : 'green';
});
document.getElementById('fName').addEventListener('input', function(event) {
    this.value = this.value.replace(/[^a-zA-Z ]/g, '');
});

document.getElementById('lName').addEventListener('input', function(event) {
    this.value = this.value.replace(/[^a-zA-Z ]/g, '');
});

// Function to toggle tabs for the schedule section
function toggleTab(tabId) {
    var tabs = document.getElementById('scheduleTabs').getElementsByClassName('tab-section');
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].style.display = 'none';
    }
    document.getElementById(tabId).style.display = 'block';

    // Hide "Add Content" button if "Edit Content" or "View Content" tab is clicked
    if (tabId === 'editSchedule' || tabId === 'viewSchedule') {
        document.getElementById('addContentButton').style.display = 'none';
    } else {
        document.getElementById('addContentButton').style.display = 'block';
    }
}

// Function to toggle tabs for the achievements section
function toggleTab(tabId) {
    var tabs = document.getElementById('achievementTabs').getElementsByClassName('tab-section');
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].style.display = 'none';
    }
    document.getElementById(tabId).style.display = 'block';

    // Hide "Add Achievement" button if "Edit Achievement" or "Delete Achievement" tab is clicked
    if (tabId === 'editAchievement' || tabId === 'deleteAchievement') {
        document.getElementById('addAchievementButton').style.display = 'none';
    } else {
        document.getElementById('addAchievementButton').style.display = 'block';
    }
}
