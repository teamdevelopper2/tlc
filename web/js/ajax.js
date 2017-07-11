function getPage(route){
  _get(route, 'content', 'loding');
}

/** Affiche le formulaire d'ajout d'un utilisateur **/
function showUserFrom() {
  _get('user_add', 'contentModalUser', 'minload');
  _showModal('frmUserModal');
}


function addUser(){
  _post('user_add', 'frmUserAdd', 'frmUserModal', 'loadingUser');
}


/** Effectue une req GET ajax et met à jour contentId **/
function _get(route, contentId, lodingId){
  // if (undefined === lodingId) lodingId = 'min-loding';
  if(route){
    _empty(contentId);
    _show(lodingId);
    $.ajax({
      type: 'GET',
      url: Routing.generate(route),

      success: function(response)
      {
        if(response.error == null){
          _hide(lodingId);
          _empty(contentId);
          _setHtmlValue(contentId, response.view);
        }
        else showErrorResponse(response, 'flashError')
      },
      error: function(){
        alert('Veuillez ressayer plus tard');
      }
    })
  }
}


/** Effectue une req POST ajax et met à jour contentId **/
function _post(route, formId, modal, loading){
  _show(loading);
  $('.modal-backdrop').attr('id', 'modalClose')
  if(route){
    $.ajax({
      type: 'POST',
      url: Routing.generate(route),
      data: _serializeForm(formId),
      success: function(response)
      {
        if(response.error == null){
          _hide(loading);
          $('#modalClose').removeClass('modal-backdrop fade in');
          _get('user_list', 'users');
        }
        else showErrorResponse(response, 'flashErrorUsers')
      },
      error: function(){
        alert('Veuillez ressayer plus tard');
      }
    })
  }
}

/** Affiche les erreurs retourné par une requete AJAX **/
function showErrorResponse(response, flashId){
  $('#flashError').removeAttr('hidden');
  _setHtmlValue(flashId, '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + response.error)
}
