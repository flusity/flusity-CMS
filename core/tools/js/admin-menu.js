$(document).ready(function() {
  $('#add-menu-form').on('submit', function (e) {
    e.preventDefault();

    const menuName = $('#menu_name').val();
    const pageUrl = $('#page_url').val();
    const position = $('#position').val();
    const template = $('#template').val();
    const showInMenu = $('#show_in_menu').is(':checked') ? 1 : 0; 
    const parentId = $('#parent_id').val(); 
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
      show_in_menu: showInMenu, 
      parent_id: parentId 
    };
    if (mode === 'update') {
      menuData.menu_id = menuId;
    }
    console.log("Submitting menu data:", menuData);

    $.ajax({
      type: 'POST',
      url: url,
      data: menuData,
      success: function (response) {
        console.log(response);
        
        $('#addMenuModal').modal('hide');
        
        $('#menu_name').val('');
        $('#page_url').val('');
        $('#position').val('');
        $('#template').val('');
        $('#show_in_menu').prop('checked', false); 
        $('#parent_id').val(''); 
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
    const parentId = button.data('parent-id'); 
  
    const modal = $(this);
    modal.data('mode', mode);
    modal.data('menu-id', menuId);
  
    if (mode === 'update') {
      const menuName = button.closest('tr').find('td:nth-child(2)').text();
      const pageUrl = button.closest('tr').find('td:nth-child(3)').text();
      const position = button.closest('tr').find('td:nth-child(5)').text();
      const template = button.closest('tr').find('td:nth-child(4)').text();
      const showInMenu = button.closest('tr').find('td:nth-child(6)').text().trim() == '1' ? true : false;
      
      $('#menu_name').val(menuName);
      $('#page_url').val(pageUrl);
      $('#position').val(position);
      $('#template').val(template);
      $('#show_in_menu').prop('checked', showInMenu);
        $('#parent_id').val(parentId); 
  
      modal.find('.modal-title').text('Edit Menu');
      modal.find('#submit-button').text('Update Menu');
    } else {
      $('#menu_name').val('');
      $('#page_url').val('');
      $('#position').val('');
      $('#template').val('');
      $('#show_in_menu').prop('checked', false); 
      $('#parent_id').val('');
  
      modal.find('.modal-title').text('Add Menu');
      modal.find('#submit-button').text('Add Menu');
    }
  });
  
  
});


