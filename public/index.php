<?php

require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/category.php';
require_once __DIR__ . '/../inc/post.php';
require_once __DIR__ . '/../inc/tag.php';

$sortOrder = filter_input(INPUT_GET, 'sort-order', FILTER_SANITIZE_STRING);
$sortOrder = $sortOrder ?? 'DESC';
$sortOrder = strtoupper($sortOrder);
unset($_GET['sort-order']);

?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>simple weblog</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <h1>
        <a href="index.php">Simple Weblog</a>
    </h1>
</header>
<aside>
    <?php
    $categories = findAllCategories();
    
    if (!empty($categories)) {
        echo '<nav id="categories">';
        echo '<h3>Categories</h3>';
        echo '<ul>';
        
        foreach ($categories as $category) {
            echo '<li><a href="index.php?category=' . $category['id'] . '">' . $category['name'] . '</a></li>';
        }
        
        echo '</ul>';
        echo '</nav>';
    }
    
    $tags = findAllTags();
    
    if (!empty($categories)) {
        echo '<nav id="tags">';
        echo '<h3>Tags</h3>';
        echo '<ul>';
        
        foreach ($tags as $tag) {
            echo '<li><a href="index.php?tag=' . $tag['id'] . '">' . $tag['name'] . '</a></li>';
        }
        
        echo '</ul>';
        echo '</nav>';
    }
    ?>
</aside>
<main>
    <?php
    if (empty($_GET)) : ?>
        <aside>
            <p>
                <span class="label">Sort:</span>
                <?php
                if ($sortOrder === 'DESC') {
                    echo '<a href="index.php?sort-order=asc">ascending</a>';
                } else {
                    echo '<a href="index.php?sort-order=desc">descending</a>';
                }
                ?>
            </p>
        </aside>
    <?php
    endif; ?>
    <?php
    
    if (empty($_GET)) {
        try {
            $posts = findAllPosts('created_at', $sortOrder);
            echo '<section>';
            echo '<header><h2>My latest Posts</h2></header>';
            echo '<ul>';
            foreach ($posts as $post) {
                $postPublishDate = strftime('%a %e. %B %Y', (new DateTime($post['created_at']))->getTimestamp());
                echo '<li>[' . $postPublishDate . '] <a href="?post=' . $post['id'] . '">' . $post['title'] . '</a></li>';
            }
            echo '</ul>';
            echo '</section>';
        } catch (Exception $exception) {
            echo 'Keine Beitr??ge gefunden. <a href="?action=new">Schreib</a> den ersten Beitrag.';
        }
    }
    
    if ($_GET['post']) {
        $postId = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);
        
        try {
            $post            = findOneCategory($postId);
            $postPublishDate = strftime('%a %e. %B %Y', (new DateTime($post['created_at']))->getTimestamp());
            
            echo '<article>';
            echo '<header><h2>' . $post['title'] . '</h2></header>';
            echo '<p>' . nl2br($post['content']) . '</p>';
            echo '<footer>ver??ffentlicht am: ' . $postPublishDate . '</footer>';
            echo '</article>';
        } catch (Exception $exception) {
            echo 'Keinen Beitrag mit der ID ' . $postId . ' gefunden';
        }
    }
    
    if ($_GET['category']) {
        $categoryId = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_NUMBER_INT);
        
        try {
            $posts    = findPostsByCategorie($categoryId, 'created_at', $sortOrder);
            $category = findOneCategory($categoryId);
            
            echo '<section>';
            echo '<header><h2>Posts in category ' . $category['name'] . '</h2></header>';
            echo '<ul>';
            foreach ($posts as $post) {
                $postPublishDate = strftime('%a %e. %B %Y', (new DateTime($post['created_at']))->getTimestamp());
                echo '<li>[' . $postPublishDate . '] <a href="?post=' . $post['id'] . '">' . $post['title'] . '</a></li>';
            }
            echo '</ul>';
            echo '</section>';
        } catch (Exception $exception) {
            echo 'Keine Beitr??ge gefunden. <a href="?action=new">Schreib</a> den ersten Beitrag.';
        }
    }
    
    if ($_GET['tag']) {
        $tagId = filter_input(INPUT_GET, 'tag', FILTER_SANITIZE_NUMBER_INT);
        
        try {
            $posts = findPostsByTag($tagId, 'created_at', $sortOrder);
            $tag   = findOneTag($tagId);
            
            echo '<section>';
            echo '<header><h2>Posts with tag ' . $tag['name'] . '</h2></header>';
            echo '<ul>';
            foreach ($posts as $post) {
                $postPublishDate = strftime('%a %e. %B %Y', (new DateTime($post['created_at']))->getTimestamp());
                echo '<li>[' . $postPublishDate . '] <a href="?post=' . $post['id'] . '">' . $post['title'] . '</a></li>';
            }
            echo '</ul>';
            echo '</section>';
        } catch (Exception $exception) {
            echo 'Keine Beitr??ge gefunden. <a href="?action=new">Schreib</a> den ersten Beitrag.';
        }
    }
    
    ?>
</main>
<footer>
    <p>&copy;2021 Simple Weblog by Steffen Grahl</p>
</footer>
</body>
</html>
