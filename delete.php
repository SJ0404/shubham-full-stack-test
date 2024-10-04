<?php
include 'crud.php';

if (isset($_GET['id'])) {
    deleteSection($pdo, $_GET['id']);
    header('Location: index.php');
    exit;
}