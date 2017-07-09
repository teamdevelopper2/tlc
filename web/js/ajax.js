function getPage(route){
  _get(route, 'content', 'loding');
}

/** Affiche le formulaire d'ajout d'un utilisateur **/
function showUserFrom() {
  _get('user_add', 'contentModalUser');
  _showModal('frmUserModal');
}

/** Ajoute un utilisateur en base **/
function addUser(){
  var response = _post('user_add');
  if(response.error == null){
    _hide('min-lodin');
    _get('user_list', 'users');
  }
}


/** Effectue une req GET ajax et met à jour contentId **/
function _get(route, contentId, lodingId){
  if (undefined === lodingId) lodingId = 'min-loding';

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
        else showErrorResponse(response)
      },
      error: function(){
        alert('Veuillez ressayer plus tard');
      }
    })
  }
}


/** Effectue une req POST ajax et met à jour contentId **/
function _post(route, contentId, lodingId, formId){
  if (undefined === lodingId) lodingId = 'min-loding';

  if(route){
    _empty(contentId);
    _show(lodingId);
    $.ajax({
      type: 'POST',
      url: Routing.generate(route),
      data: _serializeForm(formId),
      success: function(response)
      {
        return response;
      },
      error: function(){
        alert('Veuillez ressayer plus tard');
      }
    })
  }
}

/** Affiche les erreurs retourné par une requete AJAX **/
function showErrorResponse(response){
  $('#flashError').removeAttr('hidden');
  _setHtmlValue('flashError', '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + response.error)
}
