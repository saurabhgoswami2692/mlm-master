$("#payment_request_form").submit(function(event){
    event.preventDefault();
    var formData = new FormData(this);
    // $('#alert-message').hiee();
    $('.payment_request').text('Please wait...');
    $.ajax({
        url:payment_request_url,
        type:'POST',
        dataType:'json',
        data:formData,
        processData: false, // Required for FormData
        contentType: false, // Required for FormData
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
        },
        success:function(response){
            if(response.msg_class == 'alert-success'){

                // $('.payment_request').text('Send Request').attr('disabled',true);
                $('#alert-message').show().addClass(response.msg_class).text(response.message);

                // setTimeout(() => {
                //     window.location.href = response.redirect_url; // Redirect to dashboard
                // }, 1000); // Optional delay
                
            } else {    
                $('#alert-message').show().addClass(response.msg_class).text(response.message);
                $('.payment_request').text('Send Request');
            }

            setTimeout(() => {
                window.location.reload();
                // $('#alert-message').hide().removeClass(response.msg_class).text('');
            }, 3000);
        }
    });
});