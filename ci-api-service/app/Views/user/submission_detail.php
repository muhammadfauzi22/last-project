<?= $this->extend('layout\coreframe') ?>

<?= $this->section('title') ?>
Detail Faktur
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .card {
        width: 50%;
        margin: 0 auto;
        border-radius: 8px;
        overflow: hidden;
    }

    .detail {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin: 20px 0;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-title {
        font-weight: bold;
    }

    .detail-content {
        flex-grow: 1;
        text-align: right;
    }

    .rejectForm-group {
        margin-bottom: 15px;
    }

    .reviseForm-group {
        margin-bottom: 15px;
    }

    .modal-card {
        border: 1px solid #ddd;
        /* Border around the modal card */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Shadow for the modal card */
    }

    .modal-card-head .modal-card-title,
    .modal-card-head .delete {
        color: #fff;
        /* White text and icon color for contrast */
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-approve {
        background-color: #4CAF50;
        color: white;
    }

    .btn-approve:hover {
        background-color: #45a049;
    }

    .btn-reject {
        background-color: #f44336;
        color: white;
    }

    .btn-reject:hover {
        background-color: #d32f2f;
    }

    .btn-confirm {
        background-color: #2196F3;
        color: white;
    }

    .btn-confirm:hover {
        background-color: #1976D2;
    }

    .btn-revise {
        background-color: #FF9800;
        color: white;
    }

    .btn-revise:hover {
        background-color: #F57C00;
    }

    .btn-change {
        background-color: #9C27B0;
        color: white;
    }

    .btn-change:hover {
        background-color: #7B1FA2;
    }

    .btn-resubmit {
        background-color: #2196F3;
        color: white;
    }

    .btn-resubmit:hover {
        background-color: #1976D2;
    }

    .btn-upload {
        background-color: #3F51B5;
        color: white;
    }

    .btn-upload:hover {
        background-color: #303F9F;
    }

    .btn-edit {
        background-color: #3F51B5;
        color: white;
    }

    .btn-edit:hover {
        background-color: #303F9F;
    }

    .btn-delete {
        background-color: #d32f2f;
        color: white;
    }

    .btn-delete:hover {
        background-color: #d32f2f;
    }

    .btn-add {
        background-color: #303F9F;
        color: white;
    }

    .btn-add:hover {
        background-color: #303F9F;
    }

    .btn-primary {
        background-color: #4CAF50;
        color: white;
    }

    .btn-primary:hover {
        background-color: #45a049;
    }
</style>

<div class="card">
    <header class="card-header has-background-info">
        <h1 class="card-header-title has-text">Detail Pengajuan</h1>
    </header>
    <div class="card-content">
        <div class="detail">
            <div class="detail-row">
                <div class="detail-title">Tahun:</div>
                <div class="detail-content">
                    <span class="detail-static"><?= $Submission != null ? $Submission[0]['year'] : ''; ?></span>
                    <input id="year" type="text" class="detail-input" value="<?= $Submission != null ? $Submission[0]['year'] : ''; ?>" hidden>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Semester:</div>
                <div class="detail-content">
                    <span class="detail-static"><?= $Submission != null ? $Submission[0]['semester'] : ''; ?></span>
                    <input id="semester" type="text" class="detail-input" value="<?= $Submission != null ? $Submission[0]['semester'] : ''; ?>" hidden>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Pengaju:</div>
                <div class="detail-content"><?= $Submission != null ? $Submission[0]['username_request'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Nama Faktur:</div>
                <div class="detail-content">
                    <span class="detail-static"><?= $Submission != null ? $Submission[0]['name'] : ''; ?></span>
                    <input id="name" type="text" class="detail-input" value="<?= $Submission != null ? $Submission[0]['name'] : ''; ?>" hidden>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Status:</div>
                <div class="detail-content"><?= $Submission != null ? $Submission[0]['status'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Alasan Penolakan:</div>
                <div class="detail-content"><?= $Submission != null ? $Submission[0]['reason_rejected'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Alasan Revisi:</div>
                <div class="detail-content"><?= $Submission != null ? $Submission[0]['reason_need_revision'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Total Kuantitas:</div>
                <div class="detail-content"><?= $Submission != null ? $Submission[0]['total_qty'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Total Harga:</div>
                <div class="detail-content"><?= $Submission != null ? $Submission[0]['total_price'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">File Faktur:</div>
                <div class="detail-content"><?php if ($Submission != null && !empty($Submission[0]['invoice_dir'])) : ?>
                        <a href="<?= base_url('files/serve/' . basename($Submission[0]['invoice_dir'])); ?>" target="_blank" title="View File">
                            <i class="fas fa-file-alt"></i>
                        </a>
                    <?php else : ?>
                        Tidak ada file
                    <?php endif; ?>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Dibuat Pada:</div>
                <div class="detail-content"><?= $Submission != null ? $Submission[0]['created_at'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Diperbaharui Pada:</div>
                <div class="detail-content"><?= $Submission != null ? $Submission[0]['updated_at'] : ''; ?></div>
            </div>
        </div>
        <div class="actions">
            <?php if ((in_array("atasan.approve-1", session()->get('permissions')) && session()->get('active_group') == 'atasan' && $Submission[0]['status'] == 'pending_approval_one') || (in_array("hrd.approve-2", session()->get('permissions')) && session()->get('active_group') == 'hrd' && $Submission[0]['status'] == 'pending_approval_two')) { ?>
                <a type="button" id="approve" class="btn btn-approve is-success" data-status=1 onclick="UpdateSubmission(this.id)">Setujui</a><?php } ?>
            <?php if ((in_array("atasan.reject-1", session()->get('permissions')) && session()->get('active_group') == 'atasan' && $Submission[0]['status'] == 'pending_approval_one') || (in_array("hrd.reject-2", session()->get('permissions'))  && session()->get('active_group') == 'hrd' && $Submission[0]['status'] == 'pending_approval_two')) { ?>
                <a type="button" id="reject" class="btn btn-reject is-danger js-modal-trigger" data-status=0 data-target="rejectModal">Tolak</a><?php } ?>
            <?php if ((in_array("atasan.revise-1", session()->get('permissions')) && session()->get('active_group') == 'atasan' && $Submission[0]['status'] == 'pending_approval_one') || (in_array("hrd.revise-2", session()->get('permissions'))  && session()->get('active_group') == 'hrd' && $Submission[0]['status'] == 'pending_approval_two')) { ?>
                <a type="button" id="revise" class="btn btn-revise is-warning js-modal-trigger" data-status=2 data-target="reviseModal">Revisi</a><?php } ?>
            <?php if (in_array("pegawai.edit", session()->get('permissions')) && session()->get('active_group') == 'pegawai' && $Submission[0]['status'] == 'need_revision') { ?>
                <button type="button" id="submitButton" class="btn btn-primary is-success" hidden>Submit Changes</button>
                <a type="button" id="resubmit" class="btn btn-resubmit is-link" onclick="resubmit()">Ajukan Ulang</a>
                <a type="button" id="edit" class="btn btn-change is-warning" onclick="showButtons()">Ubah</a><?php } ?>
            <?php if (in_array("pegawai.upload", session()->get('permissions')) && session()->get('active_group') == 'pegawai' && $Submission[0]['status'] == 'wait_document') { ?>
                <a type="button" id="upload" class="btn btn-upload is-link">Upload File Faktur</a>
                <form id="uploadForm" method="post" enctype="multipart/form-data">
                    <input type="file" id="fileInput" name="file" hidden>
                </form>
            <?php } ?>
            <?php if (in_array("pengesah.finalize", session()->get('permissions')) && session()->get('active_group') == 'pengesah' && $Submission[0]['status'] == 'pending_approval_authenticator') { ?>
                <a type="button" id="finalize" class="btn btn-confirm is-success" data-status=3 onclick="UpdateSubmission(this.id)">Sahkan</a><?php } ?>
        </div>
    </div>
</div>




<div class="card">
    <header class="card-header has-background-info">
        <h3 class="card-header-title has-text">Detail Barang Pengajuan</h3>
    </header>
    <div class="card-content">
        <div class="table-container">
            <table class="table is-striped is-hoverable" id="submissionTable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total Harga</th>
                        <th>Dibuat Pada</th>
                        <th>Diperbaharui Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($Submission != null) { ?>
                        <?php foreach ($Submission as $data) { ?>
                            <tr data-id="<?= $data['submission_item_id']; ?>">
                                <td><span class="detail-static"><?= $data['item_name']; ?></span>
                                    <input type="text" name="item_name" class="detail-input" value="<?= $data['item_name']; ?>" hidden>
                                </td>
                                <td><span class="detail-static"><?= $data['qty']; ?></span>
                                    <input type="text" name="qty" class="detail-input" value="<?= $data['qty']; ?>" hidden>
                                </td>
                                <td><span class="detail-static"><?= $data['price']; ?></span>
                                    <input type="text" name="price" class="detail-input" value="<?= $data['price']; ?>" hidden>
                                </td>
                                <td><?= $data['total_item_price']; ?>
                                </td>
                                <td><?= $data['created_at']; ?></td>
                                <td><?= $data['updated_at']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-edit" hidden>Edit</button>
                                    <button type="button" class="btn btn-delete" hidden>Delete</button>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-add is-link" hidden>Add Row</button>
    </div>
</div>




<!-- Edit Form Modal -->
<div id="rejectModal" class="modal rejectModal">
    <div class="modal-card">
        <header class="modal-card-head" style="background-color: #ff3860">
            <p class="modal-card-title">Pemutusan Penolakan</p>
            <button class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
            <form id="rejectForm" data-status=0 onsubmit="UpdateSubmission(this.id)">
                <input type="hidden" id="rejectId">
                <div class="rejectForm-group">
                    <textarea id="rejectReason" name="reason" class="form-control textarea is-danger" placeholder="Alasan Penolakan" required></textarea>
                </div>
                <button type="submit" class="btn btn-reject is-danger">Tolak</button>
            </form>
        </section>
    </div>
</div>

<div id="reviseModal" class="modal reviseModal">
    <div class="modal-card reviseModal-content">
        <header class="modal-card-head" style="background-color: #ffdd57">
            <p class="modal-card-title">Pemutusan Revisi</p>
            <button class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
            <form id="reviseForm" data-status=2 onsubmit="UpdateSubmission(this.id)">
                <input type="hidden" id="reviseId">
                <div class="reviseForm-group">
                    <textarea id="reviseReason" name="reason" class="form-control textarea is-warning" placeholder="Alasan Revisi" required></textarea>
                </div>
                <button type="submit" class="btn btn-revise is-warning">Revisi</button>
            </form>
        </section>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function UpdateSubmission(val) {
        event.preventDefault();
        var Data = {
            id: "<?= $Submission[0]['id']; ?>",
            user_id: "<?= session()->get('user_id'); ?>",
            group: "<?= session()->get('active_group'); ?>",
            value: val,
            status: document.getElementById(val).getAttribute('data-status'),
        };
        if (document.getElementById("rejectReason").value != "") {
            Data['reason_rejected'] = document.getElementById("rejectReason").value;
        }
        if (document.getElementById("reviseReason").value != "") {
            Data['reason_need_revision'] = document.getElementById("reviseReason").value;
        }
        Swal.fire({
            title: 'Pengolahan Data Pengajuan Sedang Diproses.',
            html: 'Mohon Tunggu. Jangan keluar dari halaman.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            didOpen: () => {
                Swal.showLoading()
            }
        })
        $.ajax({
            url: '/api/update-submission',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(Data),
            success: function(response) {
                Swal.fire(
                    'Pemutusan Berhasil!',
                    '',
                    'success'
                ).then(() => {
                    location.reload(true);
                });
            },
            error: function(xhr) {
                Swal.fire(
                    'Pemutusan Gagal!',
                    xhr.responseText,
                    'error'
                );
            }
        });
    }

    function resubmit() {
        var Data = {
            id: "<?= $Submission[0]['id']; ?>"
        };
        Swal.fire({
            title: 'Pengajuan Ulang Sedang Diproses.',
            html: 'Mohon Tunggu. Jangan keluar dari halaman.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            didOpen: () => {
                Swal.showLoading()
            }
        })
        $.ajax({
            url: '/api/resubmit-submission',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(Data),
            success: function(response) {
                Swal.fire(
                    'Pengajuan Ulang Berhasil!',
                    '',
                    'success'
                ).then(() => {
                    location.reload(true);
                });
            },
            error: function(xhr) {
                Swal.fire(
                    'Pengajuan Ulang Gagal!',
                    xhr.responseText,
                    'error'
                );
            }
        });
    }

    // var rejectModal = document.getElementById("rejectModal");
    // var reviseModal = document.getElementById("reviseModal");
    // var closeRejectModalButton = rejectModal.querySelector(".close");
    // var closeReviseModalButton = reviseModal.querySelector(".close");

    // // When the user clicks on <span> (x), close the modal
    // closeRejectModalButton.onclick = function() {
    //     rejectModal.style.display = "none";
    // }
    // closeReviseModalButton.onclick = function() {
    //     reviseModal.style.display = "none";
    // }
    // window.onclick = function(event) {
    //     if (event.target == rejectModal) {
    //         rejectModal.style.display = "none";
    //     } else if (event.target == reviseModal) {
    //         reviseModal.style.display = "none";
    //     }
    // }

    // function showRejectModal() {
    //     rejectModal.style.display = "block";
    // }

    document.addEventListener('DOMContentLoaded', () => {
        // Functions to open and close a modal
        function openModal($el) {
            $el.classList.add('is-active');
        }

        function closeModal($el) {
            $el.classList.remove('is-active');
        }

        function closeAllModals() {
            (document.querySelectorAll('.modal') || []).forEach(($modal) => {
                closeModal($modal);
            });
        }

        // Add a click event on buttons to open a specific modal
        (document.querySelectorAll('.js-modal-trigger') || []).forEach(($trigger) => {
            const modal = $trigger.dataset.target;
            const $target = document.getElementById(modal);

            $trigger.addEventListener('click', () => {
                openModal($target);
            });
        });

        // Add a click event on various child elements to close the parent modal
        (document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(($close) => {
            const $target = $close.closest('.modal');

            $close.addEventListener('click', () => {
                closeModal($target);
            });
        });

        // Add a keyboard event to close all modals
        document.addEventListener('keydown', (event) => {
            if (event.key === "Escape") {
                closeAllModals();
            }
        });
    });

    // function showReviseModal() {
    //     reviseModal.style.display = "block";
    // }

    if (document.getElementById('upload')) {
        document.getElementById('upload').addEventListener('click', function() {
            document.getElementById('fileInput').click();
        });
    }
    if (document.getElementById('fileInput')) {
        document.getElementById('fileInput').addEventListener('change', function() {
            if (this.files.length > 0) {
                var formData = new FormData($('#uploadForm')[0]);
                Swal.fire({
                    title: 'Upload File Sedang Diproses.',
                    html: 'Mohon Tunggu. Jangan keluar dari halaman.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                })
                $.ajax({
                    url: '/api/upload-submission', // Replace with your controller method URL
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var jsonData = {
                            id: "<?= $Submission[0]['id']; ?>",
                            invoice_dir: response.data
                        };
                        $.ajax({
                            url: '/api/upload-status-submission', // Replace with your controller method URL
                            type: 'POST',
                            data: JSON.stringify(jsonData),
                            success: function(response) {
                                Swal.fire(
                                    'Upload File Berhasil!',
                                    '',
                                    'success'
                                ).then(() => {
                                    location.reload(true);
                                });
                                // Handle success response
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Upload File Gagal!',
                                    xhr.responseText,
                                    'error'
                                );
                                // Handle error response
                            }
                        });
                        // Handle success response
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Upload File Gagal!',
                            xhr.responseText,
                            'error'
                        );
                        // Handle error response
                    }
                });
            }
        });
    }

    function showButtons() {
        // Show hidden button in the second container
        const buttons = document.querySelectorAll('.card button');
        buttons.forEach(button => {
            button.hidden = false;
        });

        // Show hidden inputs in the first container
        const inputs = document.querySelectorAll('.card input');
        inputs.forEach(input => {
            input.hidden = false;
        });

        // Hide visible spans in the first container
        const spans = document.querySelectorAll('.card span');
        spans.forEach(span => {
            span.hidden = true;
        });
    }

    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            row.querySelectorAll('.detail-static').forEach(span => span.hidden = true);
            row.querySelectorAll('.detail-input').forEach(input => input.hidden = false);
        });
    });

    // Add new row functionality
    document.querySelector('.btn-add').addEventListener('click', function() {
        const table = document.getElementById('submissionTable').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();
        newRow.innerHTML = `
            <td><input type="text" name="item_name" class="detail-input" value=""></td>
            <td><input type="text" name="qty" class="detail-input" value=""></td>
            <td><input type="text" name="price" class="detail-input" value=""></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <button type="button" class="btn btn-edit">Edit</button>
                <button type="button" class="btn btn-delete">Delete</button>
            </td>
        `;
    });

    // Delete row functionality
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            row.remove();
        });
    });

    // Submit edited data
    function submitEditedData() {
        const data = {
            id: "<?= $Submission[0]['id']; ?>",
            year: document.getElementById("year").value,
            semester: document.getElementById("semester").value,
            name: document.getElementById("name").value,
            details: []
        };

        document.querySelectorAll('#submissionTable tbody tr').forEach(row => {
            const rowData = {
                id: (row.getAttribute('data-id') === null) ? 0 : row.getAttribute('data-id'),
                item_name: row.querySelector('input[name="item_name"]').value,
                qty: row.querySelector('input[name="qty"]').value,
                price: row.querySelector('input[name="price"]').value
            };
            data.details.push(rowData);
        });
        Swal.fire({
            title: 'Pengubahan Data Sedang Diproses.',
            html: 'Mohon Tunggu. Jangan keluar dari halaman.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            didOpen: () => {
                Swal.showLoading()
            }
        })
        $.ajax({
            url: '/api/change-submission',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(response) {
                Swal.fire(
                    'Pengubahan Data Berhasil!',
                    '',
                    'success'
                ).then(() => {
                    location.reload(true);
                });
            },
            error: function(xhr) {
                Swal.fire(
                    'Pengubahan Data Gagal!',
                    xhr.responseText,
                    'error'
                );
            }
        });
    }

    // Attach submit event to your form or button
    if (document.getElementById('submitButton')) {
        document.getElementById('submitButton').addEventListener('click', submitEditedData);
    }
</script>
<?= $this->endSection() ?>