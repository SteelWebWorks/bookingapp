import './bootstrap';
import "flowbite";
import {Calendar} from "@fullcalendar/core";
import {Modal} from 'flowbite';
import dayGridPlugin from "@fullcalendar/daygrid";
import rrulePlugin from '@fullcalendar/rrule'
import timeGridPlugin from "@fullcalendar/timegrid";
import huLocale from '@fullcalendar/core/locales/hu';
import interactionPlugin from '@fullcalendar/interaction'

const calendarEl = document.querySelector('#calendar');
const modalEl = document.querySelector('#event-modal');

const modal = new Modal(modalEl);

modal.updateOnShow(() => {
    modal._targetEl.querySelector('#name').value = '';
    fetch('/recurring-types')
        .then(response => response.json())
        .then((types) => {
            types.forEach((type) => {
                let option = document.createElement("option");
                option.value = type;
                option.text = type;
                modal._targetEl.querySelector('#recurring').appendChild(option);
            })
        })
})

const calendar = new Calendar(calendarEl, {
    plugins: [dayGridPlugin, timeGridPlugin, rrulePlugin, interactionPlugin],
    locale: huLocale,
    initialView: 'timeGridWeek',
    firstDay: 1,
    selectable: true,
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay',
    },
    eventSources: (info) => {
        return fetch('/events/' + info.startStr + '/' + info.endStr).then(response => response.json()).then((data) => {
            return data.data;
        })
    },
    select: function (selectInfo) {
        modal._targetEl.querySelector('#startDateTime').value = selectInfo.startStr;
        modal._targetEl.querySelector('#endDateTime').value = selectInfo.endStr;
        modal._targetEl.querySelector('#dayOfTheWeek').value = selectInfo.start.getUTCDay();

        modal._targetEl.querySelector("form").onsubmit = (event) => {
            event.preventDefault();

            const token = document.head.querySelector('meta[name="csrf-token"]').content;

            fetch('/add-new-event', {
                headers: {
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                credentials: "same-origin",
                method: 'POST',
                body: new FormData(event.target)
            })
                .then(response => response.json())
                .then(() => {
                    modal.hide();
                    calendar.refetchEvents();
                })
                .catch((error) => {
                    console.log(error);
                })
        }

        //console.log(modal);
        modal.show();
    }
})

calendar.render();
