<?php

function getPostsNews($db, $limit, $offset, $menuUrl) {
    if ($menuUrl != '') {
        $stmt = $db->prepare('SELECT posts.* FROM posts JOIN menu ON posts.menu_id = menu.id WHERE menu.page_url = :menu_url AND posts.status = "published" LIMIT '.(int)$limit.' OFFSET '.(int)$offset);
        $stmt->bindValue(':menu_url', $menuUrl, PDO::PARAM_STR);
    } else {
        $stmt = $db->prepare('SELECT posts.* FROM posts JOIN menu ON posts.menu_id = menu.id WHERE menu.page_url = "index" AND posts.status = "published" LIMIT '.(int)$limit.' OFFSET '.(int)$offset);
    }
    $stmt->execute();
    return $stmt->fetchAll();    
}
function getPostSeo($db, $limit, $offset, $menuUrl) {
    if ($menuUrl != '') {
        $stmt = $db->prepare('SELECT posts.* FROM posts JOIN menu ON posts.menu_id = menu.id WHERE menu.page_url = :menu_url AND posts.status = "published" AND posts.priority = 1 ORDER BY GREATEST(posts.created_at, posts.updated_at) DESC, posts.id DESC LIMIT '.(int)$limit.' OFFSET '.(int)$offset);
        $stmt->bindValue(':menu_url', $menuUrl, PDO::PARAM_STR);
    } else {
        $stmt = $db->prepare('SELECT posts.* FROM posts JOIN menu ON posts.menu_id = menu.id WHERE menu.page_url = "index" AND posts.status = "published" AND posts.priority = 1 ORDER BY GREATEST(posts.created_at, posts.updated_at) DESC, posts.id DESC LIMIT '.(int)$limit.' OFFSET '.(int)$offset);
    }
    $stmt->execute();
    return $stmt->fetchAll();
}

function countPosts($db) {
    $stmt = $db->prepare('SELECT COUNT(*) FROM posts WHERE status = "published"');
    $stmt->execute();
    return $stmt->fetchColumn(); 
}

function deletePost($db, $id) {
    $stmt = $db->prepare('DELETE FROM posts WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

function createPost($db, $title, $content, $menu_id, $status, $author, $tags, $role, $description, $keywords, $priority) {
    if($priority == 1) {
        $stmtPriority = $db->prepare('UPDATE posts SET priority = 0 WHERE menu_id = :menu_id');
        $stmtPriority->bindValue(':menu_id', $menu_id, PDO::PARAM_INT);
        $stmtPriority->execute();
    }
    $current_date = date('Y-m-d H:i:s'); 

    $stmt = $db->prepare('INSERT INTO posts (title, content, menu_id, status, author_id, tags, role, created_at, updated_at, description, keywords, priority) VALUES (:title, :content, :menu_id, :status, :author_id, :tags, :role, :created_at, :updated_at, :description, :keywords, :priority)');
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':author_id', $author, PDO::PARAM_STR);
    $stmt->bindParam(':tags', $tags, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':keywords', $keywords, PDO::PARAM_STR);
    $stmt->bindParam(':created_at', $current_date, PDO::PARAM_STR);
    $stmt->bindParam(':updated_at', $current_date, PDO::PARAM_STR);
    $stmt->bindValue(':priority', $priority, PDO::PARAM_INT);
    return $stmt->execute();
}

function updatePost($db, $postId, $title, $content, $menu_id, $status, $tags, $role, $description, $keywords, $priority) {
    if($priority == 1) {
        $stmtPriority = $db->prepare('UPDATE posts SET priority = 0 WHERE menu_id = :menu_id AND id != :post_id');
        $stmtPriority->bindValue(':menu_id', $menu_id, PDO::PARAM_INT);
        $stmtPriority->bindValue(':post_id', $postId, PDO::PARAM_INT);
        $stmtPriority->execute();
    }
    $current_date = date('Y-m-d H:i:s'); 

    $stmt = $db->prepare('UPDATE posts SET title = :title, content = :content, menu_id = :menu_id, status = :status, tags = :tags, role = :role, updated_at = :updated_at, description = :description, keywords = :keywords, priority = :priority WHERE id = :post_id');
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':tags', $tags, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':keywords', $keywords, PDO::PARAM_STR);
    $stmt->bindParam(':updated_at', $current_date, PDO::PARAM_STR);
    $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
    $stmt->bindValue(':priority', $priority, PDO::PARAM_INT);
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

function getAllPostsPagination($db, $start, $limit, $search_term = '') {
    if ($search_term === '') {
        $stmt = $db->prepare("SELECT posts.*, menu.name AS menu_name FROM posts LEFT JOIN menu ON posts.menu_id = menu.id ORDER BY created_at DESC LIMIT :start, :limit");
    } else {
        $stmt = $db->prepare("SELECT posts.*, menu.name AS menu_name FROM posts LEFT JOIN menu ON posts.menu_id = menu.id WHERE posts.title LIKE :search_term OR posts.content LIKE :search_term OR menu.name LIKE :search_term ORDER BY created_at DESC LIMIT :start, :limit");
        $stmt->bindValue(':search_term', '%' . $search_term . '%', PDO::PARAM_STR);
    }

    $stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
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

function deleteTagFromAllPosts($db, $tagToRemove) {
    $sql = "SELECT id, tags FROM posts";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tagArray = explode(',', $row['tags'] ?? '');
        $tagArray = array_map('trim', $tagArray);
        $tagKey = array_search($tagToRemove, $tagArray);
        if ($tagKey !== false) {
            unset($tagArray[$tagKey]);
            $newTags = implode(',', $tagArray);
            $updateSql = "UPDATE posts SET tags = :tags WHERE id = :id";
            $updateStmt = $db->prepare($updateSql);
            $updateStmt->execute(['tags' => $newTags, 'id' => $row['id']]);
        }
    }
}
