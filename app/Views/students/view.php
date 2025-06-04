<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Student Profile</h2>
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <td><?= esc($student['name']) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= esc($student['email']) ?></td>
        </tr>
        <tr>
            <th>Course</th>
            <td><?= esc($student['course']) ?></td>
        </tr>
    </table>
    <a href="/students" class="btn btn-primary">Back to List</a>
</div>

<?= $this->endSection() ?>