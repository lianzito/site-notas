<?php require APPROOT . '/app/views/templates/header.php'; ?>

<h2 class="mb-4">Notas Arquivadas</h2>

<div class="row" id="notes-grid">
    <?php if(!empty($data['notes'])): ?>
        <?php foreach($data['notes'] as $note): ?>
            <div class="col-md-6 col-lg-4 mb-4 note-card-item">
                <div class="card h-100 note-card" style="background-color: <?php echo htmlspecialchars($note->color); ?>;" data-bs-toggle="modal" data-bs-target="#archivedNoteModal" data-id="<?php echo $note->id; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($note->title); ?></h5>
                        <p class="card-text text-truncate"><?php echo strip_tags($note->content); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12" id="no-notes-message"><p class="text-center text-muted mt-5">Você não tem nenhuma nota arquivada.</p></div>
    <?php endif; ?>
</div>

<div class="modal fade" id="archivedNoteModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content">
<div class="modal-header"><h5 class="modal-title" id="archivedNoteModalLabel">Nota Arquivada</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body">
    <h5 id="archivedNoteTitle" class="mb-3"></h5>
    <div id="archivedNoteContent" class="p-3 border rounded" style="min-height: 200px; overflow-y: auto;"></div>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-danger" id="deleteArchivedNoteBtn" title="Excluir Permanentemente"><i class="bi bi-trash"></i></button>
    <div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-success" id="unarchiveNoteBtn"><i class="bi bi-box-arrow-up"></i> Restaurar</button>
    </div>
</div>
</div></div></div>

<?php require APPROOT . '/app/views/templates/footer.php'; ?>