class ApiCalls {

    // Initializing variables.
    constructor() {
        this.url = '';
        this.current_comic_number = 0;
        this.headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        };
    }

    // Checks the otp-session( of 5 minutes ) and returns the availability in boolean.
    async check_session() {
        this.url       = 'server/apis/check-session.php';
        const response = await fetch( this.url, { headers: this.headers } );
        const res_obj  = await response.json();

        let is_session_available = false;

        if ( res_obj.success ) {
            is_session_available = true;
        }

        return is_session_available;
    }

    // Fetches a random comic and returns the comic object.
    async get_random_comic( comic_num = 0 ) {
        if ( comic_num > 0 ) {
            this.url = `server/apis/get-comic.php?number=${ comic_num }`;
        } else {
            this.url = `server/apis/get-comic.php?number=${ Math.floor( Math.random() * 2475 ) + 1 }`;
        }

        let comic      = {};
        const response = await fetch( this.url, { headers: this.headers } );
        const res_obj  = await response.json();

        if ( res_obj.success ) {
            comic = res_obj['comic'];
        }

        return comic;
    }

    // Sends mail to user with a 4 digit one time password( OTP ).
    async generate_otp( email ) {
        this.url = 'server/apis/send-verification-mail.php';
        let body = new FormData();
        body.append( 'email', email );

        const response = await fetch( this.url, {
            method : 'POST',
            body   : body,
        } );

        const res_obj  = await response.json();
        let success = false;

        if ( res_obj.success ) {
            success = true;
        }

        return success;
    }

    // Checks if the otp entered by the user is correct or not.
    async check_otp( email, otp ) {
        this.url = 'server/apis/verify-otp.php';
        let body = new FormData();
        body.append( 'email', email );
        body.append( 'otp', otp );

        const response = await fetch( this.url, {
            method : 'POST',
            body   : body,
        } );

        const res_obj = await  response.json();
        let success = false;

        if ( res_obj.success ) {
            success = true;
        }

        return success;
    }
}

const api_call      = new ApiCalls();
const otp_input     = document.getElementById( 'otp' );
const email_input   = document.getElementById( 'email' );
const comic_img     = document.getElementById( 'comic-img' );
const comic_title   = document.getElementById( 'comic-title' );
const popup_msg     = document.getElementById( 'popup-msg' );
const popup_msg_box = document.getElementById( 'popup-msg-box' );
let timeout;

// Checks the otp-session of user and accordingly displays the otp input box accordingly.
let check_session = function () {
    api_call.check_session().then( is_session_available => {
        if ( is_session_available ) {
            otp_input.style.display       = 'block';
            otp_input.attributes.required = 'required';
        } else {
            otp_input.style.display       = 'none';
            otp_input.attributes.required = '';
        }
    } );
}

// Sets a random/chosen comic on the home page.
let set_comic = function ( comic_number = 0 ) {
    comic_img.src         = '/app/assets/images/loading.jpg';
    comic_title.innerText = 'Loading';

    api_call.get_random_comic( comic_number ).then( comic => {
        if ( Object.entries( comic ).length !== 0 ) {
            api_call.current_comic_number = comic.num;
            comic_img.src                 = comic.img;
            comic_title.innerText         = comic.title;
        } else {
            api_call.current_comic_number = 0;
            comic_img.src                 = '/app/assets/images/error.jpg';
            comic_img.innerText           = 'Cannot Load Comic';
        }
    } );
}

// Fetches and displays the next comic. i.e. If current comic number is 1 then it will fetch and display comic number 2.
let get_next_comic = function () {
    if ( api_call.current_comic_number < 2475 ) {
        api_call.current_comic_number++;
    } else {
        api_call.current_comic_number = 1;
    }

    set_comic( api_call.current_comic_number );
}

// Fetches and displays the previous comic. i.e. If current comic number is 2 then it will fetch and display comic number 1.
let get_prev_comic = function () {
    if ( api_call.current_comic_number > 1 ) {
        api_call.current_comic_number--;
    } else {
        api_call.current_comic_number = 2475;
    }

    set_comic( api_call.current_comic_number );
}

// Verifies the email address and shows popup according to the result.
let verify_mail = function () {
    popup_msg_box.style.backgroundColor = 'grey';
    popup_msg_box.style.display         = 'flex';

    const email = email_input.value;

    if ( email === '' ) {
        popup_msg.innerText                 = 'Email Required';
        popup_msg_box.style.backgroundColor = 'red';

        clearTimeout( timeout );
        timeout = setTimeout( () => popup_msg_box.style.display = 'none', 5000);
        return;
    }

    if ( otp_input.style.display === 'none' || otp_input.style.display === '' ) {
        popup_msg.innerText = 'Sending Email';

        api_call.generate_otp( email ).then( isSuccessful => {
            if ( isSuccessful ) {
                popup_msg.innerText                 = 'Email Send';
                popup_msg_box.style.backgroundColor = 'green';
            } else {
                popup_msg.innerText                 = 'Failed';
                popup_msg_box.style.backgroundColor = 'red';
            }
        } );
    } else {
        const otp = otp_input.value;

        popup_msg.innerText         = 'Checking OTP';
        popup_msg_box.style.display = 'flex';

        api_call.check_otp( email, otp ).then( isSuccessful => {
            if ( isSuccessful ) {
                popup_msg.innerText                 = 'Success';
                popup_msg_box.style.backgroundColor = 'green';
            } else {
                popup_msg.innerText                 = 'Failure';
                popup_msg_box.style.backgroundColor = 'red';
            }
        } );
    }

    clearTimeout( timeout );
    timeout = setTimeout( () => popup_msg_box.style.display = 'none', 5000);
    check_session();
}

// Closes the popup if its open.
let close_popup = function () {
    popup_msg_box.style.display = 'none';
}

check_session(); // Checking if user has generated otp before and its still valid.
set_comic(); // Setting a random comic initially.