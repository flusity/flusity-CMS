<?php

function getPostsNews($db, $prefix, $limit, $offset, $menuUrl) {
    if ($menuUrl != '') {
        $stmt = $db->prepare('SELECT '.$prefix['table_prefix'].'_flussi_posts.* FROM '.$prefix['table_prefix'].'_flussi_posts JOIN '.$prefix['table_prefix'].'_flussi_menu ON '.$prefix['table_prefix'].'_flussi_posts.menu_id = '.$prefix['table_prefix'].'_flussi_menu.id WHERE '.$prefix['table_prefix'].'_flussi_menu.page_url = :menu_url AND '.$prefix['table_prefix'].'_flussi_posts.status = "published" LIMIT '.(int)$limit.' OFFSET '.(int)$offset);
        $stmt->bindValue(':menu_url', $menuUrl, PDO::PARAM_STR);
    } else {
        $stmt = $db->prepare('SELECT '.$prefix['table_prefix'].'_flussi_posts.* FROM '.$prefix['table_prefix'].'_flussi_posts JOIN '.$prefix['table_prefix'].'_flussi_menu ON '.$prefix['table_prefix'].'_flussi_posts.menu_id = '.$prefix['table_prefix'].'_flussi_menu.id WHERE '.$prefix['table_prefix'].'_flussi_menu.page_url = "index" AND '.$prefix['table_prefix'].'_flussi_posts.status = "published" LIMIT '.(int)$limit.' OFFSET '.(int)$offset);
    }
    $stmt->execute();
    return $stmt->fetchAll();    
}
function getPostSeo($db, $prefix, $limit, $offset, $menuUrl) {
    if ($menuUrl != '') {
        $stmt = $db->prepare('SELECT '.$prefix['table_prefix'].'_flussi_posts.* FROM '.$prefix['table_prefix'].'_flussi_posts JOIN '.$prefix['table_prefix'].'_flussi_menu ON '.$prefix['table_prefix'].'_flussi_posts.menu_id = '.$prefix['table_prefix'].'_flussi_menu.id WHERE '.$prefix['table_prefix'].'_flussi_menu.page_url = :menu_url AND '.$prefix['table_prefix'].'_flussi_posts.status = "published" AND '.$prefix['table_prefix'].'_flussi_posts.priority = 1 ORDER BY GREATEST('.$prefix['table_prefix'].'_flussi_posts.created_at, '.$prefix['table_prefix'].'_flussi_posts.updated_at) DESC, '.$prefix['table_prefix'].'_flussi_posts.id DESC LIMIT '.(int)$limit.' OFFSET '.(int)$offset);
        $stmt->bindValue(':menu_url', $menuUrl, PDO::PARAM_STR);
    } else {
        $stmt = $db->prepare('SELECT '.$prefix['table_prefix'].'_flussi_posts.* FROM '.$prefix['table_prefix'].'_flussi_posts JOIN '.$prefix['table_prefix'].'_flussi_menu ON '.$prefix['table_prefix'].'_flussi_posts.menu_id = '.$prefix['table_prefix'].'_flussi_menu.id WHERE '.$prefix['table_prefix'].'_flussi_menu.page_url = "index" AND '.$prefix['table_prefix'].'_flussi_posts.status = "published" AND '.$prefix['table_prefix'].'_flussi_posts.priority = 1 ORDER BY GREATEST('.$prefix['table_prefix'].'_flussi_posts.created_at, '.$prefix['table_prefix'].'_flussi_posts.updated_at) DESC, '.$prefix['table_prefix'].'_flussi_posts.id DESC LIMIT '.(int)$limit.' OFFSET '.(int)$offset);
    }
    $stmt->execute();
    return $stmt->fetchAll();
}

function countPosts($db, $prefix) {
    $stmt = $db->prepare('SELECT COUNT(*) FROM '.$prefix['table_prefix'].'_flussi_posts WHERE status = "published"');
    $stmt->execute();
    return $stmt->fetchColumn(); 
}

