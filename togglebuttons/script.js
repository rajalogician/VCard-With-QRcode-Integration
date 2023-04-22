const loginText = document.querySelector(".title-text .login");
const loginForm = document.querySelector("form.login");
const loginBtn = document.querySelector("label.login");
const signupBtn = document.querySelector("label.signup");
const signupLink = document.querySelector("form .signup-link a");
signupBtn.onclick = (() => {
    loginForm.style.marginLeft = "-50%";
});
loginBtn.onclick = (() => {
    loginForm.style.marginLeft = "0%";
});
signupLink.onclick = (() => {
    signupBtn.click();
    return false;
});
var myLoginAction =
        {
            collect_data: function (e, data_type)
            {
                e.preventDefault();
                e.stopPropagation();

                var inputs = document.querySelectorAll("form.login input[type='text'], form.login input[type='password']");
                let myform = new FormData();
                myform.append('data_type', data_type);

                for (var i = 0; i < inputs.length; i++) {

                    myform.append(inputs[i].name, inputs[i].value);
                }

                myLoginAction.send_data(myform);
            },

            send_data: function (form)
            {

                var ajax = new XMLHttpRequest();

                ajax.addEventListener('readystatechange', function () {

                    if (ajax.readyState === 4)
                    {
                        if (ajax.status === 200)
                        {
                            //all good
                            myLoginAction.handle_result(ajax.responseText);
                        } else {
                            console.log(ajax);
                        }
                    }
                });

                ajax.open('post', 'ajax.php', true);
                ajax.send(form);
            },

            handle_result: function (result)
            {
                console.log(result);
                var obj = JSON.parse(result);
                if (obj.success)
                {
                    window.location.href = 'profile-edit.php';
                } else {

                    //show errors
                    let error_inputs = document.querySelectorAll(".js-error");

                    //empty all errors
                    for (var i = 0; i < error_inputs.length; i++) {
                        error_inputs[i].innerHTML = "";
                    }

                    //display errors
                    for (key in obj.errors)
                    {
                        document.querySelector(".login .js-error-" + key).innerHTML = obj.errors[key];
                    }
                }
            }
        };

//script to toggle login password visibility
const togglePassword = document.querySelector("#toggleLoginPassword");
const password = document.querySelector("#loginPassword");

togglePassword.addEventListener("click", function () {
    // toggle the type attribute
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);

    // toggle the icon
    this.classList.toggle("bi-eye-fill");
});

//script to toggle signup password visibility
const toggleSignupPassword = document.querySelector("#toggleSignupPassword");
const signupPassword = document.querySelector("#signupPassword");

toggleSignupPassword.addEventListener("click", function () {
    // toggle the type attribute
    const type = signupPassword.getAttribute("type") === "password" ? "text" : "password";
    signupPassword.setAttribute("type", type);

    // toggle the icon
    this.classList.toggle("bi-eye-fill");
});

//signup scripts
var mySignupAction =
        {
            collect_data: function (e, data_type)
            {
                e.preventDefault();
                e.stopPropagation();

                var inputs = document.querySelectorAll("form.signup input[type='text'], form.signup input[type='password'], form.signup input[type='email']");
                let myform = new FormData();
                myform.append('data_type', data_type);

                for (var i = 0; i < inputs.length; i++) {

                    myform.append(inputs[i].name, inputs[i].value);
                }

                mySignupAction.send_data(myform);
            },

            send_data: function (form)
            {

                var ajax = new XMLHttpRequest();

                ajax.addEventListener('readystatechange', function () {

                    if (ajax.readyState == 4)
                    {
                        if (ajax.status == 200)
                        {
                            //all good
                            mySignupAction.handle_result(ajax.responseText);
                        } else {
                            console.log(ajax);
                        }
                    }
                });

                ajax.open('post', 'ajax.php', true);
                ajax.send(form);
            },

            handle_result: function (result)
            {
                console.log(result);
                var obj = JSON.parse(result);
                if (obj.success)
                {
                    window.location.href = 'login.html';
                } else {

                    //show errors
                    let error_inputs = document.querySelectorAll(".js-error");

                    //empty all errors
                    for (var i = 0; i < error_inputs.length; i++) {
                        error_inputs[i].innerHTML = "";
                    }

                    //display errors
                    for (key in obj.errors)
                    {
                        document.querySelector(".signup .js-error-" + key).innerHTML = obj.errors[key];
                    }
                }
            }
        };