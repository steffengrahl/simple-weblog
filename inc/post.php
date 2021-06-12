<?php

/**
 * @param string $orderColumn
 * @param string $orderDirection
 *
 * @return array
 * @throws Exception
 */
function findAllPosts(string $orderColumn = '', string $orderDirection = 'ASC'): array
{
    $db = connectDb();
    
    if (!array_key_exists('posts', $db)) {
        throw new Exception('No posts in DB.');
    }
    
    return sortByColumn($db['posts'], $orderColumn, $orderDirection);
}

/**
 * @param int $id
 *
 * @return array
 * @throws Exception
 */
function findOnePost(int $id): array
{
    $posts = findAllPosts();
    
    foreach ($posts as $post) {
        if (!array_key_exists('id', $post)) {
            continue;
        }
        
        if ($post['id'] === $id) {
            return $post;
        }
    }
    
    throw new Exception('Didn\'nt find any post with Id ' . $id);
}

function findPostsByCategorie(int $categoryId, string $orderColumn = '', string $orderDirection = 'ASC'): array
{
    $posts = findAllPosts();
    $posts = sortByColumn($posts, $orderColumn, $orderDirection);
    
    return array_filter($posts, static function (array $post) use ($categoryId) {
        return $post['category'] === $categoryId;
    });
}

function findPostsByTag(int $tagId, string $orderColumn = '', string $orderDirection = 'ASC'): array
{
    $posts = findAllPosts();
    $posts = sortByColumn($posts, $orderColumn, $orderDirection);
    
    return array_filter($posts, static function (array $post) use ($tagId) {
        return in_array($tagId, $post['tags'], true);
    });
}
