document.addEventListener('DOMContentLoaded', function() {
    const themeToggler = document.getElementById('theme-toggler');
    const currentTheme = localStorage.getItem('theme');

    if (currentTheme === 'dark') {
        document.body.classList.add('dark-mode');
    }

    const initTinyMCE = (selector, setupCallback = () => {}) => {
        if (tinymce.get(selector)) {
            tinymce.get(selector).remove();
        }
        tinymce.init({
            selector: selector,
            plugins: 'lists link image table code help wordcount',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code',
            skin: (document.body.classList.contains('dark-mode')) ? 'oxide-dark' : 'oxide',
            content_css: (document.body.classList.contains('dark-mode')) ? 'dark' : 'default',
            height: 300,
            setup: (editor) => {
                editor.on('init', () => {
                    setupCallback(editor);
                });
            }
        });
    };

    if (themeToggler) {
        themeToggler.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            let theme = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
            localStorage.setItem('theme', theme);

            tinymce.get().forEach(editor => {
                if (editor.id === 'createNoteContent' || editor.id === 'editNoteContent') {
                     if (document.getElementById(editor.id)?.closest('.modal')?.classList.contains('show')) {
                        let content = editor.getContent();
                        let targetId = '#' + editor.id;
                        let setupCb = (newEditor) => {
                            newEditor.setContent(content);
                        };
                        editor.remove();
                        initTinyMCE(targetId, setupCb);
                    }
                }
            });
        });
    }

    const setupColorPicker = (modalEl) => {
        const colorPalette = modalEl.querySelector('.note-colors');
        if (!colorPalette) return;
        const formId = colorPalette.dataset.targetForm;
        const form = document.getElementById(formId);
        const colorInput = form.querySelector('input[name="color"]');
        
        const dots = colorPalette.querySelectorAll('.color-dot');
        dots.forEach(dot => {
            dot.addEventListener('click', (e) => {
                const selectedColor = e.target.dataset.color;
                colorInput.value = selectedColor;
                dots.forEach(d => d.classList.remove('selected'));
                e.target.classList.add('selected');
            });
        });
    };
    
    const createNoteModalEl = document.getElementById('createNoteModal');
    if (createNoteModalEl) {
        createNoteModalEl.addEventListener('shown.bs.modal', () => {
            initTinyMCE('#createNoteContent');
            setupColorPicker(createNoteModalEl);
        });
        createNoteModalEl.addEventListener('hidden.bs.modal', () => {
            tinymce.get('createNoteContent')?.destroy();
        });
    }

    async function performNoteAction(noteId, action) {
        try {
            const response = await fetch(`${URLROOT}/public/index.php?url=notes/${action}/${noteId}`, { method: 'POST' });
            const result = await response.json();
            if (result.success) {
                window.location.reload();
            } else {
                alert(`Falha: ${result.message || 'Erro desconhecido'}`);
            }
        } catch (error) {
            console.error(`Erro na ação ${action}:`, error);
        }
    }

    const editNoteModalEl = document.getElementById('editNoteModal');
    if (editNoteModalEl) {
        const editNoteModal = new bootstrap.Modal(editNoteModalEl);
        editNoteModalEl.addEventListener('shown.bs.modal', async (event) => {
            const card = event.relatedTarget;
            if (!card) return;
            const noteId = card.getAttribute('data-id');
            const response = await fetch(`${URLROOT}/public/index.php?url=notes/show/${noteId}`);
            if (!response.ok) return;
            const note = await response.json();
            document.getElementById('editNoteId').value = note.id;
            document.getElementById('editNoteTitle').value = note.title;
            
            initTinyMCE('#editNoteContent', (editor) => {
                editor.setContent(note.content || '');
            });

            setupColorPicker(editNoteModalEl);
            const colorInput = document.getElementById('editNoteColor');
            colorInput.value = note.color || '#ffffff';
            const dots = editNoteModalEl.querySelectorAll('.color-dot');
            dots.forEach(dot => {
                dot.classList.toggle('selected', dot.dataset.color === colorInput.value);
            });

            document.getElementById('pinNoteBtn').onclick = () => performNoteAction(note.id, 'pin');
            document.getElementById('archiveNoteBtn').onclick = () => performNoteAction(note.id, 'archive');
            document.getElementById('deleteNoteBtn').onclick = () => {
                if (confirm('Tem certeza que deseja excluir esta nota permanentemente?')) {
                   performNoteAction(note.id, 'delete');
                   editNoteModal.hide();
                }
            };
        });
        editNoteModalEl.addEventListener('hidden.bs.modal', () => {
            tinymce.get('editNoteContent')?.destroy();
        });
    }
    
    const archivedNoteModalEl = document.getElementById('archivedNoteModal');
    if(archivedNoteModalEl){
        archivedNoteModalEl.addEventListener('show.bs.modal', async (event) => {
            const card = event.relatedTarget;
            if (!card) return;
            const noteId = card.getAttribute('data-id');
            const response = await fetch(`${URLROOT}/public/index.php?url=notes/show/${noteId}`);
            if (!response.ok) return;
            const note = await response.json();

            document.getElementById('archivedNoteTitle').textContent = note.title;
            document.getElementById('archivedNoteContent').innerHTML = note.content;
            document.getElementById('unarchiveNoteBtn').onclick = () => performNoteAction(note.id, 'archive');
            document.getElementById('deleteArchivedNoteBtn').onclick = () => {
                 if (confirm('Tem certeza que deseja excluir esta nota permanentemente?')) {
                   performNoteAction(note.id, 'delete');
                }
            };
        });
    }

    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        const noSearchResultsMessage = document.getElementById('no-search-results');
        searchInput.addEventListener('keyup', () => {
            const searchTerm = searchInput.value.toLowerCase();
            const noteItems = document.querySelectorAll('#notes-grid .note-card-item');
            let visibleNotesCount = 0;
            noteItems.forEach(item => {
                const title = item.querySelector('.card-title').textContent.toLowerCase();
                const content = item.querySelector('.card-text').textContent.toLowerCase();
                if (title.includes(searchTerm) || content.includes(searchTerm)) {
                    item.style.display = '';
                    visibleNotesCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            if (noSearchResultsMessage) {
                noSearchResultsMessage.style.display = (visibleNotesCount === 0 && noteItems.length > 0) ? 'block' : 'none';
            }
        });
    }
});