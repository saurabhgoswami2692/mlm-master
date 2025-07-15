$("#user_form").submit(function(event){
    event.preventDefault();
    var formData = new FormData(this);

    $(".user-btn-submit").text('Please wait...');
    $(".btn-login").addClass('disable-click');
    $.ajax({
        url:registerUrl,
        type:'POST',
        data:formData,
        dataType:'json',
        processData: false, // Required for FormData
        contentType: false, // Required for FormData
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
        },
        success:function(response){
            if(response.class == 'alert-success'){
                $("#alert-message").show().addClass('alert-success').text(response.message);
                $(".user-btn-submit").text('Redirecting to the login page...');
                $(".btn-login").removeClass('disable-click');
                
                setTimeout(() => {
                    window.location.href = response.redirect_url;
                }, 1000); // Optional delay

            } else {
                $("#alert-message").show().addClass('alert-danger').text(response.message);        
            }
                
            $(".user-btn-submit").text('Register');
        
            setTimeout(() => {
                $("#alert-message").fadeOut(500).removeClass(response.msg_class);
            }, 1500);
        }
    });
});


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

