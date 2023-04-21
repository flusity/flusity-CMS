function loadCustomBlockForm(mode, customBlockId = null) {
    const url = mode === 'edit' ? 'get_customblock.php?customblock_id=' + customBlockId : 'get_customblock.php';
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.querySelector('#get-customblock-edit').innerHTML = html;
            initializeCustomBlockForm(mode);
        })
        .catch(error => {
            console.error('Error loading customblock form:', error);
        });
}

function initializeCustomBlockForm(mode) {
    const customBlockForm = document.querySelector('#customblock-form');
    if (customBlockForm) {
        customBlockForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const url = mode === 'edit' ? 'update_customblock.php' : 'add_customblock.php';

            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'customblock.php';
                } else {
                    alert(mode === 'edit' ? 'Klaida atnaujinant customblock.1' : 'Klaida pridedant customblock.1');
                }
            })
            .catch(error => {
                console.error('Klaida:', error);
                alert(mode === 'edit' ? 'Klaida atnaujinant customblock.2' : 'Klaida pridedant customblock.2');
            });
        });
    }

    const cancelCustomBlockBtn = document.querySelector('#cancel-customblock');
    if (cancelCustomBlockBtn) {
        cancelCustomBlockBtn.addEventListener('click', function () {
            window.location.href = 'customblock.php';
        });
    }
}

// Add additional event handlers and AJAX calls for customblock-specific actions.

  

  
  