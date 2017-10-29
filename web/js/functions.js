
/** **/
function _effacerFormulaire (idFormulaire)
{
  $('#' + idFormulaire +' :input') .not(':button, :submit, :reset') .val('') .removeAttr('checked') .removeAttr('selected');
}

/** Met la valeur d'un element id à 0 **/
function _setZero(s) {
  jQuery(_setSelectorId(s)).val('0');
}

/** Change la valuer d'un element id **/
function _setValue(s, v) {
  jQuery(_setSelectorId(s)).val(v);
}

/** Hide un element  **/
function _hide(s) {
  jQuery(_setSelectorId(s)).hide();
}

/** Hide un element  **/
function _hideClass(s) {
  jQuery(_setSelectorClass(s)).hide();
}


/** Remeve attr  **/
function _removeAttr(s, v) {
  jQuery(_setSelectorId(s)).removeAttr(v);
}


/** Hide un element  **/
function _hideFadOut(s) {
  jQuery(_setSelectorId(s)).hide().fadeOut();
}

/** Empty un element  **/
function _empty(s) {
  jQuery(_setSelectorId(s)).empty();
}

/** Show un element id **/
function _show(s) {
  jQuery(_setSelectorId(s)).show();
}

/** Show d'une class **/
function _showClass(s) {
  jQuery(_setSelectorClass(s)).show();
}

/** Show un modal **/
function _showModal(s) {
  jQuery(_setSelectorId(s)).modal("show");
}

/** Hide un modal **/
function _hideModal(s) {
  jQuery(_setSelectorId(s)).modal("hide");
}

/** Modifie la valeur d'un element input **/
function _setInputValue(s, value) {
  jQuery(_setSelectorId(s)).val(value);
}

/** Modifie la valeur d'un element html **/
function _setHtmlValue(s, value) {
  jQuery(_setSelectorId(s)).html(value);
}

/** Get value of a input element **/
function _getInputValue(s){
  return jQuery(_setSelectorId(s)).val();
}

/** Serialize a input element **/
function _serializeForm(s){
  return jQuery(_setSelectorId(s)).serialize();
}

/** Get value of a html element **/
function _getHtmlValue(s){
  return jQuery(_setSelectorId(s)).html();
}
/** Serialize a input element **/
function _serializeForm(s){
  return jQuery(_setSelectorId(s)).serialize();
}

function _setSelectorId(s){
  return '#' + s;
}

function _setSelectorClass(s){
  return '.' + s;
}
