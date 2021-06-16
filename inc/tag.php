<?php

/**
 * @param string $orderColumn
 * @param string $orderDirection
 *
 * @return array
 * @throws Exception
 */
function findAllTags(string $orderColumn = '', string $orderDirection = 'ASC'): array
{
    $db = connectDb();
    
    if (!array_key_exists('tags', $db)) {
        throw new Exception('No tags in DB.');
    }
    
    return sortByColumn($db['tags'], $orderColumn, $orderDirection);
}

/**
 * @param int $id
 *
 * @return array
 * @throws Exception
 */
function findOneTag(int $id): array
{
    $tags = findAllTags();
    
    foreach ($tags as $tag) {
        if (!array_key_exists('id', $tag)) {
            continue;
        }
        
        if ($tag['id'] === $id) {
            return $tag;
        }
    }
    
    throw new Exception('Didn\'nt find any tag with Id ' . $id);
}
