var action = 'update';
                   $.ajax({
                       url: "action.php",
                       method: "POST",
                       data: {id:id, user_coin:user_coin, action:action},                       
                       success: function(data)
                       {
                           console.log(data);
                           $('#user_coin').val(data.user_coin);
                           //$('#action').val('update');
                           //$('#hidden_id').val(id);
                       }

                   });