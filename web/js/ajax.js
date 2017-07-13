function getPage(route){
  _get(route, 'content', 'loding');
}

/** Affiche le formulaire d'ajout d'un utilisateur **/
function showUserFrom() {
  _get('user_add', 'contentModalUser', 'minload');
  _showModal('frmUserModal');
}


/** Affiche le formulaire d'ajout d'un profil **/
function showProfilFrom() {
  _get('profil_add', 'contentModalProfil', 'minload');
  _showModal('frmProfilModal');
}


function addUser(){
  _post('user_add', 'frmUserAdd', 'frmUserModal', 'loadingUser', 'flashErrorUsers', function () {
    _get('user_list', 'users');
    $('#modalClose').removeClass('modal-backdrop fade in');
  });
}

function addProfil(){
  _post('profil_add', 'frmProfilAdd', 'frmProfilModal', 'loadingProfil', 'flashErrorUsers', function () {
    _get('profil_list', 'profil');
  });
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
function _post(route, formId, modal, loading, flashError, callback){
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
          // On peut exécuter tout ce que l'on veut dans le fn callback
          callback();
          $('#modalClose').removeClass('modal-backdrop fade in');
        }
        else showErrorResponse(response, flashError)
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
