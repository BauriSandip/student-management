<!DOCTYPE html>
<html>

<head>
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

    <h2 class="mb-4">Edit Student</h2>

    <?php if (isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <form method="post" action="/students/update/<?= $student['id'] ?>" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" name="name" class="form-control" value="<?= old('name', $student['name']) ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" value="<?= old('email', $student['email']) ?>">
        </div>
        <div class="mb-3">
            <label for="course" class="form-label">Course:</label>
            <input type="text" name="course" class="form-control" value="<?= old('course', $student['course']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="/students" class="btn btn-secondary">Back</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>