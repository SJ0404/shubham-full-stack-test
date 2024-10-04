<?php
include 'crud.php';
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? trim($_POST['title']) : null;
    $descriptions = isset($_POST['description']) ? $_POST['description'] : [];
    $image = $_FILES['image'];

    if ($title && !empty($descriptions) && $image['error'] === UPLOAD_ERR_OK) {
        $targetDir = "images/";
        $targetFile = $targetDir . basename($image['name']);
        
        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            // Encode descriptions as JSON
            $descriptionJson = json_encode($descriptions);
            $result = createSection($pdo, $title, $descriptionJson, $targetFile);

            if ($result) {
                header('Location: index.php');
                exit;
            } else {
                echo "Failed to create section.";
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "All fields are required and image upload must be successful.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Section</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>

<div class="container">
    <h1>Add New Section</h1>
    <form action="create.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <div id="description-container">
                <input type="text" class="form-control mb-2" name="description[]" required placeholder="Description">
            </div>
            <button type="button" id="add-description" class="btn btn-secondary">Add More Descriptions</button>
        </div>
        <div class="form-group">
            <label for="image">Image File</label>
            <input type="file" class="form-control" name="image" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Section</button>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#add-description').click(function() {
        $('#description-container').append('<input type="text" class="form-control mb-2" name="description[]" placeholder="Description">');
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
