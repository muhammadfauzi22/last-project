<?= $this->extend('layout\coreframe') ?>

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

    .item .field {
        flex: 1;
    }

    .item .field input {
        width: 100%;
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


    .card {
        width: 50%;
        margin: 0 auto;
        border-radius: 8px;
        overflow: hidden;
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

<form id="invoice-form" onsubmit="submitForm(event)">
    <div class="card">
        <header class="card-header has-background-info">
            <h1 class="card-header-title has-text">Pengajuan Faktur</h1>
        </header>
        <div class="card-content">
            <div class="field">
                <label class="label">Nama Faktur</label>
                <div class="control has-icons-left has-icons-right">
                    <input id="invoice_name" name="invoice_name" class="input is-success" type="text" placeholder="Nama" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-font"></i>
                    </span>
                    <span class="icon is-small is-right">
                        <i class="fas fa-check"></i>
                    </span>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Tahun</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input is-success" id="year" name="year" type="number" placeholder="Tahun">
                            <span class="icon is-small is-left">
                                <i class="fas fa-calendar"></i>
                            </span>
                        </p>
                    </div>
                    <div class="field-label is-normal">
                        <label class="label">Semester</label>
                    </div>
                    <div class="field">
                        <div class="control">
                            <div class="select">
                                <select id="semester" name="semester" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="width: 75%;">
        <header class="card-header has-background-info">
            <h3 class="card-header-title has-text">Detail Barang</h3>
        </header>
        <div class="card-content">
            <div class="items" id="items-container">
                <div class="item">
                    <div class="field">
                        <div class="control has-icons-left has-icons-right">
                            <input type="text" name="item_name" placeholder="Nama Barang" class="input is-success" required>
                            <span class="icon is-small is-left">
                                <i class="fas fa-gift"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control has-icons-left has-icons-right">
                            <input type="number" name="item_quantity" placeholder="Jumlah" class="input is-success" required>
                            <span class="icon is-small is-left">
                                <i class="fas fa-hashtag"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control has-icons-left has-icons-right">
                            <input type="number" name="item_price" placeholder="Harga" class="input is-success" required>
                            <span class="icon is-small is-left">
                                <i class="fas fa-money-bill-wave"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="actions">
                <div class="field">
                    <div class="control">
                        <button type="button" class="button has-background-light" onclick="addItem()">Add Item</button>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button class="button is-info">Submit</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

<?= $this->endSection() ?>