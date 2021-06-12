<?php

/**
 * @param string $orderColumn
 * @param string $orderDirection
 *
 * @return array
 * @throws Exception
 */
function findAllCategories(string $orderColumn = '', string $orderDirection = 'ASC'): array
{
    $db = connectDb();
    
    if (!array_key_exists('categories', $db)) {
        throw new Exception('No categories in DB.');
    }
    
    return sortByColumn($db['categories'], $orderColumn, $orderDirection);
}
