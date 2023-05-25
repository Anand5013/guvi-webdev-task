$(document).ready(function() {
    $('#signup-btn').click(function(event) {
      event.preventDefault(); // Prevent the default form submission
  
      var username = $('#username').val();
      var password = $('#password').val();
      var email = $('#email').val();
      $.ajax({
        url: 'signup.php',
        type: 'POST',
        data: {username: username, password: password, email: email},
        success: function(response) {
          if (response.includes('Signup successful')) {
            alert('Signup successful');
            window.location.href = 'login.html';
          } else {
            alert('Couldn\'t signup');
          }
        }
      });
    });
  });
  