    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',  // Default view is month view
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
            },
            events: [
                {
                    title: 'Meeting',
                    start: '2024-12-20T10:00:00',
                    end: '2024-12-20T12:00:00',
                    description: 'Project discussion'
                },
                {
                    title: 'Workshop',
                    start: '2024-12-22T14:00:00',
                    end: '2024-12-22T16:00:00',
                    description: 'Training session'
                }
            ],
            eventClick: function(info) {
                alert('Event: ' + info.event.title);
            }
        });
        
        calendar.render();
    });
