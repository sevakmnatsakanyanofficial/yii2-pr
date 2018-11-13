$(document).ready(function () {
    $('#calendar').fullCalendar({
        height: 490,
        customButtons: {
            eventBlockedColor: {
                text: 'The text color is blocked events color',
            },
            eventAcceptedColor: {
                text: 'The text color is accepted events color',
            }
        },
        header: {
            left:   'title',
            center: 'eventBlockedColor,eventAcceptedColor',
            right:  'today agendaDay,agendaWeek,month prev,next'
        },
        defaultView: 'agendaWeek',
        columnFormat: 'ddd',
        longPressDelay: 800,
        // locale: 'ru',
        slotLabelFormat : 'H:mm',
        slotDuration: '00:10:00',
        displayEventTime: true,
        timeFormat: 'H:mm',
        defaultDate: new Date(),
        scrollTime: moment(new Date()).format('HH:mm:00'),
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        selectable: true,
        selectHelper: true,
        selectOverlap: false,
        selectAllow: function (date) {
            var eventDate = moment(date.start).format("YYYY-MM-DD HH:mm");
            if (eventDate < moment().format("YYYY-MM-DD HH:mm")) {
                return false
            }
        },
        select: function(start, end, jsEvent, view, resource) {
            console.log(jsEvent);
            var addBlock = confirm("Are you sure to block the date?");
            if (addBlock) {
                $.ajax({
                    url: '/provider/calendar/add-blocked-event',
                    data: {
                        boxId: $('select#box-select').val(),
                        start: moment(start).format('DD-MM-YYYY HH:mm'),
                        end: moment(end).format('DD-MM-YYYY HH:mm'),
                    },
                    success: function(response) {
                        console.log(response);
                        response = JSON.parse(response);
                        if(response.success) {
                            alert(response.message)
                            $('#calendar').fullCalendar('refetchEvents');
                        } else {
                            alert(response.message)
                        }
                    },
                    error: function (e) {
                        console.alert('There is error for return values');
                    }
                });
            } else {

            }
        },
        eventSources: [
            {
                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: '/provider/calendar/get-events',
                        data: {
                            boxId: $('select#box-select').val(),
                        },
                        success: function(response) {
                            response = JSON.parse(response);
                            var events = [];
                            $(response).each(function() {
                                var start = new Date($(this).attr('start_date')*1000);
                                var end = new Date($(this).attr('end_date')*1000);
                                var status = $(this).attr('status');
                                var id = $(this).attr('id');
                                events.push({
                                    start: moment(start).format(),
                                    end: moment(end).format(),
                                    backgroundColor: status == 'blocked' ? '#d9534f':'',
                                    dataId: id,
                                });

                            });
                            callback(events);
                        },
                        error: function (e) {
                            console.log('There is error for return values');
                        }
                    });
                },
                // color: 'yellow',    // an option!
                // textColor: 'black'  // an option!
            }
        ],
        eventClick: function(calEvent, jsEvent, view) {
            var answer = confirm('Do you want redirect to the event page?')
            if (answer) {
                location.href = "/provider/booking/view?id="+calEvent.dataId;
            }

            // change the border color just for fun
            $(this).css('border-color', 'red');

        }
    });

    $('#box-select').on('change', function () {
        $('#calendar').fullCalendar('refetchEvents');
    })
});