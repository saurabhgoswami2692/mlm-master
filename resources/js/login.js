$("#login_form").submit(function(event){
    event.preventDefault();
    var formData = new FormData(this);
    $('.login-btn').text('Please wait...');
    $.ajax({
        url:loginUrl,
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

                $('.login-btn').text('Redirecting...');
                setTimeout(() => {
                    window.location.href = response.redirect_url; // Redirect to dashboard
                }, 1000); // Optional delay
                
            } else {    
                $('#alert-message').show().addClass(response.msg_class).text(response.message);
                $('.login-btn').text('Login');
            }

            setTimeout(() => {
                $('#alert-message').hide().removeClass(response.msg_class).text('');
            }, 1500);
        }
    });
});