/*
| Script By Emeke Osuagwu @dev_emeka emekaosuagwuandela@gmail.com
| Description LoginAndSigup script in create to handel ajax call
| for Suyabay Login and Register funtionality and also and Email for
| user registeration.
*/

/*
| ajaxLogic
| Process ajaxCall data and return feedback base on the data
| receives 3 parameter from ajaxClass
| @data is the array of user infomation \\console.log(data) to see properties
| @response is the ajax response coming from the api end ponit
| @funtionName is the name of the fuction called
*/
function ajaxLogic(data, response, functionName) {
    if (response.status_code === 401) {
        switch (functionName) {
            case 'login':
                loginErrorAlert();
                break;
            case 'register':
                registerErrorAlert();
                break;
        }
    } else if (response.status_code === 200) {
        switch (functionName) {
            case 'login':
                swal(
                    'Login successful',
                    'You have succesfully sign in',
                    'success'
                );
                window.location = '/';
                break;
            case 'register':
                registerSuccessAlert(data);
                break;
        }
    }

}

/*
| ajaxCall
| send an ajax post request to the api end post
| receives 2 parameter from register function or login function
| @data is the array of user infomation \\console.log(data) to see properties
| @funtionName is the name of the fuction called
|*/
function ajaxCall(data, functionName) {
    $('.loader').show();
    $.post(data.url, data.parameter)
        .done(function(response) {
            ajaxLogic(data, response, functionName);
        })
        .fail(function(response) {
            console.log('this action is bad')
        })
}

/*
| loginErrorAlert
| gives error report to user
*/
function loginErrorAlert() {
    $('.loader').hide();
    swal('Oops! Login Failed', 'Username or Password not found!', 'error');
}

/*
| registerSuccessAlert
| gives Success report to user
| receives 1 parameter
*/
function registerSuccessAlert(data) {
    swal({
            title: data.parameter.username +
                ' Your SuyaBay account has been successfully created',
            text: 'Send Email Confirmation',
            type: 'success',
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function() {
            setTimeout(function() {
                swal('Email Confirmation sent to ' + data.parameter.email);
            }, 2000);
            clearField();
            window.location = '/';
        });
}

/*
| registerErrorAlert
| gives error report to user
| receives 1 parameter
*/
function registerErrorAlert() {
    $('.loader').hide();
    swal(
        'Oops! Registration Failed',
        'Username or Email already exists click the button to try again!',
        'error'
    );
}

/*
| register
| create user information and url in to an array of object i.e @data
| and make and ajax class to function ajaxCall()
| by sending @data and @functionName
*/
function register() {
    var data = {
        url: '/signup',
        parameter: {
            _token: $('#token').val(),
            email: $('#email').val(),
            username: $('#username').val(),
            password: $('#password').val(),
            facebook: $('#facebook').val(),
            twitter: $('#twitter').val()
        }
    }
    preventFormDefault('.form')
    checkItem(data);
    var functionName = arguments.callee.name;
    ajaxCall(data, functionName);
}


/*
| login
| create user information and url in to an array of object i.e @data
| and make and ajax class to function ajaxCall()
| by sending @data and @functionName
*/
function login() {
    var functionName = arguments.callee.name;
    var data = {
        url: '/login',
        parameter: {
            _token: $('#token').val(),
            username: $('#username').val(),
            password: $('#password').val()
        }
    }
    preventFormDefault('.form');
    ajaxCall(data, functionName);
}

function checkItem(data) {

    if (
        data.parameter.email == '' ||
        data.parameter.username == '' || data.parameter.password == '') {
        swal('Oops!', 'Some required field not set!', 'error');
        end();
    }

    if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(
            data.parameter.email)) {
        swal('Oops!', 'Invalid email', 'error');
        end();
    }
}

/*
| Prevent element Default action
*/
function preventFormDefault(element) {
    $(element).submit(function(e) {
        e.preventDefault();
    });
}

/*
| Clears field
*/
function clearField() {
    $('#email').val('');
    $('#token').val('');
    $('#username').val('');
    $('#password').val('');
}
