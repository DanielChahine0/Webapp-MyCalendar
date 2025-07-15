const calendarEl = document.getElementById('calendar');
const monthYearEl = document.getElementById('month-year');
const modalEl = document.getElementById('event-modal');

let currentDate = new Date();

function renderCalendar(date = new Date()) {
    calendarEl.innerHTML = '';
    const year = date.getFullYear();
    const month = date.getMonth();
    const today = new Date();

    // Set the month and year in the header
    const totalDays = new Date(year, month + 1, 0).getDate();
    const firstDay = new Date(year, month, 1).getDay();

    // display month and year
    monthYearEl.textContent = date.toLocaleString('en-US', { month: 'long', year: 'numeric'});
    
    const weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    weekDays.forEach(day => {
        // Create a header for each day of the week
        const dayEl = document.createElement('div');
        dayEl.className = 'day-name';
        dayEl.textContent = day;
        calendarEl.appendChild(dayEl);
    });

    // Create empty cells for the days before the first day of the month
    for (let i = 0; i < firstDay; i++) {
        calendarEl.appendChild(document.createElement('div'));
    }

    // Loop through the days of the month
    for (let day = 1; day <= totalDays; day++) {
        const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

        const cell = document.createElement('div');
        cell.className = 'day';

        if (day == today.getDate() && month == today.getMonth() && year == today.getFullYear()) {
            cell.classList.add('today');
        }

        const dateEl = document.createElement('div');
        dateEl.className = 'date-number';
        dateEl.textContent = day;
        cell.appendChild(dateEl);

        const eventToday = events.filter(e => e.date === dateString);
        const eventBox = document.createElement('div');
        eventBox.className = 'events';

        // Render events for the day
        eventToday.forEach(event => {
            const ev = document.createElement('div');
            ev.className = 'event';
            
            const eventEl = document.createElement('div');
            eventEl.className = 'event';
            eventEl.textContent = event.title.split(' - ')[0]; // Show only the first word of the event title
            
            const descriptionEl = document.createElement('div');
            descriptionEl.className = 'event-description';
            descriptionEl.textContent = event.title.split(' - ')[1] // Show the rest of the title as description
            
            const timeEl = document.createElement('div');
            timeEl.className = 'time';
            timeEl.textContent = event.start_time + ' - ' + event.end_time;

            ev.appendChild(eventEl);
            ev.appendChild(descriptionEl);
            ev.appendChild(timeEl);
            eventBox.appendChild(ev);
        });

        // Overaly Buttons
        const overlay = document.createElement('div');
        overlay.className = 'day-overlay';

        const addBtn = document.createElement('button');
        addBtn.className = 'overlay-btn';
        addBtn.textContent = '+ Add Event';

        addBtn.onclick = e => {
            e.stopPropagation();
            openModalForAdd(dateString);
        };

        overlay.appendChild(addBtn);

        if (eventToday.length > 0) {
            const editBtn = document.createElement('button');
            editBtn.className = 'overlay-btn';
            editBtn.textContent = 'Edit Events';

            editBtn.onclick = e => {
                e.stopPropagation();
                openModalForEdit(eventsToday);
            };

            overlay.appendChild(editBtn);
        }

        cell.appendChild(overlay);
        cell.appendChild(eventBox);

        calendarEl.appendChild(cell);
    }

}