<!DOCTYPE html>
<html>
<head>
    <title>CRUD Fullcalendar - Laravel 11 (https://www.jc-mouse.net/)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales-all.global.min.js'></script>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prevYear,prev,next,nextYear today'
                    , center: 'title'
                    , right: 'dayGridMonth,dayGridWeek,dayGridDay'                    
                }                
                , navLinks: true
                , editable: true
                , displayEventTime: false
                , selectable: true
                , locale: 'es'
                , events: "{{ route('fullcalendar.events') }}",
                /** -------------------------------------------------------------
                 * creacion de eventos
                 */
                dateClick: function(info) {
                    var title = prompt('Nuevo evento:');
                    if (title) {                        
                        var start = moment(info.dateStr).format('Y-MM-DD');
                        var end = moment(info.dateStr).format('Y-MM-DD');

                        $.ajax({
                            url: "{{ route('fullcalendar.events.add') }}"
                            , data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                                , title: title
                                , start: start
                                , end: end
                            }
                            , type: "POST"
                            , success: function(data) {
                                calendar.addEvent({
                                    id: data.id
                                    , title: title
                                    , start: end
                                    , allDay: false
                                });
                                calendar.render();
                            }
                        });
                    }
                },
                /** -------------------------------------------------------------
                 * Eliminación de eventos
                 */
                eventClick: function(info) {
                    var deleteMsg = confirm("¿Realmente quieres eliminar este evento?");
                    if (deleteMsg) {
                        $.ajax({
                            type: "DELETE"
                            , url: "{{ route('fullcalendar.events.destroy') }}"
                            , data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                                , id: info.event.id
                            , }
                            , success: function(response) {
                                info.event.remove();
                            }
                        });
                    }
                },
                /** -------------------------------------------------------------
                 * Actualización de eventos
                 */
                eventDrop: function(info) {
                    var start = moment(info.event.start).format('Y-MM-DD');
                    var end = moment(info.event.start).format('Y-MM-DD');
                    $.ajax({
                        url: "{{ route('fullcalendar.events.update') }}"
                        , data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                            , title: info.event.title
                            , start: start
                            , end: end
                            , id: info.event.id
                        }
                        , type: "PUT"
                        , success: function(response) {
                            console.log(response);                            
                        }
                    });
                },

            });
            calendar.render();
        });
    </script>
</body>

</html>