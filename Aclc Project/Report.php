<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID System Calendar</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/calendar.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.3.1/dist/fullcalendar.min.css" rel="stylesheet" />

</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <header>CS31</header>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="attendance.php"><i class="fas fa-list"></i> Attendance</a></li>
            <li class="dropdown">
                <a href="#"><i class="fas fa-users"></i> Student</a>
                <ul class="student_drop">
                    <li><a href="Senior.php"><i class="fas fa-user-graduate"></i> Senior High</a></li>
                    <li><a href="collage.php"><i class="fas fa-user-graduate"></i> College</a></li>
                </ul>
            </li>
            <li><a href="Calendar.php"><i class="fas fa-calendar"></i> Calendar</a></li>
            <li><a href="#"><i class="fas fa-clock"></i> Schedule</a></li>
            <li><a href="#"><i class="fas fa-chalkboard-teacher"></i> Teacher</a></li>
            <li style="background:red;"><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main content container (calendar) -->
    <div class="container">
        <div class="calendar">
            <div class="calendar-controls">
                <span class="arrow" id="prevMonth">&lt;</span>
                <div class="calendar-header" id="monthYear"></div>
                <span class="arrow" id="nextMonth">&gt;</span>
            </div>
            <div class="calendar-body" id="calendarBody"></div>
        </div>
    </div>

    <script>
        const calendarBody = document.getElementById('calendarBody');
        const monthYear = document.getElementById('monthYear');
        const prevMonth = document.getElementById('prevMonth');
        const nextMonth = document.getElementById('nextMonth');

        let currentDate = new Date();

        // Array of day names
        const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        function renderCalendar(date) {
            const month = date.getMonth();
            const year = date.getFullYear();

            // Get today's date
            const today = new Date();
            const todayDate = today.getDate();
            const todayMonth = today.getMonth();
            const todayYear = today.getFullYear();

            // Set the header
            monthYear.textContent = `${date.toLocaleString('default', { month: 'long' })} ${year}`;

            // Get the first day of the month
            const firstDayOfMonth = new Date(year, month, 1);
            const lastDayOfMonth = new Date(year, month + 1, 0);

            // Get the total days in the current month
            const totalDays = lastDayOfMonth.getDate();

            // Clear the calendar body
            calendarBody.innerHTML = '';

            // Create the day names row (Sunday, Monday, ...)
            dayNames.forEach(day => {
                const dayNameElement = document.createElement('div');
                dayNameElement.textContent = day;
                dayNameElement.classList.add('day-name');
                calendarBody.appendChild(dayNameElement);
            });

            // Fill in the empty slots for the previous month's overflow days
            for (let i = 0; i < firstDayOfMonth.getDay(); i++) {
                const emptyCell = document.createElement('div');
                calendarBody.appendChild(emptyCell);
            }

            // Create the days for the current month
            for (let day = 1; day <= totalDays; day++) {
                const dayElement = document.createElement('div');
                dayElement.textContent = day;
                dayElement.classList.add('day');

                // Check if the current day matches today's date
                if (day === todayDate && month === todayMonth && year === todayYear) {
                    dayElement.classList.add('today'); // Add 'today' class to today's date
                }

                dayElement.onclick = () => alert(`Selected date: ${month + 1}/${day}/${year}`);
                calendarBody.appendChild(dayElement);
            }

            // Add inactive days for the next month
            const remainingCells = 42 - (firstDayOfMonth.getDay() + totalDays);
            for (let i = 0; i < remainingCells; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.classList.add('inactive');
                calendarBody.appendChild(emptyCell);
            }
        }

        prevMonth.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate);
        });

        nextMonth.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate);
        });

        // Initialize the calendar with the current month
        renderCalendar(currentDate);
    </script>
</body>
</html>
