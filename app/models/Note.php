<?php
class Note {
    private $db;
    public function __construct(){ $this->db = new Database; }

    public function getNotesByUserId($userId){
        $this->db->query('SELECT * FROM notes WHERE user_id = :user_id AND is_archived = false ORDER BY is_pinned DESC, updated_at DESC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function getArchivedNotesByUserId($userId){
        $this->db->query('SELECT * FROM notes WHERE user_id = :user_id AND is_archived = true ORDER BY updated_at DESC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function getNoteById($noteId, $userId){
        $this->db->query('SELECT * FROM notes WHERE id = :id AND user_id = :user_id');
        $this->db->bind(':id', $noteId);
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }

    public function createNote($data){
        $this->db->query('INSERT INTO notes (user_id, title, content, color) VALUES (:user_id, :title, :content, :color)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':color', $data['color']);
        return $this->db->execute();
    }

    public function updateNote($data){
        $this->db->query('UPDATE notes SET title = :title, content = :content, color = :color WHERE id = :id AND user_id = :user_id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':color', $data['color']);
        return $this->db->execute();
    }

    public function toggleArchiveStatus($noteId, $userId){
        $this->db->query('UPDATE notes SET is_archived = NOT is_archived WHERE id = :id AND user_id = :user_id');
        $this->db->bind(':id', $noteId);
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }

    public function togglePinStatus($noteId, $userId){
        $this->db->query('UPDATE notes SET is_pinned = NOT is_pinned WHERE id = :id AND user_id = :user_id');
        $this->db->bind(':id', $noteId);
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }

    public function deleteNote($noteId, $userId){
        $this->db->query('DELETE FROM notes WHERE id = :id AND user_id = :user_id');
        $this->db->bind(':id', $noteId);
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }
}