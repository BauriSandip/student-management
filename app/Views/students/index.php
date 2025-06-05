<!DOCTYPE html>
<html>

<head>
    <title>Student Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

    <h2 class="mb-4">Student List</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form method="get" action="/students" class="d-flex mb-3">
        <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="<?= esc($search) ?>">
        <button class="btn btn-primary me-2">Search</button>
        <a href="/students" class="btn btn-secondary">Reset</a>
    </form>
    <a href="/students/create" class="btn btn-success mb-3">Add New</a>
    <a href="/students/export" class="btn btn-success mb-3">Export to CSV</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Gender</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= $student['id'] ?></td>
                    <td><?= $student['name'] ?></td>
                    <td><?= $student['email'] ?></td>
                    <td><?= $student['course'] ?></td>
                    <td><?= $student['gender'] ?></td>
                    <td>
                        <a href="/students/edit/<?= $student['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="/students/delete/<?= $student['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this student?')">Delete</a>
                        <?php if (!empty($students['photo'])): ?>
                            <img src="<?= base_url('uploads/' . $student['photo']) ?>" width="60">
                        <?php else: ?>
                            <span>No Photo</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>


    </table>
    <!-- Pagination links -->
    <div class="mt-3">
        <?= $pager->links() ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>