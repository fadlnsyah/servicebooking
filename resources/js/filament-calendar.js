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
            <p class="sb-detail-label">Code</p>
            <p class="sb-detail-value">${escapeHtml(props.code)}</p>
        </div>
        <div>
            <p class="sb-detail-label">Service</p>
            <p class="sb-detail-value">${escapeHtml(event.title)}</p>
        </div>
        <div>
            <p class="sb-detail-label">Schedule</p>
            <p class="sb-detail-value">${escapeHtml(event.start?.toLocaleDateString())} · ${escapeHtml(props.time)}</p>
        </div>
        <div>
            <p class="sb-detail-label">Customer</p>
            <p class="sb-detail-value">${escapeHtml(props.customer)}</p>
        </div>
        <div>
            <p class="sb-detail-label">Provider</p>
            <p class="sb-detail-value">${escapeHtml(props.provider)}</p>
        </div>
        <div>
            <p class="sb-detail-label">Status</p>
            <p class="sb-badge">${escapeHtml(headline(props.status))}</p>
        </div>
        <a href="${escapeHtml(event.url)}" class="sb-button">
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
