import './bootstrap';
import {Calendar} from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import rrulePlugin from '@fullcalendar/rrule'
import timeGridPlugin from "@fullcalendar/timegrid";
import huLocale from '@fullcalendar/core/locales/hu';

let calendarEl = document.getElementById('calendar');

let calendar = new Calendar(calendarEl, {
    plugins: [dayGridPlugin, timeGridPlugin, rrulePlugin],
    initialView: 'timeGridWeek',
    firstDay: 1,
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay',
    },
    eventSources: [
        {
            url: '/events'
        }
    ]
})

calendar.render();
