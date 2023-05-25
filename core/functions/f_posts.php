<?php

function getPostsNews($db, $limit, $offset, $menuUrl) {
    if ($menuUrl != '') {
        $stmt = $db->prepare('SELECT posts.* FROM posts JOIN menu ON posts.menu_id = menu.id WHERE menu.page_url = :menu_url LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':menu_url', $menuUrl, PDO::PARAM_STR);
    } else {
        $stmt = $db->prepare('SELECT posts.* FROM posts JOIN menu ON posts.menu_id = menu.id WHERE menu.page_url = "index" LIMIT :limit OFFSET :offset');
    }

    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}
 
    function countPosts($db) {
        $stmt = $db->prepare('SELECT COUNT(*) FROM posts');
        $stmt->execute();
        return $stmt->fetchColumn();
    }
function deletePost($db, $id) {
    $stmt = $db->prepare('DELETE FROM posts WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

function getPosts($db) {
    $stmt = $db->prepare('SELECT * FROM posts');
    $stmt->execute();
    return $stmt->fetchAll();
}

function createPost($db, $title, $content, $menu_id, $status, $author, $tags, $role) {
    $current_date = date('Y-m-d H:i:s'); // Sukuria dabartinę datą ir laiką

    $stmt = $db->prepare('INSERT INTO posts (title, content, menu_id, status, author_id, tags, role, created_at, updated_at) VALUES (:title, :content, :menu_id, :status, :author_id, :tags, :role, :created_at, :updated_at)');
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':author_id', $author, PDO::PARAM_STR);
    $stmt->bindParam(':tags', $tags, PDO::PARAM_STR);
    $stmt->bindParam(':created_at', $current_date, PDO::PARAM_STR);
    $stmt->bindParam(':updated_at', $current_date, PDO::PARAM_STR);
    return $stmt->execute();
}

function updatePost($db, $postId, $title, $content, $menu_id, $status, $tags, $role) {
    $current_date = date('Y-m-d H:i:s'); // Sukuria dabartinę datą ir laiką

    $stmt = $db->prepare('UPDATE posts SET title = :title, content = :content, menu_id = :menu_id, status = :status, tags = :tags, role = :role, updated_at = :updated_at WHERE id = :post_id');
    
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':tags', $tags, PDO::PARAM_STR);
    $stmt->bindParam(':updated_at', $current_date, PDO::PARAM_STR);
    $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
    return $stmt->execute();
}


function getPostById($db, $postId) {
    $query = "SELECT * FROM posts WHERE id = :postId";
    $statement = $db->prepare($query);
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getAllPosts($db) {
    $stmt = $db->prepare("SELECT * FROM posts");
    $stmt->execute();

    return $stmt->fetchAll();
}

function countAllPosts($db) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM posts");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getAllPostsPagination($db, $start, $limit) {
    $stmt = $db->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT :start, :limit");
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getExistingTags($db) {
    $sql = "SELECT tags FROM posts";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $tags = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tagArray = explode(',', $row['tags'] ?? '');

        foreach ($tagArray as $tag) {
            $tag = trim($tag);
            if (!in_array($tag, $tags) && !empty($tag)) {
                $tags[] = $tag;
            }
        }
    }
    return $tags;
}
