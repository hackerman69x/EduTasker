    // HEADERS DROP DOWN ---------------------------------------------------------

document.addEventListener('DOMContentLoaded', function () {
    const userDropdown = document.querySelector('.user-dropdown');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    userDropdown.addEventListener('click', function (event) {
        event.stopPropagation();
        dropdownMenu.classList.toggle('show');
    });

    document.addEventListener('click', function () {
        dropdownMenu.classList.remove('show');
    });
});

    // ==========================================================================
    // ==========================================================================
    // ==========================================================================

    // NO TASKS FOUND -----------------------------------------------------------
document.getElementById('addTaskButton').addEventListener('click', function () {
    const taskDisplay = document.getElementById('taskDisplay');
    const noTasksMessage = document.getElementById('noTasksMessage');
    
    // add task
    const newTask = document.createElement('li');
    newTask.classList.add('task-item');
    newTask.innerHTML = `
      <h3>Sample Task</h3>
      <p>Description of the task</p>
      <strong>Priority: High</strong>
    `;
    taskDisplay.appendChild(newTask);
  
    // hide no task msg
    if (taskDisplay.children.length > 1) { // More than just the "noTasksMessage" element
      noTasksMessage.style.display = 'none';
    }
  });
  
  // ensure no task msg shows
  if (document.querySelectorAll('#taskDisplay .task-item').length === 0) {
    document.getElementById('noTasksMessage').style.display = 'block';
  }
  
    // ==========================================================================
    // ==========================================================================
    // ==========================================================================

    // NO NOTES FOUND -----------------------------------------------------------
document.getElementById('addNoteButton').addEventListener('click', function () {
    const noteDisplay = document.getElementById('noteDisplay');
    const noNotesMessage = document.getElementById('noNotesMessage');

    // add note
    const newNote = document.createElement('li');
    newNote.classList.add('note-item');
    newNote.innerHTML = `
      <h3>Sample Note Title</h3>
      <p>Description of the note</p>
    `;
    noteDisplay.appendChild(newNote);

    // no notes msg
    if (noteDisplay.children.length > 1) { // More than just the "noNotesMessage" element
        noNotesMessage.style.display = 'none';
    }
});

// ensure no task msg shows
if (document.querySelectorAll('#noteDisplay .note-item').length === 0) {
    document.getElementById('noNotesMessage').style.display = 'block';
}

    // ==========================================================================
    // ==========================================================================
    // ==========================================================================

// fullcalendar script
document.addEventListener('DOMContentLoaded', function() {
  var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
    initialView: 'dayGridMonth',
    events: 'events.php'
  });
  calendar.render();
});
