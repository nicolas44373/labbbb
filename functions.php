<?php
function registerUser($username, $email, $password) {
    global $conn;
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $username, $email, $passwordHash);
    return $stmt->execute();
}

function loginUser($email, $password) {
    global $conn;
    $stmt = $conn->prepare('SELECT id, password FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $passwordHash);
        $stmt->fetch();
        if (password_verify($password, $passwordHash)) {
            $_SESSION['user_id'] = $id;
            return true;
        }
    }
    return false;
}

function createPost($title, $body, $user_id) {
    global $conn;
    $stmt = $conn->prepare('INSERT INTO posts (title, body, user_id) VALUES (?, ?, ?)');
    $stmt->bind_param('ssi', $title, $body, $user_id);
    return $stmt->execute();
}

function getPosts() {
    global $conn;
    return $conn->query('SELECT * FROM posts ORDER BY created_at DESC');
}

function getPost($post_id) {
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM posts WHERE id = ?');
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getComments($post_id) {
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC');
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    return $stmt->get_result();
}

function addComment($post_id, $user_id, $comment) {
    global $conn;
    $stmt = $conn->prepare('INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)');
    $stmt->bind_param('iis', $post_id, $user_id, $comment);
    return $stmt->execute();
}

function getCategories() {
    global $conn;
    return $conn->query('SELECT * FROM categories');
}

function createCategory($name) {
    global $conn;
    $stmt = $conn->prepare('INSERT INTO categories (name) VALUES (?)');
    $stmt->bind_param('s', $name);
    return $stmt->execute();
}

function assignCategoriesToPost($post_id, $categories) {
    global $conn;
    $stmt = $conn->prepare('DELETE FROM post_categories WHERE post_id = ?');
    $stmt->bind_param('i', $post_id);
    $stmt->execute();

    $stmt = $conn->prepare('INSERT INTO post_categories (post_id, category_id) VALUES (?, ?)');
    foreach ($categories as $category_id) {
        $stmt->bind_param('ii', $post_id, $category_id);
        $stmt->execute();
    }
}
?>