function deletePost($db, $prefix, $id) {
    $stmt = $db->prepare('DELETE FROM '.$prefix['table_prefix'].'_flussi_posts WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

function createPost($db, $prefix, $title, $content, $menu_id, $status, $author, $tags, $role, $description, $keywords, $priority) {
    if($priority == 1) {
        $stmtPriority = $db->prepare('UPDATE '.$prefix['table_prefix'].'_flussi_posts SET priority = 0 WHERE menu_id = :menu_id');
        $stmtPriority->bindValue(':menu_id', $menu_id, PDO::PARAM_INT);
        $stmtPriority->execute();
    }
    $current_date = date('Y-m-d H:i:s'); 

    $stmt = $db->prepare('INSERT INTO '.$prefix['table_prefix'].'_flussi_posts (title, content, menu_id, status, author_id, tags, role, created_at, updated_at, description, keywords, priority) VALUES (:title, :content, :menu_id, :status, :author_id, :tags, :role, :created_at, :updated_at, :description, :keywords, :priority)');
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

function updatePost($db, $prefix, $postId, $title, $content, $menu_id, $status, $tags, $role, $description, $keywords, $priority) {
    if($priority == 1) {
        $stmtPriority = $db->prepare('UPDATE '.$prefix['table_prefix'].'_flussi_posts SET priority = 0 WHERE menu_id = :menu_id AND id != :post_id');
        $stmtPriority->bindValue(':menu_id', $menu_id, PDO::PARAM_INT);
        $stmtPriority->bindValue(':post_id', $postId, PDO::PARAM_INT);
        $stmtPriority->execute();
    }
    $current_date = date('Y-m-d H:i:s'); 

    $stmt = $db->prepare('UPDATE '.$prefix['table_prefix'].'_flussi_posts SET title = :title, content = :content, menu_id = :menu_id, status = :status, tags = :tags, role = :role, updated_at = :updated_at, description = :description, keywords = :keywords, priority = :priority WHERE id = :post_id');
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


function getPostById($db, $prefix, $postId) {
    $query = "SELECT * FROM ".$prefix['table_prefix']."_flussi_posts WHERE id = :postId";
    $statement = $db->prepare($query);
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getAllPosts($db, $prefix) {
    $stmt = $db->prepare("SELECT * FROM ".$prefix['table_prefix']."_flussi_posts");
    $stmt->execute();

    return $stmt->fetchAll();
}

function countAllPosts($db, $prefix) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM ".$prefix['table_prefix']."_flussi_posts");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getAllPostsPagination($db, $prefix, $start, $limit, $search_term = '') {
    if ($search_term === '') {
        $stmt = $db->prepare("SELECT ".$prefix['table_prefix']."_flussi_posts.*, ".$prefix['table_prefix']."_flussi_menu.name AS menu_name FROM ".$prefix['table_prefix']."_flussi_posts LEFT JOIN ".$prefix['table_prefix']."_flussi_menu ON ".$prefix['table_prefix']."_flussi_posts.menu_id = ".$prefix['table_prefix']."_flussi_menu.id ORDER BY created_at DESC LIMIT :start, :limit");
    } else {
        $stmt = $db->prepare("SELECT ".$prefix['table_prefix']."_flussi_posts.*, ".$prefix['table_prefix']."_flussi_menu.name AS menu_name FROM ".$prefix['table_prefix']."_flussi_posts LEFT JOIN menu ON ".$prefix['table_prefix']."_flussi_posts.menu_id = ".$prefix['table_prefix']."_flussi_menu.id WHERE ".$prefix['table_prefix']."_flussi_posts.title LIKE :search_term OR ".$prefix['table_prefix']."_flussi_posts.content LIKE :search_term OR ".$prefix['table_prefix']."_flussi_menu.name LIKE :search_term ORDER BY created_at DESC LIMIT :start, :limit");
        $stmt->bindValue(':search_term', '%' . $search_term . '%', PDO::PARAM_STR);
    }

    $stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getExistingTags($db, $prefix) {
    $sql = "SELECT tags FROM ".$prefix['table_prefix']."_flussi_posts";
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

function deleteTagFromAllPosts($db, $prefix, $tagToRemove) {
    $sql = "SELECT id, tags FROM ".$prefix['table_prefix']."_flussi_posts";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tagArray = explode(',', $row['tags'] ?? '');
        $tagArray = array_map('trim', $tagArray);
        $tagKey = array_search($tagToRemove, $tagArray);
        if ($tagKey !== false) {
            unset($tagArray[$tagKey]);
            $newTags = implode(',', $tagArray);
            $updateSql = "UPDATE ".$prefix['table_prefix']."_flussi_posts SET tags = :tags WHERE id = :id";
            $updateStmt = $db->prepare($updateSql);
            $updateStmt->execute(['tags' => $newTags, 'id' => $row['id']]);
        }
    }
}
