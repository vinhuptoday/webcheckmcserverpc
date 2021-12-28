    $('#ske-ip').keypress(function( e ) {
    if(e.which === 32) 
        return false;
});
    //Post APi Server
    $(".ske-check").on('click', function() {
        var button_check = $(".ske-check");
        button_check.html("Đang kiểm tra");
        $(".result").html('<center><div class="ske-spinner"></div></center>');
        $.ajax({
          url: '/apis/api.php',
          type: 'POST',
          data: {
            address: $("#ske-ip").val(),
            access: 1
        },
        success: function(s) {
            $(".result").html(s);
            button_check.html("Kiểm tra");
            window.location.href="#ske-result";
        }
    });
    });