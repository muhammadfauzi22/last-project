<?= $this->extend('layout\coreframe') ?>

<?= $this->section('title') ?>
Pengajuan Faktur
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .card {
        width: 90%;
        margin: 0 auto;
        border-radius: 8px;
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
        word-wrap: break-word;
        /* Allows content to wrap within cells */
        border: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }
</style>

<div class="card">
    <div class="card-header has-background-info">
        <h3 class="card-header-title has-text">Daftar Pengajuan</h3>
    </div>
    <div class="card-content">
        <div class="table-container">
            <table class="table is-striped is-narrworth is-hoverable">
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
                                <td><?= $row['year']; ?></td>
                                <td><?= $row['semester']; ?></td>
                                <td><?= $row['status']; ?></td>
                                <td><?= $row['username_request']; ?></td>
                                <td><?= $row['approval_one_username']; ?></td>
                                <td><?= $row['approval_two_username']; ?></td>
                                <td><?= $row['authenticator_username']; ?></td>
                                <td><?= $row['reason_rejected']; ?></td>
                                <td><?= $row['reason_need_revision']; ?></td>
                                <td><?= $row['total_item']; ?></td>
                                <td><?= $row['total_qty']; ?></td>
                                <td><?= $row['total_price']; ?></td>
                                <td>
                                    <?php if (!empty($row['invoice_dir'])) { ?>
                                        <a href="<?= base_url('files/serve/' . basename($row['invoice_dir'])); ?>" target="_blank" title="View File">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                    <?php } else {
                                        echo "No file available";
                                    } ?>
                                </td>
                                <td><?= $row['created_at']; ?></td>
                                <td><?= $row['updated_at']; ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="submission_detail/?id=<?= $row['id']; ?>" class="button is-info">Detail</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="16" class="text-center">Tidak ada pengajuan ditemukan</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?= $this->endSection() ?>