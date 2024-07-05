<?= $this->extend('layout\page_layout') ?>

<?= $this->section('title') ?>
Detail Faktur
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 80%;
        margin: 50px auto;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        padding: 20px;
    }

    .container1 {
        width: 80%;
        margin: 50px auto;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        padding: 20px;
    }

    .container2 {
        width: 80%;
        margin: 50px auto;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        padding: 20px;
    }

    .header {
        background-color: #4CAF50;
        color: white;
        padding: 15px;
        text-align: center;
        border-radius: 8px 8px 0 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
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
        color: #4CAF50;
    }

    .detail-content {
        flex-grow: 1;
        text-align: right;
        color: #555;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #e9e9e9;
    }

    .actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
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

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        border-radius: 8px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .modal {
        display: none;
        position: absolute;
    }

    .rejectModal {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .rejectModal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        border-radius: 8px;
    }

    .rejectForm-group {
        margin-bottom: 15px;
    }

    .rejectForm-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .rejectForm-group textarea {
        width: 100%;
        height: 150px;
        /* Adjust the height as needed */
        padding: 10px;
        box-sizing: border-box;
        border-radius: 4px;
        border: 1px solid #ccc;
        resize: vertical;
    }

    .reviseModal {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .reviseModal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        border-radius: 8px;
    }

    .reviseForm-group {
        margin-bottom: 15px;
    }

    .reviseForm-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .reviseForm-group textarea {
        width: 100%;
        height: 150px;
        /* Adjust the height as needed */
        padding: 10px;
        box-sizing: border-box;
        border-radius: 4px;
        border: 1px solid #ccc;
        resize: vertical;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-primary {
        background-color: #4CAF50;
        color: white;
    }

    .btn-primary:hover {
        background-color: #45a049;
    }
</style>
<!-- Existing content -->

<body>
    <div class="container1">
        <div class="header">
            <h1>Detail Pengajuan</h1>
        </div>
        <div class="detail">
            <div class="detail-row">
                <div class="detail-title">Year:</div>
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
                <div class="detail-title">Request User:</div>
                <div class="detail-content"><?= $Submission != null ? $Submission[0]['username_request'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Invoice Name:</div>
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
                <div class="detail-title">Reason rejected:</div>
                <div class="detail-content"><?= $Submission != null ? $Submission[0]['reason_rejected'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Reason need revision:</div>
                <div class="detail-content"><?= $Submission != null ? $Submission[0]['reason_need_revision'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Total Quantity:</div>
                <div class="detail-content"><?= $Submission != null ? $Submission[0]['total_qty'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Total Price:</div>
                <div class="detail-content"><?= $Submission != null ? $Submission[0]['total_price'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Invoice Dir:</div>
                <div class="detail-content"><?php if ($Submission != null && !empty($Submission[0]['invoice_dir'])) : ?>
                        <a href="<?= base_url('files/serve/' . basename($Submission[0]['invoice_dir'])); ?>" target="_blank" title="View File">
                            <i class="fas fa-file-alt"></i>
                        </a>
                    <?php else : ?>
                        No file available
                    <?php endif; ?>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Created At:</div>
                <div class="detail-content"><?= $Submission != null ? $Submission[0]['created_at'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Updated At:</div>
                <div class="detail-content"><?= $Submission != null ? $Submission[0]['updated_at'] : ''; ?></div>
            </div>
        </div>
        <div class="actions">
            <?php if ((in_array("atasan.approve-1", session()->get('permissions')) && session()->get('active_group') == 'atasan' && $Submission[0]['status'] == 'pending_approval_one') || (in_array("hrd.approve-2", session()->get('permissions')) && session()->get('active_group') == 'hrd' && $Submission[0]['status'] == 'pending_approval_two')) { ?>
                <a type="button" id="approve" class="btn btn-approve" data-status=1 onclick="UpdateSubmission(this.id)">Setujui</a><?php } ?>
            <?php if ((in_array("atasan.reject-1", session()->get('permissions')) && session()->get('active_group') == 'atasan' && $Submission[0]['status'] == 'pending_approval_one') || (in_array("hrd.reject-2", session()->get('permissions'))  && session()->get('active_group') == 'hrd' && $Submission[0]['status'] == 'pending_approval_two')) { ?>
                <a type="button" id="reject" class="btn btn-reject" data-status=0 onclick="showRejectModal()">Tolak</a><?php } ?>
            <?php if ((in_array("atasan.revise-1", session()->get('permissions')) && session()->get('active_group') == 'atasan' && $Submission[0]['status'] == 'pending_approval_one') || (in_array("hrd.revise-2", session()->get('permissions'))  && session()->get('active_group') == 'hrd' && $Submission[0]['status'] == 'pending_approval_two')) { ?>
                <a type="button" id="revise" class="btn btn-revise" data-status=2 onclick="showReviseModal()">Revisi</a><?php } ?>
            <?php if (in_array("pegawai.edit", session()->get('permissions')) && session()->get('active_group') == 'pegawai' && $Submission[0]['status'] == 'need_revision') { ?>
                <button type="button" id="submitButton" class="btn btn-primary" hidden>Submit Changes</button>
                <a type="button" id="resubmit" class="btn btn-resubmit" onclick="resubmit()">Ajukan Ulang</a>
                <a type="button" id="edit" class="btn btn-change" onclick="showButtons()">Ubah</a><?php } ?>
            <?php if (in_array("pegawai.upload", session()->get('permissions')) && session()->get('active_group') == 'pegawai' && $Submission[0]['status'] == 'wait_document') { ?>
                <a type="button" id="upload" class="btn btn-upload">Upload File Faktur</a>
                <form id="uploadForm" method="post" enctype="multipart/form-data">
                    <input type="file" id="fileInput" name="file" hidden>
                </form>
            <?php } ?>
            <?php if (in_array("pengesah.finalize", session()->get('permissions')) && session()->get('active_group') == 'pengesah' && $Submission[0]['status'] == 'pending_approval_authenticator') { ?>
                <a type="button" id="finalize" class="btn btn-confirm" data-status=3 onclick="UpdateSubmission(this.id)">Sahkan</a><?php } ?>
        </div>
    </div>

    <div class="container2">
        <div class="header">
            <h1>Detail Barang Pengajuan</h1>
        </div>
        <table id="submissionTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
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
        <button type="button" class="btn btn-add" hidden>Add Row</button>
    </div>

    <!-- Edit Form Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Submission</h2>
            <form id="editForm" method="post" action="<?= base_url('/update_submission') ?>">
                <input type="hidden" name="id" id="editId">
                <div class="form-group">
                    <label for="editYear">Year</label>
                    <input type="text" id="editYear" name="year" class="form-control">
                </div>
                <div class="form-group">
                    <label for="editSemester">Semester</label>
                    <input type="text" id="editSemester" name="semester" class="form-control">
                </div>
                <!-- Add other fields as necessary -->
                <div class="form-group">
                    <label for="editTotalQty">Total Quantity</label>
                    <input type="text" id="editTotalQty" name="total_qty" class="form-control">
                </div>
                <div class="form-group">
                    <label for="editTotalPrice">Total Price</label>
                    <input type="text" id="editTotalPrice" name="total_price" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>

    <div id="rejectModal" class="rejectModal">
        <div class="rejectModal-content">
            <span class="close">&times;</span>
            <h2>Reject Submission</h2>
            <form id="rejectForm" data-status=0 onsubmit="UpdateSubmission(this.id)">
                <input type="hidden" id="rejectId">
                <div class="rejectForm-group">
                    <label for="rejectReason">Reason for Rejection</label>
                    <br>
                    <textarea id="rejectReason" name="reason" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-reject">Tolak</button>
            </form>
        </div>
    </div>

    <div id="reviseModal" class="reviseModal">
        <div class="reviseModal-content">
            <span class="close">&times;</span>
            <h2>Revise Submission</h2>
            <form id="reviseForm" data-status=2 onsubmit="UpdateSubmission(this.id)">
                <input type="hidden" id="reviseId">
                <div class="reviseForm-group">
                    <label for="reviseReason">Reason for Revision</label>
                    <br>
                    <textarea id="reviseReason" name="reason" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-revise">Tolak</button>
            </form>
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

        var rejectModal = document.getElementById("rejectModal");
        var reviseModal = document.getElementById("reviseModal");
        var closeRejectModalButton = rejectModal.querySelector(".close");
        var closeReviseModalButton = reviseModal.querySelector(".close");

        // When the user clicks on <span> (x), close the modal
        closeRejectModalButton.onclick = function() {
            rejectModal.style.display = "none";
        }
        closeReviseModalButton.onclick = function() {
            reviseModal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == rejectModal) {
                rejectModal.style.display = "none";
            } else if (event.target == reviseModal) {
                reviseModal.style.display = "none";
            }
        }

        function showRejectModal() {
            rejectModal.style.display = "block";
        }

        function showReviseModal() {
            reviseModal.style.display = "block";
        }

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
        // Edit button functionality
        function showButtons() {
            // Show hidden button in the second container
            const buttons = document.querySelectorAll('.container2 button');
            buttons.forEach(button => {
                button.hidden = false;
            });
            const buttons2 = document.querySelectorAll('.container1 button');
            buttons2.forEach(button => {
                button.hidden = false;
            });

            // Show hidden inputs in the first container
            const inputs = document.querySelectorAll('.container1 input');
            inputs.forEach(input => {
                input.hidden = false;
            });

            // Hide visible spans in the first container
            const spans = document.querySelectorAll('.container1 span');
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
        document.getElementById('submitButton').addEventListener('click', submitEditedData);
    </script>
    <?= $this->endSection() ?>