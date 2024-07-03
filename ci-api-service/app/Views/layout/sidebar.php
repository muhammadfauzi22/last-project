<?php /*
<div class="logo">
        <img src="<?= base_url('logo.png') ?>" alt="Sample Logo" class="sidebar-logo">
    </div>
*/ ?>
<style>
    .sidebar {
        width: 250px;
        background-color: #2C3E50;
        color: white;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .sidebar-menu {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-menu li {
        padding: 15px 20px;
        cursor: pointer;
    }

    .sidebar-menu li:hover {
        background-color: #34495E;
    }

    .sidebar-menu li a {
        color: white;
        text-decoration: none;
        display: block;
    }

    .sidebar-menu li a:hover {
        text-decoration: underline;
    }

    .sidebar-footer {
        padding: 15px 20px;
        border-top: 1px solid #34495E;
    }

    .logo {
        text-align: center;
        /* Center the image horizontally */
        margin-bottom: 20px;
        /* Add some spacing below the image */
    }

    .sidebar-logo {
        max-width: 50%;
        /* Make sure the image doesn't exceed the sidebar width */
        height: auto;
        /* Maintain aspect ratio */
    }
</style>

<div class="sidebar">
    <ul class="sidebar-menu">
        <li>
            <select id="roleSelector" class="role-selector">
                <?php foreach (session()->get('group') as $group) : ?>
                    <option value="<?= $group ?>" <?= session()->get('group') == $group ? 'selected' : '' ?>>
                        <?= ucfirst($group) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </li>
        <?php if (in_array("pegawai.dashboard", session()->get('permissions'))) { ?>
            <li><a href="/dashboard">Dashboard</a></li><?php } ?>
        <?php if (in_array("pegawai.submission", session()->get('permissions'))) { ?>
            <li><a href="/submission_form">Pengajuan Faktur</a></li><?php } ?>
        <?php if (in_array("hrd.monitor", session()->get('permissions'))) { ?>
            <li><a href="/submission_table">Monitoring Faktur</a></li><?php } ?>
        <?php if (in_array("hrd.manage-users", session()->get('permissions'))) { ?>
            <li><a href="/user_management">Manajemen User</a></li><?php } ?>
        <li><a href="#" id="logout-menu">Logout</a></li>
    </ul>
    <!--<div class="sidebar-footer">
        <a href="/logout">Logout</a>
    </div>
-->
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        console.log('Jquery loaded');
        $('#logout-menu').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Logout Sedang Diproses.',
                html: 'Mohon Tunggu. Jangan keluar dari halaman.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            })
            $.ajax({
                url: '/api/logout',
                type: 'GET',
                contentType: 'application/json',
                data: JSON.stringify({
                    token: '<?php echo session()->get('token'); ?>'
                }),
                success: function(response) {
                    Swal.fire(
                        'Logout Berhasil!',
                        '',
                        'success'
                    ).then(() => {
                        window.location.href = '/';
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Logout Gagal!',
                        xhr.responseText,
                        'error'
                    );
                }
            });
        });
    });
</script>