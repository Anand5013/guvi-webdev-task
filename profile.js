$(document).ready(function() {
  // Get the username from localStorage
  var username = localStorage.getItem('username');
  $('#profile-heading').text('Welcome ' + username);

  // Retrieve user data and display it
  $.getJSON('users.json', function(data) {
    var user = data.find(function(user) {
      return user.username === username;
    });

    if (user) {
      var phone = user.phone ? user.phone : '';
      var dob = user.dob ? user.dob : '';
      var address = user.address ? user.address : '';
      $('#phone').val(phone);
      $('#dob').val(dob);
      $('#address').val(address);
    }
  });

  // Update user data
  $('#update-btn').click(function() {
    var phone = $('#phone').val();
    var dob = $('#dob').val();
    var age = calculateAge(dob);
    var address = $('#address').val();

    // Modify the data object to include the username
    var postData = {
      phone: phone,
      dob: dob,
      age: age,
      address: address,
      username: username
    };

    $.ajax({
      url: 'update.php',
      type: 'POST',
      data: postData,
      success: function(response) {
        if (response == 'Update successful') {
          // Display the updated user data in the "Updated details" section
          $('#updated-details').html(
            'Phone: ' + phone +
            '<br>DOB: ' + dob +
            '<br>Age: ' + age +
            '<br>Address: ' + address
          );
          alert('Updated successfully');
        } else {
          alert('Couldn\'t Update');
        }
      }
    });
  });
});

function calculateAge(dateString) {
  var today = new Date();
  var birthDate = new Date(dateString);
  var age = today.getFullYear() - birthDate.getFullYear();
  var monthDiff = today.getMonth() - birthDate.getMonth();
  if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }
  return age;
}
