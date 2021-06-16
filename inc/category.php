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

/**
 * @param int $id
 *
 * @return array
 * @throws Exception
 */
function findOneCategory(int $id): array
{
    $categories = findAllCategories();
    
    foreach ($categories as $category) {
        if (!array_key_exists('id', $category)) {
            continue;
        }
        
        if ($category['id'] === $id) {
            return $category;
        }
    }
    
    throw new Exception('Didn\'nt find any category with Id ' . $id);
}
