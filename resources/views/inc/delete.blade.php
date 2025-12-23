
<div class="modal fade" id="mdl-delete" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('app.delete') }}?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" action="{{ $delete_url }}">
        {{ csrf_field() }}
        <div class="modal-body">
          <input type="hidden" name="delete_id" value="" />
          <span style="font-size: 16px">Confirm delete?</span>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('app.cancel')}}</button>
          <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
        </div>
      </form>
    </div>
  </div>
</div>