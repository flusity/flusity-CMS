
 $(document).ready(function() {
    $(".droppable-area").sortable({
        connectWith: ".droppable-area",
        stop: function(event, ui) {
            const blockId = $(ui.item).data('block-id');
            const newPlaceId = $(ui.item).closest('.droppable-area').data('place-id');
            const blockType = $(ui.item).data('block-type');
            const addonName = $(ui.item).data('addon-name');  // Naujas atributas

            const singleMovedBlock = {
                blockId,
                newPlaceId,
                blockType,
                addonName  // Įtraukiamas naujas atributas
            };

            $.ajax({
                url: '../../core/tools/actions/update_order.php',
                method: 'POST',
                data: { singleMovedBlock: singleMovedBlock },
                success: function(response) {
                    try {
                        const parsedResponse = JSON.parse(response);
                        if (parsedResponse.newPlaceId) {
                            $(ui.item).attr('data-place-id', parsedResponse.newPlaceId);
                        }
                        location.reload();
                    } catch (e) {
                        console.error("Nepavyko apdoroti serverio atsakymo:", e);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX klaida:", error);
                    console.error("Pilnas atsakymas:", xhr.responseText);
                }
            });
        }
    });
});