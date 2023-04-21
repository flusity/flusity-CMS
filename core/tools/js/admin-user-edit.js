

function loadUserEditForm(userId) {
  const url = 'get_user.php?user_id=' + userId;
  fetch(url)
      .then(response => response.text())
      .then(html => {
          document.querySelector('#get-user-edit').innerHTML = html;
          initializeEditUserForm();
      })
      .catch(error => {
          console.error('Error loading user edit form:', error);
      });
}

function initializeEditUserForm() {
  const editUserForm = document.querySelector('#edit-user-form');
  if (editUserForm) {
      editUserForm.addEventListener('submit', function (event) {
          event.preventDefault();

          const formData = new FormData(event.target);

          fetch('update_user.php', {
              method: 'POST',
              body: formData
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  window.location.href = 'users.php';
              } else {
                  alert('Klaida atnaujinant vartotoją.');
              }
          })
          .catch(error => {
              console.error('Klaida:', error);
              alert('Klaida atnaujinant vartotoją.');
          });
      });
  }

  const cancelEditUserBtn = document.querySelector('#cancel-edit-user');
  if (cancelEditUserBtn) {
      cancelEditUserBtn.addEventListener('click', function () {
          window.location.href = 'users.php';
      });
  }
}

const cancelEditUserBtn = document.querySelector('#cancel-edit-user');
if (cancelEditUserBtn) {
  cancelEditUserBtn.addEventListener('click', function () {
      window.location.href = 'users.php';
  });
}


// Paspaudus ištrynimo mygtuką, atidaro patvirtinimo modalą
    $('button[data-bs-target="#deleteUserModal"]').on('click', function () {
      const userId = $(this).data('user-id');
      $('#confirmDeleteModal').data('user-id', userId);
      $('#confirmDeleteModal').modal('show');
    });
  
    // Paspaudus patvirtinimo mygtuką, ištrina kategoriją
    $('#confirm-delete-btn').on('click', function () {
      const userId = $('#confirmDeleteModal').data('user-id');
      
      // Siunčia POST užklausą į delete_user.php failą
      $.ajax({
        type: 'POST',
        url: 'delete_user.php',
        data: {
          action: 'delete_user',
          user_id: userId
        },
        success: function(response) {
          // Uždaro modalą ir peradresuoja į categories.php puslapį
          $('#confirmDeleteModal').modal('hide');
          window.location.href = 'users.php';
        },
        error: function(jqXHR, textStatus, errorThrown) {
          // Rodo klaidos pranešimą
          console.error(textStatus, errorThrown);
        }
      });
    });
    