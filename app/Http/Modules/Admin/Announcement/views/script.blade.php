<script>
    $(document).ready(function () {
        $("#a_add").click(function(){
            var message = "";
            var title = $.trim($(".a_title").val());
            var date = $.trim($(".a_date").val());
            var from = $.trim($(".a_from").val());
            var token = "<?php echo csrf_token(); ?>";
            var details = $.trim(tinymce.get('announcement_details').getContent());

            if(title == ""){message += "Please input announcement title \n"};
            if(details == ""){message += "Please input announcement details \n"};
            if(date == ""){message += "Please input announcement date \n"};
            if(from == ""){message += "Please input announcement from"};

            if(message != ""){
                alert(message);
                return false;
            }else{
                var data = {
                    "title": title,
                    "details": details,
                    "date": date,
                    "from": from,
                    "_token": token
                }
            }

            //send ajax
            ajax_send(data,"/admin/announcement");

            //empty input in modal
            emptyModal();
        });

        $("#close").click(function(){
            //empty input in modal
            emptyModal();
        });

        //open modal confirmation
        $(".a_delete").click(function(){
            var id = $(this).attr("data");

            //modal confirmed
            $("#a_confirm").click(function(){
                //send ajax
                ajax_send("", "/admin/announcement/delete/" + id);
            });
        });

        $(".a_edit").click(function(){
            var id = $(this).attr("data");
            ajax_send("","/admin/announcement/edit/"+ id);

            $("#e_confirm").click(function(){
                var message = "";
                var title = $.trim($(".edit_title").val());
                // var details = $.trim($(".edit_details").val());
                var details = $.trim(tinymce.get('e_announcement_details').getContent());
                var date = $.trim($(".edit_date").val());
                var from = $.trim($(".edit_from").val());
                var token = "<?php echo csrf_token(); ?>";

                if(title == ""){message += "Please input announcement title \n"};
                if(details == ""){message += "Please input announcement details \n"};
                if(date == ""){message += "Please input announcement date \n"};
                if(from == ""){message += "Please input announcement from"};

                if(message != ""){
                    alert(message);
                    return false;
                }else{
                    var data = {
                        "title": title,
                        "details": details,
                        "date": date,
                        "from": from,
                        "_token": token
                    }

                    //send ajax to update
                    ajax_send(data,"/admin/announcement/update/"+ id);
                }
            });
        });

        $(".a_status").click(function(){
            var id = $(this).attr("data");
            ajax_send("","/admin/announcement/status/"+id);
        });

        $( ".date" ).datetimepicker({
            format:'YYYY-MM-DD',
        });

        function ajax_send(data, url){
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: url,
                data: data,
                success: function(res){
                    if(res == "success"){
                        location.reload();
                    }else{
                        tinymce.remove();
                        $(".edit_title").val(res[0].announcement_title);
                        $(".edit_details").val(res[0].announcement_details);
                        $(".edit_date").val(res[0].display_date);
                        $(".edit_from").val(res[0].announcement_from);
                        tinymce.init({ selector:'textarea' });
                    }
                }
            });
        }

        function emptyModal(){
            $(".a_title").val("");
            $(".a_details").val("");
            $(".a_date").val("");
            $(".a_from").val("");
        }
    });
tinymce.init({ selector:'textarea' });
</script>