let currentMonth = document.querySelector(".current-month");
let calendarDays = document.querySelector(".calendar-days");
let today = new Date();
let date = new Date();


currentMonth.textContent = date.toLocaleDateString("en-US", {month:'long', year:'numeric'});
today.setHours(0,0,0,0);
renderCalendar();

function renderCalendar() {
    const prevLastDay = new Date(date.getFullYear(), date.getMonth(), 0).getDate();
    const totalMonthDay = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
    const startWeekDay = new Date(date.getFullYear(), date.getMonth(), 1).getDay();

    calendarDays.innerHTML = "";

    let totalCalendarDay = 6 * 7;
    for (let i = 0; i < totalCalendarDay; i++) {
        let day = i - startWeekDay + 1;

        if (i < startWeekDay) {
            // adding previous month days
            let dayElement = document.createElement("div");
            dayElement.classList.add("padding-day");
            dayElement.textContent = prevLastDay - startWeekDay + i + 1;
            calendarDays.appendChild(dayElement);
        } else if (i < startWeekDay + totalMonthDay) {
            // adding this month days
            let dayElement = document.createElement("div");
            date.setDate(day);
            date.setHours(0, 0, 0, 0);
            let dayClass = date.getTime() === today.getTime() ? 'current-day' : 'month-day';
            dayElement.textContent = day;
            dayElement.classList.add(dayClass);
            calendarDays.appendChild(dayElement);
        } else {
            // adding next month days
            let dayElement = document.createElement("div");
            dayElement.classList.add("padding-day");
            dayElement.textContent = day - totalMonthDay;
            calendarDays.appendChild(dayElement);
        }
    }
}


document.querySelectorAll(".month-btn").forEach(function (element) {
    element.addEventListener("click", function () {
        if (element.classList.contains("prev")) {
            // Move to the last day of the previous month
            date.setDate(1);
            date.setMonth(date.getMonth() - 1);
        } else {
            // Move to the last day of the next month
            date.setDate(1);
            date.setMonth(date.getMonth() + 1);
        }

        // Update the displayed month
        currentMonth.textContent = date.toLocaleDateString("en-US", { month: 'long', year: 'numeric' });

        renderCalendar();
    });
});





document.querySelectorAll(".btn").forEach(function (element) {
	element.addEventListener("click", function () {
        let btnClass = element.classList;
        date = new Date(currentMonth.textContent);
        if(btnClass.contains("today"))
            date = new Date();
        else if(btnClass.contains("prev-year"))
            date = new Date(date.getFullYear()-1, 0, 1);
        else
            date = new Date(date.getFullYear()+1, 0, 1);

		currentMonth.textContent = date.toLocaleDateString("en-US", {month:'long', year:'numeric'});
		renderCalendar();
	});
});