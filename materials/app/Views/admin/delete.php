<?php
    /**
     * MODAL: confirmation for delete.
     *
     * @param string $itemType type of item to be deleted (material/...)
     */
?>
<form class="modal" id="delete-window">

    <div class="modal__content">
        <div class="modal__header">
            <h1 id="delete-title">Confirm deletion</h1>
            <span class="modal__close" id="delete-close" onclick="deleteClose()">&#10005</span>
        </div>

        <div class="modal__body">
            <p id="delete-message">
                Warning: This action is irreversible!<br>
                Are you sure you want to delete <?= $itemType ?? 'item' ?> with id: <strong>[]</strong>?
            </p>
        </div>

        <div class="modal__footer">
            <div class="modal__button-group">
                <button type="submit" class="modal__button modal__button--red">Delete</button>
                <button type="button" class="modal__button" onclick="deleteClose()">Cancel</button>
            </div>
        </div>
</form>

    <script type="text/javascript">
        const deleteModal = document.getElementById("delete-window");

        const titleElement = deleteModal.querySelector('#delete-title');
        const titleOriginal = titleElement.innerHTML;

        const messageElement = deleteModal.querySelector('#delete-message');
        const messageOriginal = messageElement.innerHTML;

        const deleteOpen = (id) => {
            messageElement.innerHTML = messageOriginal.replace('[]', `[${id}]`);
            deleteModal.setAttribute('data-value', id);
            deleteModal.classList.add('modal--visible');
        }

        const deleteClose = () => {
            deleteModal.classList.remove('modal--visible');
        }

        window.addEventListener("click", function(event)
        {
            if (event.target == deleteModal) {
                deleteClose();
            }
        });

        deleteModal.addEventListener("submit", async function(event) {
            event.preventDefault();

            const response = await fetch(
                '<?= $action ?>'.replace(/([0-9]+|@segment@)$/, deleteModal.getAttribute('data-value')),
                { method: 'DELETE' }
            );

            if (!response.ok) {
                messageElement.innerHTML ="Item with id: <strong>" +
                    deleteModal.getAttribute('data-value') +
                    "</strong> could not be deleted." +
                    "<br><em style='margin: 1rem; color: red;'>" + response.statusText + "</em>" +
                    "<br>Do you want to try again?";
                return;
            }

            const data = await response.json();
            document.getElementById(data.id)?.remove();
            deleteClose();
        });
    </script>
</div>
