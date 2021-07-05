const popup_msg       = document.getElementById( 'popup-msg' );
const popup_msg_box   = document.getElementById( 'popup-msg-box' );
const lower_container = document.getElementsByClassName( 'lwr-cntanr' )[0];
const timeout_time  = 5000; //In Milli-seconds
let timeout;

// Unsubscribes the user from the mailing service if the service is availed.
let unsubscribe_call = async ( token ) => {
    let url  = '/server/apis/unsubscribe.php';
    let body = new FormData();
    body.append( 'token', token );

    const response = await fetch( url, {
        method : 'POST',
        body   : body,
    } );

    const res_obj  = await response.json();
    let success    = false;

    if ( res_obj.success ) {
        success = true;
    }

    return success;
}

// Shows the popup according to the response of unsubscribe_call().
let unsubscribe_service = ( callback ) => {
    const urlParams = new URLSearchParams(window.location.search);
    const token     = urlParams.get('token');

    popup_msg.innerText            = 'Unsubscribing...';
    popup_msg_box.style.background = 'grey';
    popup_msg_box.style.display    = 'flex';

    if ( token ) {
        unsubscribe_call( token ).then( isSuccessful => {
            if ( isSuccessful ) {
                popup_msg_box.style.display         = 'flex';
                popup_msg.innerText                 = 'Success!';
                popup_msg_box.style.backgroundColor = 'green';
                callback( 'success' );
            } else {
                popup_msg_box.style.display         = 'flex';
                popup_msg.innerText                 = 'Invalid Token!';
                popup_msg_box.style.backgroundColor = 'red';
                callback( 'failure' );
            }
            set_new_timeout();
        } );
    } else {
        popup_msg.innerText                 = 'Token Required';
        popup_msg_box.style.backgroundColor = 'red';
        set_new_timeout();
        callback( 'failure' );
    }

    set_new_timeout();
}

// Start a new count-down time for showing the popup message box.
let set_new_timeout = () => {
    clearTimeout( timeout );
    timeout = setTimeout( () => popup_msg_box.style.display = 'none', timeout_time);
}

// Closes the pop if its open.
let close_popup = () => {
    popup_msg_box.style.display = 'none';
}

// Show the message after Unsubscribing api is called.
let callback_unsubscribe_api = ( result ) => {
    let timer_time = 20;
    const timer    = setInterval( () => {
        if ( result === 'success' ) {
            lower_container.innerHTML = `Unsubscribed Successfully.<br>
                                         You will be automatically redirected after ${timer_time} seconds.<br>
                                         To redirecet manually <a href="/">Click Here</a>`;
        } else {
            lower_container.innerHTML = `Unsubscribing Failed(Check if you have alread unsubscribed the service).<br>
                                         If still facing the issue please write to
                                         <form action="mailto:amaanpathan5@gmail.com" target="_blank" enctype="text/plain">
                                            <input type="submit" value="Developer">
                                         </form>
                                         You will be automatically redirected after ${timer_time} seconds.<br>
                                         To redirecet manually <a href="/">Click Here</a>`;
        }

        if ( --timer_time < 0 ) {
            clearInterval( timer );
            window.location.replace('/');
        }
    }, 1000 );
}

unsubscribe_service( callback_unsubscribe_api ); // Unsubscribe api called with a callback.
