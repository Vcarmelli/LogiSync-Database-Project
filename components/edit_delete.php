<td class="mx-5">
    <div class="d-flex gap-4">
        <a href="#" class="edit text-primary" data-bs-toggle="modal" data-bs-target="#dynamicEditModal">
        <i class="fa-solid fa-pen-to-square fs-5"></i>
        </a>
        <a href="#" class="delete text-danger" data-bs-toggle="modal" data-bs-target="#dynamicDeleteModal">
            <i class="fa-solid fa-trash-can fs-5"></i>
        </a>
    </div>
    
</td>


<!-- EDIT Modal -->
<div class="modal fade mt-5" id="dynamicEditModal" tabindex="-1" aria-labelledby="dynamicEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content px-4 py-3" id="editModalContent"></div>
    </div>
</div>


<!-- DELETE Modal -->
<div class="modal fade mt-5" id="dynamicDeleteModal" tabindex="-1" aria-labelledby="dynamicDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content px-4 py-3 modal-size" id="deleteModalContent"></div>
    </div>
</div>