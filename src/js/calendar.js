const calendarEl = document.getElementById("calendar");
const monthYearEl = document.getElementById("monthYear");
const modalEl = document.getElementById("eventModal");
let currentDate = new Date();

// Generate Full Calendar View
function renderCalendar(date = new Date()) {
  calendarEl.innerHTML = "";

  const year = date.getFullYear();
  const month = date.getMonth();
  const today = new Date();

  const totalDays = new Date(year, month + 1, 0).getDate();
  const firstDayOfMonth = new Date(year, month, 1).getDay();

  monthYearEl.textContent = date.toLocaleDateString("en-US", {
    month: "long",
    year: "numeric",
  });

  const weekDays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
  weekDays.forEach((day) => {
    const dayEl = document.createElement("div");
    dayEl.className = "day-name";
    dayEl.textContent = day;
    calendarEl.appendChild(dayEl);
  });

  for (let i = 0; i < firstDayOfMonth; i++) {
    calendarEl.appendChild(document.createElement("div"));
  }

  for (let day = 1; day <= totalDays; day++) {
    const dateStr = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;

    const cell = document.createElement("div");
    cell.className = "day";

    if (
      day === today.getDate() &&
      month === today.getMonth() &&
      year === today.getFullYear()
    ) {
      cell.classList.add("today");
    }

    const dateEl = document.createElement("div");
    dateEl.className = "date-number";
    dateEl.textContent = day;
    cell.appendChild(dateEl);

    const eventsToday = events.filter((e) => e.date === dateStr);
    const eventBox = document.createElement("div");
    eventBox.className = "events";

    eventsToday.forEach((event) => {
      const ev = document.createElement("div");
      ev.className = "event";

      const eventEl = document.createElement("div");
      eventEl.className = "title"; // was "event-title"
      eventEl.textContent = event.title;

      const descriptionEl = document.createElement("div");
      descriptionEl.className = "description";
      descriptionEl.textContent = event.description;

      const timeEl = document.createElement("div");
      timeEl.className = "time";
      timeEl.textContent = `${event.start_time} - ${event.end_time}`;

      ev.appendChild(eventEl);
      ev.appendChild(descriptionEl);
      ev.appendChild(timeEl);
      eventBox.appendChild(ev);
    });

    // Overlay Buttons
    const overlay = document.createElement("div");
    overlay.className = "day-overlay";

    const addBtn = document.createElement("button");
    addBtn.className = "overlay-btn";
    addBtn.textContent = "+ Add";
    addBtn.onclick = (e) => {
      e.stopPropagation();
      openModalForAdd(dateStr);
    };
    overlay.appendChild(addBtn);

    if (eventsToday.length > 0) {
      const editBtn = document.createElement("button");
      editBtn.className = "overlay-btn";
      editBtn.textContent = "Edit";
      editBtn.onclick = (e) => {
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

// Add Event Modal
function openModalForAdd(dateStr) {
  document.getElementById("formAction").value = "add";
  document.getElementById("eventId").value = "";
  document.getElementById("deleteEventId").value = "";
  const deleteBtn = document.getElementById("deleteEventForm").querySelector("button[type='submit']");
  if (deleteBtn) {
    deleteBtn.disabled = true;
    deleteBtn.style.display = "none";
  }
  document.getElementById("eventFormSubmitBtn").textContent = "Add Event";
  document.getElementById("eventName").value = "";
  document.getElementById("eventDescription").value = "";
  document.getElementById("startDate").value = dateStr;
  document.getElementById("endDate").value = dateStr;
  document.getElementById("startTime").value = "09:00";
  document.getElementById("endTime").value = "10:00";

  const selector = document.getElementById("eventSelector");
  const wrapper = document.getElementById("eventSelectorWrapper");
  if (selector && wrapper) {
    selector.innerHTML = "";
    wrapper.style.display = "none";
  }

  modalEl.style.display = "flex";
}

/*
 * Open Modal for Editing Events
 * @param {Array} eventsOnDate - Array of events on the selected date
 * This function populates the modal with the events available for editing.
 * It allows the user to select an event from a dropdown and autofills the form with
 * the selected event's details.
 * @returns {void}
*/
function openModalForEdit(eventsOnDate) {
  document.getElementById("formAction").value = "edit";
  modalEl.style.display = "flex";
  document.getElementById("eventFormSubmitBtn").textContent = "Update Event";

  const selector = document.getElementById("eventSelector");
  const wrapper = document.getElementById("eventSelectorWrapper");

  // Filter unique events by id
  const uniqueEvents = [];
  const seenIds = new Set();
  eventsOnDate.forEach(e => {
    if (!seenIds.has(e.id)) {
      uniqueEvents.push(e);
      seenIds.add(e.id);
    }
  });

  selector.innerHTML = "<option disabled selected>Choose event...</option>";

  uniqueEvents.forEach((e) => {
    const option = document.createElement("option");
    option.value = JSON.stringify(e);
    option.textContent = `${e.title} - ${e.description} (${e.start} to ${e.end})`;
    selector.appendChild(option);
  });

  selector.onchange = function() {
    handleEventSelection(this.value);
  };

  if (uniqueEvents.length > 1) {
    wrapper.style.display = "block";
  } else {
    wrapper.style.display = "none";
  }

  handleEventSelection(JSON.stringify(uniqueEvents[0]));

  const deleteBtn = document.getElementById("deleteEventForm").querySelector("button[type='submit']");
  deleteBtn.disabled = false;
  deleteBtn.style.display = ""; // Show the button (default display)
}

/*
 * Handle Event Selection
 * This function parses the JSON string of the selected event and populates the modal form fields with the event's details.
 * It sets the event ID for deletion and fills in the event name, description, start date, end date, start time, and end time.
 * @param {string} eventJSON - JSON string of the selected event
 * @returns {void}
 */
function handleEventSelection(eventJSON) {
  const event = JSON.parse(eventJSON);

  document.getElementById("eventId").value = event.id;
  document.getElementById("deleteEventId").value = event.id;

  document.getElementById("eventName").value = event.title || "";
  document.getElementById("eventDescription").value = event.description || "";
  document.getElementById("startDate").value = event.start || "";
  document.getElementById("endDate").value = event.end || "";
  document.getElementById("startTime").value = event.start_time || "";
  document.getElementById("endTime").value = event.end_time || "";
}

// Close the Modal
function closeModal() {
  modalEl.style.display = "none";
}

// Navigate Between Months
function changeMonth(offset) {
  currentDate.setMonth(currentDate.getMonth() + offset);
  renderCalendar(currentDate);
}

// Update the Clock
function updateClock() {
  const now = new Date();
  const clock = document.getElementById("clock");
  clock.textContent = [
    now.getHours().toString().padStart(2, "0"),
    now.getMinutes().toString().padStart(2, "0"),
    now.getSeconds().toString().padStart(2, "0"),
  ].join(":");
}


renderCalendar(currentDate);
updateClock();
setInterval(updateClock, 1000);