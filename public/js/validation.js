/**
 * This function validates login and registration form.
 */
function validate() {
  // Initializing regex variables.
  var alphabetRegex = /^[a-zA-Z]+$/;
  var phoneRegex = /^\+91\d{10}$/;
  var emailRegex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

  // Getting the values of the input fields.
  var regEmail = document.forms["registration_form"]["registration_form[email]"].value;
  var inputEmailId = $("#inputEmail").val();

  // Initializing variables by targetting the input fields.
  var emailError = $(".emailError");
  var passwordError = $(".passwordError");

  // Initializing empty strings for error variables.
  emailError.text("");
  passwordError.text("");

  // Checking whether the fields are empty or not.
  if (!regEmail || !password) {
    emailError.text("This field shouldn't be empty");
    passwordError.text("This field shouldn't be empty");
    event.preventDefault();
  }

  // Checks for valid email Syntax.
  if (!emailRegex.test(regEmail) && !emailRegex.test(inputEmailId)) {
    emailError.text("Enter a valid email");
    event.preventDefault();
  }

  // Checks for password validation.
  if (!password) {
    passwordError.text("Password field is required");
    event.preventDefault();
  }
}
