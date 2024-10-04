<?php

function getSections(PDO $pdo): array
{
    $stmt = $pdo->query('SELECT * FROM sections');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getSectionById(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM sections WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createSection(PDO $pdo, string $title, string $description, string $image): bool
{
    try {
        $stmt = $pdo->prepare('INSERT INTO sections (title, description, image) VALUES (?, ?, ?)');
        return $stmt->execute([$title, $description, $image]);
    } catch (Exception $e) {
        echo "Error while creating section: " . $e->getMessage();
        return false;
    }
}

function updateSection(PDO $pdo, int $id, string $title, string $description, string $image): bool
{
    try {
        $stmt = $pdo->prepare('UPDATE sections SET title = ?, description = ?, image = ? WHERE id = ?');
        return $stmt->execute([$title, $description, $image, $id]);
    } catch (Exception $e) {
        echo "Error while updating section: " . $e->getMessage();
        return false;
    }
}

function deleteSection(PDO $pdo, int $id): bool
{
    try {
        $stmt = $pdo->prepare('DELETE FROM sections WHERE id = ?');
        return $stmt->execute([$id]);
    } catch (Exception $e) {
        echo "Error while deleting section: " . $e->getMessage();
        return false;
    }
}