$( document ).ready(function() {
    $("#formSignin").submit(function(e){
        e.preventDefault()
        
        $.ajax({
            url: '/login',
            method:'POST',
            data: $("#formSignin").serialize(),
          })
          .done(function(data) {
            data = JSON.parse(data);
            if (!data.success)
            {
                if (data.loginError) {
                    $("#loginError").html(data.loginError);
                    $("#passError").html("");
                }
                if (data.passError) {
                    $("#passError").html(data.passError);
                    $("#loginError").html("");
                }
            }
            else 
            {
                $("#loginModal").modal("hide");    
                location.reload();
            }
          })
          .fail(function() {
            console.log( "error" );
          });
    });
});