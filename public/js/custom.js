// /public/js/custom.js

jQuery(function($) {
    $("#create").on('click', function(event){
        event.preventDefault();
        var $blogentry = $(this);
        $.post("blogentries/add", null,
            function(data){
                if(data.response == true){
                    $blogentry.before("<div class=\"blog-entry\"><textarea id=\"blogentry-"+data.new_note_id+"\"></textarea><a href=\"#\" id=\"remove-"+data.new_note_id+"\"class=\"delete-blog\">X</a></div>");
                // print success message
                } else {
                    // print error message
                    console.log('could not add');
                }
            }, 'json');
    });

    $('#blog-entries').on('click', 'a.delete-blog',function(event){
        event.preventDefault();
        var $blogentry = $(this);
        var remove_id = $(this).attr('id');
        remove_id = remove_id.replace("remove-","");

        $.post("blogentries/remove", {
            id: remove_id
        },
        function(data){
            if(data.response == true)
                $blogentry.parent().remove();
            else{
                // print error message
                console.log('could not remove ');
            }
        }, 'json');
    });

    $('#blog-entries').on('keyup', 'textarea', function(event){
        var $blogentry = $(this);
        var update_id = $blogentry.attr('id'),
        update_content = $blogentry.val();
        update_id = update_id.replace("blogentry-","");

        $.post("blogentries/update", {
            id: update_id,
            content: update_content
        },function(data){
            if(data.response == false){
                // print error message
                console.log('could not update');
            }
        }, 'json');

    });
});
