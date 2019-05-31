
document.addEventListener("DOMContentLoaded", function(event) {
    var link = document.getElementById("open_map");
    var ua = navigator.userAgent.toLowerCase();
    var mapLink = "";


    if( (navigator.platform.indexOf("iPhone") != -1)
        || (navigator.platform.indexOf("iPod") != -1)
        || (navigator.platform.indexOf("iPad") != -1))
        mapLink = "maps://maps.google.com/maps?daddr=Эстелаб+Москва&amp;ll=";
    else if(ua.indexOf("android") != -1)
        mapLink = "geo:0,0?q=Эстелаб+Москва";
    else
        mapLink = "http://maps.google.com/maps?daddr=Эстелаб+Москва";

    link.setAttribute("href", mapLink);

});


//document.querySelector('#calendar-wrapper').appendChild(myCalendar);


//document.querySelector('#calendar-wrapper').appendChild(myCalendar);