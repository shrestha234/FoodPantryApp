//This function will read the password input fields to make sure the User
//enters a password that matches the requirements
$(document).ready(function () {
    var password = document.getElementById("password");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");
    var confirm_password = document.getElementById("confirm_password");

    password.onkeyup = function () {
        var lowerCaseLetters = /[a-z]/g;
        var upperCaseLetters = /[A-Z]/g;
        var numbers = /[0-9]/g;

        if (password.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
            if (password.value.match(upperCaseLetters)) {
                capital.classList.remove("invalid");
                capital.classList.add("valid");
                if (password.value.match(numbers)) {
                    number.classList.remove("invalid");
                    number.classList.add("valid");
                    if (password.value.length >= 9) {
                        length.classList.remove("invalid");
                        length.classList.add("valid");
                        if (password.value === confirm_password.value) {
                            document.getElementById("match").style.color = '#32CD32';

                        }
                    }
                }

            }
        } else {
            letter.classList.add("invalid");
            letter.classList.remove("valid");
            capital.classList.add("invalid");
            capital.classList.remove("valid");
            number.classList.add("invalid");
            number.classList.remove("valid");
            length.classList.add("invalid");
            length.classList.remove("valid");
            document.getElementById("match").style.color = '#ff0000';
        }
    }

    confirm_password.onkeyup = function () {
        if (confirm_password.value === password.value) {
            document.getElementById("match").style.color = '#32CD32';

        } else {
            document.getElementById("match").style.color = '#ff0000';
        }
    }

});
