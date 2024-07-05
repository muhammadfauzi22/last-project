<?= $this->extend('layout\coreframe') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .container {
        width: 80%;
        margin: 50px auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        padding: 20px;
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

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
    }

    .card {
        width: 50%;
        margin: 0 auto;
        border-radius: 8px;
        overflow: hidden;
    }
</style>

<div class="card">
    <header class="card-header has-background-info">
        <h1 class="card-header-title has-text">Pengajuan Faktur Terakhir</h1>
    </header>
    <div class="card-content">
        <div class="detail">
            <div class="detail-row">
                <div class="detail-title">Tahun:</div>
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
                <div class="detail-title">Nama Faktur:</div>
                <div class="detail-content"><?= $lastSessSubmission != null ? $lastSessSubmission[0]['name'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Jumlah Barang:</div>
                <div class="detail-content"><?= $lastSessSubmission != null ? $lastSessSubmission[0]['total_qty'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Total Harga:</div>
                <div class="detail-content"><?= $lastSessSubmission != null ? $lastSessSubmission[0]['total_price'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Dibuat Pada:</div>
                <div class="detail-content"><?= $lastSessSubmission != null ? $lastSessSubmission[0]['created_at'] : ''; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-title">Diperbaharui Pada:</div>
                <div class="detail-content"><?= $lastSessSubmission != null ? $lastSessSubmission[0]['updated_at'] : ''; ?></div>
            </div>
        </div>
    </div>
</div>
</table>
</div>

<div class="card" style="width:75%;">
    <header class="card-header has-background-info">
        <h1 class="card-header-title has-text">Riwayat Pengajuan</h1>
    </header>
    <div class="card-content">
        <div class="table-container">
            <table class="table is-striped is-narrow is-hoverable">
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Nama</th>
                        <th>Jumlah Barang</th>
                        <th>Total Kuantitas</th>
                        <th>Total Harga</th>
                        <th>Dibuat Pada</th>
                        <th>Diperbarui Pada</th>
                        <th>File Faktur</th>
                        <th>Aksi</th>
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
                                            Tidak tersedia file
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="submission_detail/?id=<?= $data['id']; ?>" data-id="<?= $data['id']; ?>" class="button is-info">Detil</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php } ?>
                    <!-- Add more rows as needed -->
                </tbody>
                <!-- Your table content -->
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>