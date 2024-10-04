<?php
include 'crud.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$section = getSectionById($pdo, $_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    updateSection($pdo, $_GET['id'], $title, $description, $image);
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Section</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h1>Edit Section</h1>
        <form action="edit.php?id=<?php echo $section['id']; ?>" method="POST">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($section['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" required><?php echo htmlspecialchars($section['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image Path</label>
                <input type="text" class="form-control" name="image" value="<?php echo htmlspecialchars($section['image']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Section</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>