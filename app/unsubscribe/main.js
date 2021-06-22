const email_input   = document.getElementById( 'email' );
const popup_msg     = document.getElementById( 'popup-msg' );
const popup_msg_box = document.getElementById( 'popup-msg-box' );
let timeout;

// Unsubscribes the user from the mailing service if the service is availed.
let unsubscribe_call = async function ( email ) {
    let url  = '/server/apis/unsubscribe.php';
    let body = new FormData();
    body.append( 'email', email );

    const response = await fetch( url, {
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

// Shows the popup according to the response of unsubscribe_call().
let unsubscribe_service = function () {
    popup_msg.innerText            = 'Unsubscribing...';
    popup_msg_box.style.background = 'grey';
    popup_msg_box.style.display    = 'flex';

    if ( email_input.value !== '' ) {
        unsubscribe_call( email_input.value ).then( isSuccessful => {
            if ( isSuccessful ) {
                popup_msg.innerText                 = 'Success!';
                popup_msg_box.style.backgroundColor = 'green';
            } else {
                popup_msg.innerText                 = 'Failed!';
                popup_msg_box.style.backgroundColor = 'red';
            }
        } );
    } else {
        popup_msg.innerText                 = 'Email Required';
        popup_msg_box.style.backgroundColor = 'red';
    }

    clearTimeout( timeout );
    timeout = setTimeout( () => popup_msg_box.style.display = 'none', 5000);
}

// Closes the pop if its open.
let close_popup = function () {
    popup_msg_box.style.display = 'none';
}
