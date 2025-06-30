<?php
class NotesController extends Controller
{
    private $noteModel;

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('auth/login');
        }
        $this->noteModel = $this->model('Note');
    }

    public function index()
    {
        $notes = $this->noteModel->getNotesByUserId($_SESSION['user_id']);
        $data = ['notes' => $notes];
        $this->view('notes/index', $data);
    }

    public function archived()
    {
        $notes = $this->noteModel->getArchivedNotesByUserId($_SESSION['user_id']);
        $data = ['notes' => $notes];
        $this->view('notes/archived', $data);
    }

    public function show($id)
    {
        $note = $this->noteModel->getNoteById($id, $_SESSION['user_id']);
        if (!$note) {
            http_response_code(404);
            echo json_encode(['error' => 'Nota não encontrada ou acesso não permitido.']);
            return;
        }
        header('Content-Type: application/json');
        echo json_encode($note);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'title' => trim($_POST['title']),
                'content' => $_POST['content'],
                'color' => isset($_POST['color']) ? $_POST['color'] : '#ffffff',
                'user_id' => $_SESSION['user_id']
            ];

            if (empty($data['title']) && empty($data['content'])) {
                 flash('note_message', 'A nota não pode estar totalmente vazia.', 'alert-danger');
                 redirect('notes');
            }
            
            if ($this->noteModel->createNote($data)) {
                flash('note_message', 'Nota criada com sucesso!');
                redirect('notes');
            } else {
                flash('note_message', 'Ocorreu um erro ao criar a nota.', 'alert-danger');
                redirect('notes');
            }
        } else {
            redirect('notes');
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $note = $this->noteModel->getNoteById($_POST['id'], $_SESSION['user_id']);
            if (!$note) {
                flash('note_message', 'Acesso não permitido.', 'alert-danger');
                redirect('notes');
                return;
            }

            $data = [
                'id' => $_POST['id'],
                'title' => trim($_POST['title']),
                'content' => $_POST['content'],
                'color' => isset($_POST['color']) ? $_POST['color'] : '#ffffff',
                'user_id' => $_SESSION['user_id']
            ];

            if ($this->noteModel->updateNote($data)) {
                flash('note_message', 'Nota atualizada com sucesso!');
                redirect('notes');
            } else {
                flash('note_message', 'Ocorreu um erro ao atualizar a nota.', 'alert-danger');
                redirect('notes');
            }
        } else {
            redirect('notes');
        }
    }

    private function performToggleAction($id, $action)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('notes');
            return;
        }
        
        $note = $this->noteModel->getNoteById($id, $_SESSION['user_id']);
        if (!$note) {
            echo json_encode(['success' => false, 'message' => 'Acesso não permitido.']);
            return;
        }

        $modelMethod = '';
        switch ($action) {
            case 'archive':
                $modelMethod = 'toggleArchiveStatus';
                break;
            case 'pin':
                $modelMethod = 'togglePinStatus';
                break;
            case 'delete':
                 if ($this->noteModel->deleteNote($id, $_SESSION['user_id'])) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Erro ao excluir a nota.']);
                }
                return;
        }

        if ($this->noteModel->$modelMethod($id, $_SESSION['user_id'])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function delete($id){ $this->performToggleAction($id, 'delete'); }
    public function archive($id){ $this->performToggleAction($id, 'archive'); }
    public function pin($id){ $this->performToggleAction($id, 'pin'); }
}