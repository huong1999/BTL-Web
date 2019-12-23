$(".delete-user").click(function(){
    var id = $(this).val();
    var token = $("meta[name='csrf-token']").attr("content");

    $.ajax(
        {
            url: "admin/users/"+id,
            type: 'DELETE',
            data: {
                "id": id,
                "_token": token,
            },
            success: function (data){
                console.log("it Works");
                $('.item' + data['id']).remove();
            },
            error: function (data) {
                console.error('Error:', data);
            }
        });

});
