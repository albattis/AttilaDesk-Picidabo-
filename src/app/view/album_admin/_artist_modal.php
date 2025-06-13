<!-- Modal -->
<div class="modal fade" id="ujszerzoModal" tabindex="-1" aria-labelledby="ujszerzoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ujszerzoModalLabel">Új szerző</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="ujszerzoModalForm" method="post" action="index.php?controller=artist&action=create&js=true">
    <div class="form-group">
        <label for="artist_name">Név</label>
        <input type="text" class="form-control" id="artist_name" name="artist[name]">
     
    </div>
    <div class="form-group">
        <label for="artist_image">Kép</label>
        <input type="text" class="form-control" id="artist_image" name="artist[image]">
    </div>
    
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="ujszerzoModalSave">Hozzáad</button>
      </div>
    </div>
  </div>
</div>