<?php
// Database connection
$host = 'localhost';
$db = 'delphian_logic';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Include CRUD operations
include 'crud.php';

// Fetch sections
$sections = getSections($pdo);

// Set default values
$defaultImage = 'images/image-placeholder.jpg';

// Fallback for the first section
$firstSection = !empty($sections) ? $sections[0] : [
    'title' => 'DelphianLogic in Action',
    'description' => [], // Assuming description is an array now
    'image' => $defaultImage
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($firstSection['title']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<style>
    #descriptionCar{
    background-color: #2ca3d9 !important;
}
</style>
<div class="container-fluid">
    <a href="create.php" class="btn btn-primary mb-4">Add New Section</a>
    <div class="row">
    
        <div class="col-md-3 col-sm-12" id="tabs-column">
            <ul class="nav flex-column nav-pills" id="sectionTabs" role="tablist">
                <?php foreach ($sections as $index => $section): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>" 
                           id="<?php echo strtolower(str_replace(' ', '-', $section['title'])) . '-tab'; ?>" 
                           data-toggle="pill" 
                           href="#<?php echo strtolower(str_replace(' ', '-', $section['title'])); ?>" 
                           role="tab" 
                           aria-controls="<?php echo strtolower(str_replace(' ', '-', $section['title'])); ?>" 
                           aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                           data-image="<?php echo htmlspecialchars($section['image']); ?>">
                            <?php echo htmlspecialchars($section['title']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="col-md-6 col-sm-12" id="descriptionCar">
            <div class="tab-content" id="sectionContent">
                <?php if (!empty($sections)): ?>
                    <?php foreach ($sections as $index => $section): ?>
                        <div class="tab-pane fade <?php echo $index === 0 ? 'show active' : ''; ?>" 
                             id="<?php echo strtolower(str_replace(' ', '-', $section['title'])); ?>" 
                             role="tabpanel" 
                             aria-labelledby="<?php echo strtolower(str_replace(' ', '-', $section['title'])) . '-tab'; ?>">
                            <div id="descriptionCarousel<?php echo $index; ?>" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <?php 
                                    $descriptions = json_decode($section['description'], true);
                                    if (!empty($descriptions)):
                                        foreach ($descriptions as $descIndex => $description): ?>
                                            <div class="carousel-item <?php echo $descIndex === 0 ? 'active' : ''; ?>">
                                                <h2><?php echo htmlspecialchars($section['title']); ?></h2>
                                                <p><?php echo htmlspecialchars($description); ?></p>
                                            </div>
                                        <?php endforeach; 
                                    else: ?>
                                        <div class="carousel-item active">
                                            <h2><?php echo htmlspecialchars($section['title']); ?></h2>
                                            <p>No description available.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <a class="carousel-control-prev" href="#descriptionCarousel<?php echo $index; ?>" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#descriptionCarousel<?php echo $index; ?>" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No sections found.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-12" id="image-column">
            <img id="dynamic-image" src="<?php echo htmlspecialchars($firstSection['image']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($firstSection['title']); ?> Image">
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="js/script.js"></script>

<script>
$(document).ready(function() {
    $('#sectionTabs a').on('shown.bs.tab', function (e) {
        var newImage = $(e.target).data('image');
        $('#dynamic-image').attr('src', newImage);
    });
});
</script>

</body>
</html>
