

<html>
<head>

<link rel='stylesheet' href='../fullcalendar/fullcalendar.css' />
<script src='../fullcalendar/lib/jquery.min.js'></script>
<script src='../fullcalendar/lib/moment.min.js'></script>
<script src='../fullcalendar/fullcalendar.js'></script>
<style>
.hover-end{padding:0;margin:0;font-size:75%;text-align:center;position:absolute;bottom:0;width:100%;opacity:.8}
</style>
</head>
<script>
$(document).ready(function() {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    $('#calendar').fullCalendar({
        header: {
            left: 'prev, next today',
            center: 'title',
            right: 'month, basicWeek, basicDay'
        },
        //events: "Calendar.asmx/EventList",
        //defaultView: 'dayView',
        events: [
        {
            title: 'All Day Event',
            start: 2016-07-11,
			end: 2016-07-14,
            description: 'long description',
            id: 1
        },
        {
            title: 'Long Event',
            start: new Date(y, m, d - 5),
            end: new Date(y, m, 2),
            description: 'long description3',
            id: 2
        }],
	eventMouseover: function(event, jsEvent, view) {
    $('.fc-event-inner', this).append('<div id=\"'+event.id+'\" class=\"hover-end\">'+$.fullCalendar.formatDate(event.end, 'h:mmt')+'</div>');
}


    });
});


</script>

<center>
<div  style="display:inline-block;min-width: 550px;max-width:700px;
    width: 100%;"id='calendar'></div>
	</center>
</html>