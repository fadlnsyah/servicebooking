import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

const calendarEl = document.getElementById('servicebooking-calendar');
const detailEl = document.getElementById('servicebooking-calendar-detail');

const headline = (value) => String(value ?? '')
    .replace(/_/g, ' ')
    .replace(/\b\w/g, (letter) => letter.toUpperCase());

const escapeHtml = (value) => String(value ?? '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');

const renderDetails = (event) => {
    if (!detailEl) {
        return;
    }

    const props = event.extendedProps;

    detailEl.innerHTML = `
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Code</p>
            <p class="mt-1 font-bold text-gray-950">${escapeHtml(props.code)}</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Service</p>
            <p class="mt-1 font-bold text-gray-950">${escapeHtml(event.title)}</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Schedule</p>
            <p class="mt-1 text-gray-700">${escapeHtml(event.start?.toLocaleDateString())} · ${escapeHtml(props.time)}</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Customer</p>
            <p class="mt-1 text-gray-700">${escapeHtml(props.customer)}</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Provider</p>
            <p class="mt-1 text-gray-700">${escapeHtml(props.provider)}</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Status</p>
            <p class="mt-1 inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">${escapeHtml(headline(props.status))}</p>
        </div>
        <a href="${escapeHtml(event.url)}" class="inline-flex w-full justify-center rounded-full bg-gray-900 px-4 py-3 text-sm font-semibold text-white">
            Open booking
        </a>
    `;
};

if (calendarEl) {
    const events = JSON.parse(calendarEl.dataset.events || '[]');

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: 'timeGridWeek',
        height: 'auto',
        nowIndicator: true,
        selectable: true,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        events,
        eventClassNames: ({ event }) => [`booking-status-${event.extendedProps.status}`],
        eventClick: (info) => {
            info.jsEvent.preventDefault();
            renderDetails(info.event);
        },
    });

    calendar.render();

    if (calendar.getEvents().length > 0) {
        renderDetails(calendar.getEvents()[0]);
    }
}
