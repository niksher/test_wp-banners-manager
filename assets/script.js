$(document).ready(function(){
    function __init() {
        item();
        datePicker();
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
    
    function datePicker() {
        if ($(".koran-banners-form").length > 0) {
            $("[name=validFrom]").dateTimePicker({
                mode: 'dateTime',
                monthName: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
                dayName: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                format: 'yyyy-MM-ddTHH:mm:ss'
            });
            $("[name=validUntil]").dateTimePicker({
                mode: 'dateTime',
                monthName: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
                dayName: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                format: 'yyyy-MM-ddTHH:mm:ss'
            });
        }
        
    }
    
    
    __init();
});


