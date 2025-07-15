$("#plan_form").submit(function(event){
    event.preventDefault();
    var formData = new FormData(this);
    $(".btn-plan-submit").text('Please wait...');
    $.ajax({
        url:planStoreUrl,
        type:'POST',
        data:formData,
        dataType:'json',
        processData: false, // Required for FormData
        contentType: false, // Required for FormData
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
        },
        success:function(response){
            if(response.msg_class == 'alert-success'){
                $("#alert-message").show().addClass('alert-success').text(response.message);
                $('#planname, #planduration, #planprice').val('');
            } else {
                $("#alert-message").show().addClass('alert-danger').text(response.message);        
            }
            $(".btn-plan-submit").text('Submit');

            setTimeout(() => {
                $("#alert-message").fadeOut(500).removeClass(response.msg_class);
            }, 1500);
        }
    });
});


