require('./bootstrap');
var i = 2;
$('#addMoreUsers').click(function () {
  $('#submitButton').before(addFieldSet(i));
  i++;
});

function addFieldSet(index) {
  return '<div class="form-group"><label for="first_name">First name</label><input type="text" name="users[' + index + '][first_name]"><label for="last_name">Last name</label><input type="text" name="users[' + index + '][last_name]"></div>';
}