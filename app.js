document.addEventListener('DOMContentLoaded', function () {
    const tasksList = document.getElementById('tasksList');
    const taskForm = document.getElementById('taskForm');

    // Fetch and display tasks
    function fetchTasks() {
        fetch('php/tasks_api.php')
            .then(response => response.json())
            .then(tasks => {
                tasksList.innerHTML = ''; // Clear existing tasks

                if (tasks.length === 0) {
                    tasksList.innerHTML = '<p>No tasks found. Add some tasks!</p>';
                } else {
                    tasks.forEach(task => {
                        const taskDiv = document.createElement('div');
                        taskDiv.classList.add('task-item');
                        taskDiv.innerHTML = `
                            <div class="task-details" data-id="${task.id}">
                                <p><strong>Title:</strong> <span class="task-title">${task.title}</span></p>
                                <p><strong>Due:</strong> <span class="task-due">${task.due_date || 'No date set'}</span></p>
                                <p><strong>Priority:</strong> <span class="task-priority">${task.priority}</span></p>
                                <button class="edit-task" data-id="${task.id}">Edit</button>
                                <button class="save-task" data-id="${task.id}" style="display: none;">Save</button>
                            </div>
                            <div>
                                <input type="checkbox" ${task.completed == 1 ? 'checked' : ''} data-id="${task.id}">
                                <label>Completed</label>
                            </div>
                        `;
                        tasksList.appendChild(taskDiv);
                    });

                    // Add event listeners for checkboxes
                    document.querySelectorAll('.task-item input[type="checkbox"]').forEach(checkbox => {
                        checkbox.addEventListener('change', toggleCompletion);
                    });

                    // Add event listeners for editing tasks
                    document.querySelectorAll('.edit-task').forEach(button => {
                        button.addEventListener('click', enableEditMode);
                    });

                    // Add event listeners for saving edits
                    document.querySelectorAll('.save-task').forEach(button => {
                        button.addEventListener('click', saveTask);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching tasks:', error);
                tasksList.innerHTML = '<p>Failed to load tasks. Please try again later.</p>';
            });
    }

    // Add a new task
    taskForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(taskForm);

        fetch('php/tasks_api.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchTasks(); // Refresh task list
                    taskForm.reset(); // Clear form
                } else {
                    alert(data.error || 'Failed to add task.');
                }
            })
            .catch(error => console.error('Error adding task:', error));
    });

    // Toggle task completion
    function toggleCompletion(event) {
        const taskId = event.target.dataset.id;
        const completed = event.target.checked ? 1 : 0;

        fetch('php/tasks_api.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${taskId}&completed=${completed}`,
        })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert(data.error || 'Failed to update task status.');
                }
            })
            .catch(error => console.error('Error toggling completion:', error));
    }

    // Enable edit mode
    function enableEditMode(event) {
        const taskId = event.target.dataset.id;
        const taskDetails = document.querySelector(`.task-details[data-id="${taskId}"]`);

        const titleElement = taskDetails.querySelector('.task-title');
        const dueDateElement = taskDetails.querySelector('.task-due');
        const priorityElement = taskDetails.querySelector('.task-priority');

        // Replace spans with editable fields
        taskDetails.innerHTML = `
            <input type="text" class="edit-title" value="${titleElement.textContent}">
            <input type="date" class="edit-due-date" value="${dueDateElement.textContent}">
            <select class="edit-priority">
                <option value="High" ${priorityElement.textContent === 'High' ? 'selected' : ''}>High</option>
                <option value="Medium" ${priorityElement.textContent === 'Medium' ? 'selected' : ''}>Medium</option>
                <option value="Low" ${priorityElement.textContent === 'Low' ? 'selected' : ''}>Low</option>
            </select>
            <button class="save-task" data-id="${taskId}">Save</button>
        `;

        const saveButton = taskDetails.querySelector('.save-task');
        saveButton.addEventListener('click', saveTask);
    }

    // Save task changes
    function saveTask(event) {
        const taskId = event.target.dataset.id;
        const parent = document.querySelector(`.task-details[data-id="${taskId}"]`);

        const title = parent.querySelector('.edit-title').value;
        const dueDate = parent.querySelector('.edit-due-date').value;
        const priority = parent.querySelector('.edit-priority').value;

        fetch('php/tasks_api.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${taskId}&title=${title}&due_date=${dueDate}&priority=${priority}`,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchTasks(); // Refresh task list
                } else {
                    alert(data.error || 'Failed to save task changes.');
                }
            })
            .catch(error => console.error('Error saving task:', error));
    }

    fetchTasks();
});
