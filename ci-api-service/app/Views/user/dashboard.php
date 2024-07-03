<?= $this->extend('layout\page_layout') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .container {
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

    .action-buttons {
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-back {
        background-color: #2196F3;
        color: white;
    }

    .btn-edit {
        background-color: #FF9800;
        color: white;
    }

    .btn-back:hover {
        background-color: #1976D2;
    }

    .btn-edit:hover {
        background-color: #F57C00;
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
    <h1>Pengajuan Faktur Terakhir</h1>
</div>
<div class="detail">
    <div class="detail-row">
        <div class="detail-title">Year:</div>
        <div class="detail-content"><?= $lastSessSubmission != null ? $lastSessSubmission[0]['year'] : ''; ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-title">Semester:</div>
        <div class="detail-content"><?= $lastSessSubmission != null ? $lastSessSubmission[0]['semester'] : ''; ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-title">Status:</div>
        <div class="detail-content"><?= $lastSessSubmission != null ? $lastSessSubmission[0]['status'] : ''; ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-title">Name:</div>
        <div class="detail-content"><?= $lastSessSubmission != null ? $lastSessSubmission[0]['name'] : ''; ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-title">Total Quantity:</div>
        <div class="detail-content"><?= $lastSessSubmission != null ? $lastSessSubmission[0]['total_qty'] : ''; ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-title">Total Price:</div>
        <div class="detail-content"><?= $lastSessSubmission != null ? $lastSessSubmission[0]['total_price'] : ''; ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-title">Created At:</div>
        <div class="detail-content"><?= $lastSessSubmission != null ? $lastSessSubmission[0]['created_at'] : ''; ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-title">Updated At:</div>
        <div class="detail-content"><?= $lastSessSubmission != null ? $lastSessSubmission[0]['updated_at'] : ''; ?></div>
    </div>
    <div class="actions">
        <?php /* <a href="#back" class="btn btn-back">Back</a>
        */ ?>
    </div>
</div>
<div class="header">
    <h1>Riwayat Pengajuan</h1>
</div>
<table>
    <thead>
        <tr>
            <th>Year</th>
            <th>Semester</th>
            <th>Status</th>
            <th>Name</th>
            <th>Total Item</th>
            <th>Total Quantity</th>
            <th>Total Price</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Invoice File</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($sessSubmission != null) { ?>
            <?php foreach ($sessSubmission as $data) : ?>
                <tr>
                    <td><?= $data['year']; ?></td>
                    <td><?= $data['semester']; ?></td>
                    <td><?= $data['status']; ?></td>
                    <td><?= $data['name']; ?></td>
                    <td><?= $data['total_item']; ?></td>
                    <td><?= $data['total_qty']; ?></td>
                    <td><?= $data['total_price']; ?></td>
                    <td><?= $data['created_at']; ?></td>
                    <td><?= $data['updated_at']; ?></td>
                    <td>
                        <div class="detail-content"><?php if ($data != null && !empty($data['invoice_dir'])) : ?>
                                <a href="<?= base_url('files/serve/' . basename($data['invoice_dir'])); ?>" target="_blank" title="View File">
                                    <i class="fas fa-file-alt"></i>
                                </a>
                            <?php else : ?>
                                No file available
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="submission_detail/?id=<?= $data['id']; ?>" data-id="<?= $data['id']; ?>" class="btn btn-view">Detail</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php } ?>
        <!-- Add more rows as needed -->
    </tbody>
</table>

<?= $this->endSection() ?>