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
    
    // Add the task (simplified example)
    const newTask = document.createElement('li');
    newTask.classList.add('task-item');
    newTask.innerHTML = `
      <h3>Sample Task</h3>
      <p>Description of the task</p>
      <strong>Priority: High</strong>
    `;
    taskDisplay.appendChild(newTask);
  
    // Hide "No tasks" message if tasks exist
    if (taskDisplay.children.length > 1) { // More than just the "noTasksMessage" element
      noTasksMessage.style.display = 'none';
    }
  });
  
  // Ensure the "No tasks" message shows if there are no tasks
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

    // Add the note (simplified example)
    const newNote = document.createElement('li');
    newNote.classList.add('note-item');
    newNote.innerHTML = `
      <h3>Sample Note Title</h3>
      <p>Description of the note</p>
    `;
    noteDisplay.appendChild(newNote);

    // Hide "No notes" message if notes exist
    if (noteDisplay.children.length > 1) { // More than just the "noNotesMessage" element
        noNotesMessage.style.display = 'none';
    }
});

// Ensure the "No notes" message shows if there are no notes
if (document.querySelectorAll('#noteDisplay .note-item').length === 0) {
    document.getElementById('noNotesMessage').style.display = 'block';
}

    // ==========================================================================
    // ==========================================================================
    // ==========================================================================

    
