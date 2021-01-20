<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('Calendar');
        var calendar = $('#Calendar').fullCalendar({
            editable: true,
            header: {
                left: 'prev, next today',
                center: 'title',
                right: 'month, agendaWeek, agendaDay',
            },
            event: "<?php echo base_url(); ?>/schedule/load",
            selectable: true,
            selectHelper: true,
            select: function(start, end, allDay){
                var check = confirm('Confirm booking!');
                if (check) {
                    var user = document.getElementById('username');
                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

                    // $.ajax({
                        // url: "<?php //echo base_url();?>/scheduler/insert",
                    //     type: "POST",
                    //     data: {
                    //         user: user,
                    //         start: start,
                    //         end: end,
                    //     },
                    //     success: function(){
                    //         calendar.fullCalendar('refetchEvents');
                    //         alert("Added Successfully");
                    //     }
                    // });
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', "<?php echo base_url();?>/schedule/insert");
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            alert('Added Successfully: ', JSON.parse(xhr.responseText));
                        }
                    };
                    xhr.send(JSON.stringify({
                        user: user,
                        start: start,
                        end: end
                    }));
                }
            },
            eventResize: function(event){
                var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                var username = event.user;
                var id = event.id;

                $.ajax({
                    url: "<?php echo base_url();?>/schedule/update",
                    type: "POST",
                    data: {
                        user: user,
                        start: start,
                        end: end,
                    },
                    success: function(){
                        calendar.fullCalendar('refetchEvents');
                        alert("Event update");
                    }
                });

            }
        });
    });
</script>

<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <input type="hidden" id="username" value="<?= session()->get('username') ?>">
            <h1>Hello, <?= session()->get('username')?></h1>
        </div>
    </div>
    <hr>
    <div id="Calendar"></div>
</div>

