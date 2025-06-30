<?php require APPROOT . '/app/views/templates/header.php'; ?>

<?php flash('note_message'); ?>

<button type="button" class="btn btn-primary btn-lg rounded-circle fab" data-bs-toggle="modal" data-bs-target="#createNoteModal">
    <i class="bi bi-plus-lg"></i>
</button>

<div class="mb-4">
    <input type="text" id="searchInput" class="form-control form-control-lg" placeholder="Pesquisar notas...">
</div>

<div class="row" id="notes-grid">
    <?php if(!empty($data['notes'])): ?>
        <?php foreach($data['notes'] as $note): ?>
            <div class="col-md-6 col-lg-4 mb-4 note-card-item">
                <div class="card h-100 note-card <?php echo $note->is_pinned ? 'pinned' : ''; ?>" style="background-color: <?php echo htmlspecialchars($note->color); ?>;" data-bs-toggle="modal" data-bs-target="#editNoteModal" data-id="<?php echo $note->id; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($note->title); ?></h5>
                        <p class="card-text text-truncate"><?php echo strip_tags($note->content); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12" id="no-notes-message"><p class="text-center text-muted mt-5">Você ainda não tem nenhuma nota. Clique no botão '+' para criar uma!</p></div>
    <?php endif; ?>
</div>

<div class="col-12" id="no-search-results" style="display: none;">
    <p class="text-center text-muted mt-5">Nenhuma nota encontrada para sua busca.</p>
</div>

<?php 
$colors = ['#ffffff', '#f28b82', '#fbbc04', '#fff475', '#ccff90', '#a7ffeb', '#cbf0f8'];
?>

<div class="modal fade" id="createNoteModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content">
<div class="modal-header"><h5 class="modal-title">Nova Nota</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<form id="createNoteForm" action="<?php echo URLROOT; ?>/public/index.php?url=notes/create" method="POST">
<div class="modal-body">
    <input type="hidden" name="color" id="createNoteColor" value="#ffffff">
    <div class="mb-3"><input type="text" name="title" class="form-control" placeholder="Título"></div>
    <div><textarea name="content" id="createNoteContent"></textarea></div>
</div>
<div class="modal-footer justify-content-between">
    <div class="note-colors" data-target-form="createNoteForm">
        <?php foreach($colors as $color): ?>
            <span class="color-dot <?php echo ($color == '#ffffff') ? 'selected' : ''; ?>" data-color="<?php echo $color; ?>" style="background-color: <?php echo $color; ?>;"></span>
        <?php endforeach; ?>
    </div>
    <div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button><button type="submit" class="btn btn-primary">Salvar</button>
    </div>
</div>
</form></div></div></div>

<div class="modal fade" id="editNoteModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content">
<div class="modal-header"><h5 class="modal-title" id="editNoteModalLabel">Editar Nota</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<form id="editNoteForm" action="<?php echo URLROOT; ?>/public/index.php?url=notes/update" method="POST">
<div class="modal-body">
    <input type="hidden" name="id" id="editNoteId">
    <input type="hidden" name="color" id="editNoteColor">
    <div class="mb-3"><input type="text" name="title" id="editNoteTitle" class="form-control" placeholder="Título"></div>
    <div><textarea name="content" id="editNoteContent"></textarea></div>
</div>
<div class="modal-footer justify-content-between">
    <div class="note-colors" data-target-form="editNoteForm">
        <?php foreach($colors as $color): ?>
            <span class="color-dot" data-color="<?php echo $color; ?>" style="background-color: <?php echo $color; ?>;"></span>
        <?php endforeach; ?>
    </div>
    <div>
        <button type="button" class="btn btn-warning" id="pinNoteBtn" title="Fixar/Desafixar"><i class="bi bi-pin-angle"></i></button>
        <button type="button" class="btn btn-info" id="archiveNoteBtn" title="Arquivar"><i class="bi bi-archive"></i></button>
        <button type="button" class="btn btn-danger" id="deleteNoteBtn" title="Excluir"><i class="bi bi-trash"></i></button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" form="editNoteForm" class="btn btn-primary">Salvar</button>
    </div>
</div>
</form></div></div></div>

<?php require APPROOT . '/app/views/templates/footer.php'; ?>