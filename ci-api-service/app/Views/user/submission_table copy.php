<?= $this->extend('layout\page_layout') ?>

<?= $this->section('title') ?>
Pengajuan Faktur
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .container {
        width: 90%;
        margin: 50px auto;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .header {
        background-color: #4CAF50;
        color: white;
        padding: 15px;
        text-align: center;
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

    .action-buttons {
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-view {
        background-color: #2196F3;
        color: white;
    }

    .btn-process {
        background-color: #FF9800;
        color: white;
    }

    .btn-view:hover {
        background-color: #1976D2;
    }

    .btn-process:hover {
        background-color: #F57C00;
    }
</style>

<div class="header">
    <h1>List Pengajuan</h1>
</div>
<table>
    <thead>
        <tr>
            <th>Tahun</th>
            <th>Semester</th>
            <th>Status</th>
            <th>Pengaju</th>
            <th>Atasan Menyetujui</th>
            <th>HRD Menyetujui</th>
            <th>Pengesah Menyetujui</th>
            <th>Alasan Tolak</th>
            <th>Alasan Revisi</th>
            <th>Jumlah Barang</th>
            <th>Jumlah Kuantitas Barang</th>
            <th>Jumlah Harga</th>
            <th>File Invoice</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($Submission !== null) { ?>
            <?php foreach ($Submission as $row) { ?>
                <tr>
                    <td><?= $Submission != null ? $row['year'] : ''; ?></td>
                    <td><?= $Submission != null ? $row['semester'] : ''; ?></td>
                    <td><?= $Submission != null ? $row['status'] : ''; ?></td>
                    <td><?= $Submission != null ? $row['username_request'] : ''; ?></td>
                    <td><?= $Submission != null ? $row['approval_one_username'] : ''; ?></td>
                    <td><?= $Submission != null ? $row['approval_two_username'] : ''; ?></td>
                    <td><?= $Submission != null ? $row['authenticator_username'] : ''; ?></td>
                    <?php /* ?>
                    <td>NOT YET</td>
                    <td>NOT YET</td>
                    <td>NOT YET</td><?php */ ?>
                    <td><?= $Submission != null ? $row['reason_rejected'] : ''; ?></td>
                    <td><?= $Submission != null ? $row['reason_need_revision'] : ''; ?></td>
                    <td><?= $Submission != null ? $row['total_item'] : ''; ?></td>
                    <td><?= $Submission != null ? $row['total_qty'] : ''; ?></td>
                    <td><?= $Submission != null ? $row['total_price'] : ''; ?></td>
                    <td><?php if ($Submission != null && !empty($row['invoice_dir'])) { ?>
                            <a href="<?= base_url('files/serve/' . basename($row['invoice_dir'])); ?>" target="_blank" title="View File">
                                <i class="fas fa-file-alt"></i>
                            </a> <?php } else {
                                    echo "No file available";
                                } ?>
                    </td>
                    <td><?= $Submission != null ? $row['created_at'] : ''; ?></td>
                    <td><?= $Submission != null ? $row['updated_at'] : ''; ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="submission_detail/?id=<?= $row['id']; ?>" class="btn btn-view">Detail</a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        <!-- Add more rows as needed -->
    </tbody>
</table>
<?= $this->endSection() ?>