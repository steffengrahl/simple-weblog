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
