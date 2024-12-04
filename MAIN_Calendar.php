<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!---------- Calendar Bootsrap ---------->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

    <link rel="stylesheet" href="css/MAIN_Calendar.css">
    <script type="text/javascript" src="js/main.js"></script>

</head>

<body>

    <!---------- Left Header ---------->

    <header class="left-header">
        <a class="logo">
            <img src="pic/edutasker.png">
        </a>

        <ul class="navbar">
            <li><a href="MAIN_Index.php">Home</a></li>
            <li><a href="MAIN_Tasks.php">Tasks</a></li>
            <li><a href="MAIN_Notes.php">Notes</a></li>
            <li><a href="MAIN_Calendar.php">Calendar</a></li>
        </ul>
    </header>

    <!---------- Top Header ---------->

    <header class="top-header">
        <div class="welcome-message">
            <h1>Welcome to EduTasker!</h1>
        </div>
        <div class="user-menu">
            <div class="user-dropdown">
                <span class="username">
                    
                    <?php
                    echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest';
                    ?>
                    
                    <i class='bx bx-chevron-down'></i>
                </span>
                <ul class="dropdown-menu">
                    <li><a href="LR_Logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!---------- Content ---------->

        <h2><center>Your Calendar</center></h2>
    <div class="container">
        <div id="calendar"></div>
    </div>
    
    <!-- Hidden Deadline Form -->
    <div class="overlay" id="overlay"></div>
    <div id="deadlineFormContainer">
        <h2>Add New Deadline</h2>
        
        <form id="deadlineForm">
            <label for="deadlineTitle">Task Title:</label>
            <input type="text" id="deadlineTitle" required><br><br>

            <label for="dueDate">Due Date:</label>
            <input type="date" id="dueDate" required><br><br>

            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" id="closeForm">Cancel</button>
        </form>
    </div>

    <!---------- JavaScript ---------->
    <script>
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            editable: true,
            selectable: true,
            selectHelper: true,
            select: function(start) {
                $('#overlay').fadeIn();
                $('#deadlineFormContainer').fadeIn();
                $('#dueDate').val(moment(start).format('YYYY-MM-DD'));

                $('#deadlineForm').off('submit').on('submit', function(e) {
                    e.preventDefault();
                    var title = $('#deadlineTitle').val();
                    var dueDate = $('#dueDate').val();

                    if (title && dueDate) {
                        $.ajax({
                            url: 'MAIN_Calendar_Save.php',
                            type: 'POST',
                            data: {
                                event_name: title,
                                event_start_date: dueDate,
                                event_end_date: dueDate
                            },
                            success: function(response) {
                                $('#calendar').fullCalendar('refetchEvents');
                                $('#deadlineFormContainer').fadeOut();
                                $('#overlay').fadeOut();
                                $('#deadlineForm')[0].reset();
                            }
                        });
                    } else {
                        alert('Please fill in all fields.');
                    }
                });

                $('#closeForm').off('click').on('click', function() {
                    $('#deadlineFormContainer').fadeOut();
                    $('#overlay').fadeOut();
                    $('#deadlineForm')[0].reset();
                });
            },
            events: 'MAIN_Calendar_Display.php',
            eventClick: function(event, jsEvent, view) {
                var confirmDelete = confirm("Do you want to delete this event?");
                if (confirmDelete) {
                    $.ajax({
                        url: 'MAIN_Calendar_Delete.php',
                        type: 'POST',
                        data: {
                            event_id: event.event_id
                        },
                        success: function(response) {
                            $('#calendar').fullCalendar('refetchEvents');
                        }
                    });
                }
            }
        });

        $('#overlay').on('click', function() {
            $('#deadlineFormContainer').fadeOut();
            $(this).fadeOut();
        });
    });
    </script>
    
    <!---------- Footer ---------->
    
    <footer class="top-footer">
        <div class="footer-message">
            <h1>&copy; 2024 EduTasker. All rights reserved.</h1>
        </div>
        <div class="footer-names">
            <a>Gingoyon</a>
            <a>Primicias</a>
            <a>Ramos</a>
        </div>
    </footer>
    
</body>
</html>
