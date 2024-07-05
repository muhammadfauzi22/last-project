<?= $this->extend('layout\page_layout') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    .container {
        margin-top: 50px;
    }

    .card {
        border-radius: 15px;
    }

    .card-header {
        background-color: #007bff;
        color: white;
        border-radius: 15px 15px 0 0;
    }

    .btn-custom {
        background-color: #007bff;
        color: white;
    }

    .btn-custom:hover {
        background-color: #0056b3;
    }

    .table-container {
        margin-top: 30px;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Manajemen Pengguna</h4>
                </div>
                <div class="card-body">
                    <form id="userForm" method="post" action="<?= base_url('user/add') ?>">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password Confirm</label>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Enter password" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="">Select a role</option>
                                <option value="pegawai">Pegawai</option>
                                <option value="hrd">HRD</option>
                                <option value="atasan">Atasan</option>
                                <option value="pengesah">Pengesah</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-custom btn-block">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center table-container">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header text-center">
                <h4>Pengguna Eksisting</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
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
                                        <a data-userid="<?= $user['id']; ?>" class="btn btn-sm btn-danger delete-user">Delete</a>
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
    </div>
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