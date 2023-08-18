
function loadCustomBlockForm(mode, customBlock) {
    let url = 'get_customblock.php';

    if (mode === 'edit') {
        url += '?customblock_id=' + customBlock;
    } else if (mode === 'create') {
        url += '?customblock_place=' + customBlock;
    }

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


/* function loadCustomBlockForm(mode, customBlockId = null) {
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
} */

function initializeCustomBlockForm(mode) {
 /*    ClassicEditor
    .create( document.querySelector( '#customblock_html_code' ), {
        // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
    } )
    .then( editor => {
        window.editor = editor;
    } )
    .catch( err => {
        console.error( err.stack );
    } ); */
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
                    alert(mode === 'edit' ? 'Error updating customblock' : 'Error adding customblock');
                }
            })
            .catch(error => {
                console.error('Klaida:', error);
                alert(mode === 'edit' ? 'Error updating customblock2' : 'Error adding customblock2');
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