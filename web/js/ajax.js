function getPage(route){
  _get(route,'', 'content', 'loding');
}

/** Affiche le formulaire d'ajout d'un utilisateur **/
function showUserFrom() {
  _get('user_add','', 'contentModalUser', 'minload');
  _showModal('frmUserModal');
}
function showProduitform(id) {
    _get('product_edit',id,'contentModalProduct','loding');
    _showModal('frmProductModal');
}
/** Ajoute un utilisateur en base **/


/** Affiche le formulaire d'ajout d'un profil **/
function showProfilFrom() {
  _get('profil_add','', 'contentModalProfil', 'minload');
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
    _get('profil_list','', 'profil');
  });
}
/**
 * Modification d'un produit
 */
function editProduct() {
    _post('product_edit','PostEditProduct','contentModalProduct','loadingProfil', 'flashErrorUsers', function () {
      window.location.href = Routing.generate('product_index');
    })
}

/** Effectue une req GET ajax et met à jour contentId **/
function _get(route, id, contentId, lodingId){
  // if (undefined === lodingId) lodingId = 'min-loding';
  if(route){
    _empty(contentId);
    _show(lodingId);
    var url = getUrl(route,id);
    $.ajax({
      type: 'GET',
      url: url,
      success: function(response)
      {
        if(response.error == null){
          _hide(lodingId);
          _empty(contentId);
          _setHtmlValue(contentId, response.view);
            if (_getHtmlValue('PostEditProduct') !== '') {
                $('#idProduit').attr('value', id);
            }
        }
        else showErrorResponse(response, 'flashError')
      },
      error: function(){
        alert('Veuillez ressayer plus tard');
      }
    })
  }
}

/**
 * Permet de récupérer la bonne url à envoyer dans la requête ajax
 * @param route
 * @param id
 * @returns {string|*}
 */
function getUrl(route,id) {
  return id == '' ? Routing.generate(route):Routing.generate(route,{id:id})
}
/**
 * Renvoie l'id de l'entité envoyé depuis le formulaire et doit être en tête et de type hidden(se référer de la vue edit.html.twig de product)
 * @param formId
 * @returns {*}
 */
function getIdFromSerializeForm(formId) {
    var fich  = _serializeForm(formId);
    var id = fich.split('&')[0].split('=')[1];
    return id;
}
/** Effectue une req POST ajax et met à jour contentId **/
function _post(route, formId, modal, loading, flashError, callback){
  _show(loading);
    var  id = '';
    if (_getHtmlValue('PostEditProduct') !== '') {
        id = getIdFromSerializeForm(formId);
    }
    var url = getUrl(route,id);
  $('.modal-backdrop').attr('id', 'modalClose');
  if(route){
    $.ajax({
      type: 'POST',
      url: url,
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
