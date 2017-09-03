$(document).ready(function(){
    function __init(){
        item();
    }
    
    function item() {
        updateFields();
        if ($(".koran-banners-form").length > 0) {
            $(".form__select").on("change", function(){
                updateFields();
            });
            
        }
    }
    
    function updateFields() {
        if ($("[name=type]").val() == 0) {
            $("[name=width]").val("").parent().fadeOut();
            $("[name=height]").val("").parent().fadeOut();

            $("[name=title]").parent().fadeIn();
        } else {
            $("[name=title]").val("").parent().fadeOut();

            $("[name=width]").parent().fadeIn();
            $("[name=height]").parent().fadeIn();
        }
    }
    
    __init();
});


