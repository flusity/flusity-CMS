$(document).ready(function() {
$('#add-menu-form').on('submit', function (e) {
    //sconsole.log("Form submitted"); 
  e.preventDefault();

  const menuName = $('#menu_name').val();
  const pageUrl = $('#page_url').val();
  const position = $('#position').val();
  const template = $('#template').val();
  const mode = $('#addMenuModal').data('mode');
  const menuId = $('#addMenuModal').data('menu-id');

  let url;
  let action;

  if (mode === 'add') {
    url = 'add_menu.php';
    action = 'add_menu';
  } else if (mode === 'update') {
    url = 'update_menu.php';
    action = 'update_menu';
  } else {
    console.error('Invalid mode');
    return;
  }

  const menuData = {
  action: action,
  menu_id: menuId,
  menu_name: menuName,
  page_url: pageUrl === '' ? 'index' : pageUrl,
  position: position,
  template: template,
};

  console.log("Submitting menu data:", menuData);

  $.ajax({
    type: 'POST',
    url: url,
    data: menuData,
    success: function (response) {
      console.log(response);
      // Uždaro modal
      $('#addMenuModal').modal('hide');
      // Išvalo input laukus
      $('#menu_name').val('');
      $('#page_url').val('');
      $('#position').val('');
      $('#template').val('');
      location.reload();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error(textStatus, errorThrown);
    },
  });
});


$('#addMenuModal').on('show.bs.modal', function (event) {
  const button = $(event.relatedTarget); 
  const mode = button.data('mode'); 
  const menuId = button.data('menu-id'); 

  const modal = $(this);
  modal.data('mode', mode);
  modal.data('menu-id', menuId);

  if (mode === 'update') {
    const menuName = button.closest('tr').find('td:nth-child(2)').text();
    const pageUrl = button.closest('tr').find('td:nth-child(3)').text();
    const position = button.closest('tr').find('td:nth-child(4)').text();
    const template = button.closest('tr').find('td:nth-child(5)').text();

    $('#menu_name').val(menuName);
    $('#page_url').val(pageUrl);
    $('#position').val(position);
    $('#template').val(template);

    modal.find('.modal-title').text('Edit Menu');
    modal.find('#submit-button').text('Update Menu');
  } else {
    $('#menu_name').val('');
    $('#page_url').val('');
    $('#position').val('');
    $('#template').val('');
    
    modal.find('.modal-title').text('Add Menu');
    modal.find('#submit-button').text('Add Menu');
  }
});
});

$(document).ready(function () {
$('button[data-bs-target="#deleteMenuModal"]').on('click', function () {
const menuId = $(this).data('menu-id');
$('#confirmDeleteModal').data('menu-id', menuId);
$('#confirmDeleteModal').modal('show');
});

$('#confirm-delete-btn').on('click', function () {
const menuId = $('#confirmDeleteModal').data('menu-id');
$.ajax({
  type: 'POST',
  url: 'delete_menu.php',
  data: {
    action: 'delete_menu_item',
    menu_item_id: menuId
  },
  success: function(response) {
    $('#confirmDeleteModal').modal('hide');
    window.location.href = 'menu.php';
  },
  error: function(jqXHR, textStatus, errorThrown) {
    console.error(textStatus, errorThrown);
  }
});

});
});
