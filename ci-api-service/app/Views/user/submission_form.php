<?= $this->extend('layout\page_layout') ?>

<?= $this->section('title') ?>
Pengajuan Faktur
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .container {
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        width: 80%;
        padding: 20px;
        overflow: hidden;
    }

    .header {
        background-color: #4CAF50;
        color: white;
        padding: 15px;
        text-align: center;
        border-radius: 8px 8px 0 0;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #4CAF50;
    }

    .form-group input,
    .form-group select {
        width: calc(100% - 22px);
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .form-group input[type="file"] {
        padding: 0;
    }

    .items {
        margin-top: 20px;
    }

    .item {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
    }

    .item input {
        flex: 1;
    }

    .actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }

    .actions button {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-add-item {
        background-color: #2196F3;
        color: white;
    }

    .btn-add-item:hover {
        background-color: #1976D2;
    }

    .btn-submit {
        background-color: #4CAF50;
        color: white;
    }

    .btn-submit:hover {
        background-color: #45A049;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function addItem() {
        const itemsContainer = document.getElementById('items-container');
        const itemTemplate = document.querySelector('.item').cloneNode(true);
        itemTemplate.querySelectorAll('input').forEach(input => input.value = '');
        itemsContainer.appendChild(itemTemplate);
    }

    function submitForm(event) {
        event.preventDefault(); // Prevent the default form submission
        const form = document.getElementById('invoice-form');
        const formData = new FormData(form);
        const jsonObject = {};
        const items = document.querySelectorAll('.item');
        const itemCount = items.length;
        const sessionData = {
            userId: "<?= session()->get('user_id'); ?>",
            multipleItem: (itemCount != 1) ? true : false
        };
        formData.forEach((value, key) => {

            if (!jsonObject[key]) {
                jsonObject[key] = value;
            } else {
                if (!Array.isArray(jsonObject[key])) {
                    jsonObject[key] = [jsonObject[key]];
                }
                jsonObject[key].push(value);
            }
        });
        jsonObject.id = sessionData.userId;
        jsonObject.multipleItem = sessionData.multipleItem;
        Swal.fire({
            title: 'Pengajuan Sedang Diproses.',
            html: 'Mohon Tunggu. Jangan keluar dari halaman.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            didOpen: () => {
                Swal.showLoading()
            }
        })
        $.ajax({
            url: '/api/add-submission',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(jsonObject),
            success: function(response) {
                Swal.fire(
                    'Pengajuan Berhasil!',
                    '',
                    'success'
                ).then(() => {
                    window.location.href = '/dashboard';
                });
            },
            error: function(xhr) {
                Swal.fire(
                    'Pengajuan Gagal!',
                    xhr.responseText,
                    'error'
                );
            }
        });
    }
</script>

<div class="header">
    <h1>Invoice Submission</h1>
</div>
<form id="invoice-form" onsubmit="submitForm(event)">
    <div class="form-group">
        <label for="invoice_name">Invoice Name:</label>
        <input type="text" id="invoice_name" name="invoice_name" required>
    </div>
    <div class="form-group">
        <label for="year">Year:</label>
        <input type="number" id="year" name="year" required>
    </div>
    <div class="form-group">
        <label for="semester">Semester:</label>
        <select id="semester" name="semester" required>
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
    </div>
    <?php /*
    <div class="form-group">
        <label for="file">Upload File:</label>
        <input type="file" id="file" name="file" required>
    </div>
    */ ?>
    <div class="items" id="items-container">
        <div class="item">
            <input type="text" name="item_name" placeholder="Item Name" required>
            <input type="number" name="item_quantity" placeholder="Quantity" required>
            <input type="number" name="item_price" placeholder="Price" step="0.01" required>
        </div>
    </div>
    <div class="actions">
        <button type="button" class="btn-add-item" onclick="addItem()">Add Item</button>
        <button type="submit" class="btn-submit">Submit Invoice</button>
    </div>
</form>

<?= $this->endSection() ?>