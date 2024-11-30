document.addEventListener('DOMContentLoaded', function () {
    const notesList = document.getElementById('notesList');
    const noteForm = document.getElementById('noteForm');

    // Fetch and display notes
    function fetchNotes() {
        fetch('php/notes_api.php')
            .then(response => response.json())
            .then(notes => {
                notesList.innerHTML = ''; // Clear existing notes

                if (notes.length === 0) {
                    notesList.innerHTML = '<p>No notes found. Add some notes!</p>';
                } else {
                    notes.forEach(note => {
                        const noteDiv = document.createElement('div');
                        noteDiv.classList.add('note-item');
                        noteDiv.innerHTML = `
                            <div class="note-details" data-id="${note.id}">
                                <p><strong>Title:</strong> ${note.title}</p>
                                <p>${note.content}</p>
                                <button class="edit-note" data-id="${note.id}">Edit</button>
                                <button class="delete-note" data-id="${note.id}">Delete</button>
                            </div>
                        `;
                        notesList.appendChild(noteDiv);
                    });

                    // Add event listeners for editing and deleting
                    document.querySelectorAll('.edit-note').forEach(button => {
                        button.addEventListener('click', editNote);
                    });

                    document.querySelectorAll('.delete-note').forEach(button => {
                        button.addEventListener('click', deleteNote);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching notes:', error);
                notesList.innerHTML = '<p>Failed to load notes. Please try again later.</p>';
            });
    }

    // Add a new note
    noteForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(noteForm);

        fetch('php/notes_api.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchNotes(); // Refresh notes
                    noteForm.reset(); // Clear the form
                } else {
                    alert(data.error || 'Failed to add note.');
                }
            })
            .catch(error => console.error('Error adding note:', error));
    });

    // Edit a note
    function editNote(event) {
        const noteId = event.target.dataset.id;
        // Your edit logic here
    }

    // Delete a note
    function deleteNote(event) {
        const noteId = event.target.dataset.id;

        fetch('php/notes_api.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${noteId}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchNotes(); // Refresh notes
                } else {
                    alert(data.error || 'Failed to delete note.');
                }
            })
            .catch(error => console.error('Error deleting note:', error));
    }

    fetchNotes(); // Initial fetch of notes
});
