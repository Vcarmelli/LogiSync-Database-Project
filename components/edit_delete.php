
<?php if ($whichTable === 'supplier'): ?>
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

<?php elseif ($whichTable === 'product'): ?>
<td><button type="button" class="stock btn btn-stock mx-2">Out of Stock</button></td>
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

<?php elseif ($whichTable === 'purchaseorder'): ?>
<td><button type="button" class="print btn btn-stock mx-2">Print</button></td>
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

<?php endif; ?>
