$(document).ready(function() {
    $('#login-btn').click(function() {
      var username = $('#username').val();
      var password = $('#password').val();
      $.ajax({
        url: 'login.php',
        type: 'POST',
        data: {username: username, password: password},
        success: function(response) {
          if (response == 'Login successful') {
            // Store the username in localStorage
            localStorage.setItem('username', username);
            alert('Logged-In successful');
            window.location.href = 'profile.html';
          } else {
            alert('Couldn\'t Login');
          }
        }
      });
    });
  });
  