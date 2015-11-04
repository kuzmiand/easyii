$(function() {

    var body = $('body');
    body.off('click', '.confirm-delete').on('click', '.confirm-delete', function(){
        var button = $(this).addClass('disabled');
        var title = button.attr('title');

        if(confirm(title ? title+'?' : 'Confirm the deletion')){
            if(button.data('reload')){
                return true;
            }
            $.getJSON(button.attr('href'), function(response){
                button.removeClass('disabled');
                if(response.result === 'success'){
                    notify.success(response.message);
                    button.closest('li').fadeOut(function(){
                        this.remove();
                    });
                } else {
                    alert(response.error);
                }
            });
        }
        return false;
    });

});