
$(document).on('click', function (e) {
    var target = e.target;

    console.log($(target));
    console.log($(target).parents());
    console.log($('.popup-wrapper').hasClass('active'));
    if ( ($(target).is('.add-to-calendar_btn') || $(target).parents().is('.add-to-calendar_btn')) && !$('.popup-wrapper').hasClass('active')) {
        $('.popup-wrapper').addClass('active');
    } else if (!$(target).is('.popup-wrapper') && !$(target).parents().is('.add-to-calendar_btn') && $('.popup-wrapper').hasClass('active')) {
        $('.popup-wrapper').removeClass('active');
    }
});



//document.querySelector('#calendar-wrapper').appendChild(myCalendar);