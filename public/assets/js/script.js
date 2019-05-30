
var myCalendar = createCalendar({
    options: {
        class: 'calendar',

        // You can pass an ID. If you don't, one will be generated for you
        id: 'my-id'
    },
    data: {
        // Event title
        title: 'Get on the front page of HN',

        // Event start date
        start: new Date(document.querySelector('#calendar-wrapper').dataset.entryDate),

        // Event duration (IN MINUTES)
        duration: 120,

        // You can also choose to set an end time
        // If an end time is set, this will take precedence over duration,

        // Event Address
        address: 'Народная ул., 12, Москва, Россия, 115172',

        // Event Description
        description: 'Get on the front page of HN, then prepare for world domination.'
    }
});
console.log('test');
document.querySelector('#calendar-wrapper').appendChild(myCalendar);