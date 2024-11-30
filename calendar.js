document.addEventListener('DOMContentLoaded', function () {
    const calendarBody = document.getElementById('calendar-body');
    const currentMonthLabel = document.getElementById('currentMonth');
    const prevMonthButton = document.getElementById('prevMonth');
    const nextMonthButton = document.getElementById('nextMonth');

    let currentDate = new Date();

    function renderCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        // Clear the calendar body
        calendarBody.innerHTML = '';

        // Update the current month label
        const monthNames = [
            'January', 'February', 'March', 'April', 'May',
            'June', 'July', 'August', 'September', 'October', 'November', 'December'
        ];
        currentMonthLabel.textContent = `${monthNames[month]} ${year}`;

        // Add blank cells for days before the first day of the month
        let row = document.createElement('tr');
        for (let i = 0; i < firstDay; i++) {
            const blankCell = document.createElement('td');
            blankCell.classList.add('day-blank');
            row.appendChild(blankCell);
        }

        // Add cells for each day of the month
        for (let day = 1; day <= daysInMonth; day++) {
            if (row.children.length === 7) {
                calendarBody.appendChild(row);
                row = document.createElement('tr');
            }

            const dayCell = document.createElement('td');
            dayCell.textContent = day;
            dayCell.classList.add('day');
            row.appendChild(dayCell);

            // Highlight today's date
            const today = new Date();
            if (
                day === today.getDate() &&
                month === today.getMonth() &&
                year === today.getFullYear()
            ) {
                dayCell.classList.add('today');
            }
        }

        // Append the last row if it has any cells
        if (row.children.length > 0) {
            calendarBody.appendChild(row);
        }
    }

    // Navigation buttons for changing the month
    prevMonthButton.addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });

    nextMonthButton.addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });

    // Initial render
    renderCalendar(currentDate);
});
