<?= $this->extend('layout\coreframe') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .card {
        width: 75%;
        /* Adjusted the width for a better fit */
        margin: 0 auto;
        border-radius: 8px;
        overflow: hidden;
    }

    .card .card-content {
        padding: 20px;
    }

    table {
        width: 100%;
        table-layout: fixed;
        /* Ensures the table fits within the card */
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        word-wrap: break-word;
        /* Allows content to wrap within cells */
    }
</style>

<div class="card">
    <div class="card-header has-background-info">
        <h3 class="card-header-title has-text">Manajemen Pengguna</h3>
    </div>
    <div class="card-content">
        <form id="userForm" method="post" action="<?= base_url('user/add') ?>">

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Nama</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" id="name" name="name" placeholder="Nama" required>
                            <span class="icon is-small is-left">
                                <i class="fas fa-font"></i>
                            </span>
                        </p>
                    </div>
                    <div class="field">
                        <p class="control is-expanded has-icons-left has-icons-right">
                            <input class="input" type="email" id="email" name="email" placeholder="Email" required>
                            <span class="icon is-small is-left">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <span class="icon is-small is-right">
                                <i class="fas fa-check"></i>
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Role</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <div class="select is-rounded">
                                <select id="role" name="role" required>
                                    <option value="">Select a role</option>
                                    <option value="pegawai">Pegawai</option>
                                    <option value="hrd">HRD</option>
                                    <option value="atasan">Atasan</option>
                                    <option value="pengesah">Pengesah</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Password</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="password" id="password" name="password" placeholder="Password" required>
                            <span class="icon is-small is-left">
                                <i class="fas fa-lock"></i>
                            </span>
                        </p>
                    </div>
                    <div class="field">
                        <p class="control is-expanded has-icons-left has-icons-right">
                            <input class="input" type="password" id="password_confirm" name="password_confirm" placeholder="Konfirmasi password">
                            <span class="icon is-small is-left">
                                <i class="fas fa-unlock"></i>
                            </span>
                            <span class="icon is-small is-right">
                                <i class="fas fa-check"></i>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <button type="submit" class="button is-info">Add User</button>
        </form>
    </div>
</div>


<div class="card">
    <div class="card-header has-background-info">
        <h3 class="card-header-title has-text">Pengguna Eksisting</h3>
    </div>
    <div class="card-content">
        <table class="table is-striped is-narrow is-hoverable">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($users) && !empty($users)) : ?>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $user['username']; ?></td>
                            <td><?= $user['email']; ?></td>
                            <td><?= ucfirst($user['group']); ?></td>
                            <td>
                                <?php /* <a href="<?= base_url('user/edit/' . $user['id']); ?>" class="btn btn-sm btn-warning">Edit</a> */ ?>
                                <a data-userid="<?= $user['id']; ?>" class="button is-danger has-text-light delete-user">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center">No users found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#userForm').on('submit', function(event) {
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
            event.preventDefault();
            $.ajax({
                url: '/api/register',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    username: $('#name').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    password_confirm: $('#password_confirm').val(),
                    role: $('#role').val(),
                }),
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
        });
    });

    $(document).ready(function() {
        $('.delete-user').click(function(e) {
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
            e.preventDefault();
            var userId = $(this).data('userid');
            $.ajax({
                url: '/api/deleteuser',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    id: userId
                }),
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
        });
    });
</script>
<?= $this->endSection() ?>