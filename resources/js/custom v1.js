$(document).ready(function(){
    $("#select_plan").change(function(){
        var plan_id = $(this).val();
        $.ajax({
            url:"/gym_management/get-plan",
            type:'GET',
            data:{'plan_id' : plan_id},
            success: function(response) {
                console.log(response);
                $('.plan_amount').val(response);
            }
        })
    });


    $("#exampleInputMobile").on("input", function () {
        let value = $(this).val();
        
        // Remove non-numeric characters
        value = value.replace(/\D/g, '');

        // Limit input to 10 digits
        if (value.length > 10) {
            value = value.substring(0, 10);
        }

        $(this).val(value);
    });

    $("#exampleInputMobile").on("blur", function () {
        if ($(this).val().length !== 10) {
            alert("Mobile number must be exactly 10 digits.");
            // $(this).val(""); // Clear input
        }
    });


    $('#payment_btn').click(function(){
        var paid_amount = $('#payment_amount').val();
        var member_id = $('#member_id').val();
        var amount  = $('#original_amount').val();

        $.ajax({
            url:"/gym_management/add-payment",
            type:'GET',

            data:{
                    'paid_amount' : paid_amount, 
                    'member_id' : member_id,
                    'amount' : amount,
                },
            success: function(response) {
                $('#payment_btn').text('Please wait...');
                
                if(response.msg_class == 'alert-success'){
                    $('.alert-payment').show().addClass(response.msg_class).text(response.message);
                    $('#payment_btn').text('Pay');
                    $('#payment_amount').val(response.rem_amount);
                } else {
                    $('.alert-payment').show().addClass(response.msg_class).text(response.message);
                    $('#payment_btn').text('Pay');
                }
            }
        })
    });


    // copy url link

    $(".copy_link").click(function(){
        var url = $('#referl_link');
        url.select();
        document.execCommand('Copy');
        $('#alert_copy_link').show().text('URL copied successfully.');
        setTimeout(() => {
            $('#alert_copy_link').hide();
        }, 1500);
    });

    setTimeout(() => {
        $('.alert').fadeOut();
    }, 1500);

})


    

