<?php

/**
 * @return array
 * @throws Exception
 */
function connectDb(): array
{
    $dbFile = __DIR__ . '/../data/db.json';
    
    if (!file_exists($dbFile)) {
        throw new Exception('Could not connect to DB.');
    }
    
    $json = file_get_contents($dbFile);
    
    if (empty($json)) {
        throw new Exception('Didn\'t find any data inside of DB.');
    }
    
    return json_decode($json, true);
}

/**
 * @param array  $content
 * @param string $orderColumn
 * @param string $orderDirection
 *
 * @return array
 */
function sortByColumn(array $content, string $orderColumn, string $orderDirection): array
{
    $orderColumn = $orderColumn ?? 'id';
    
    usort(
        $content,
        static function ($a, $b) use ($orderColumn, $orderDirection) {
            if (strtoupper($orderDirection) === 'DESC') {
                return $b[$orderColumn] <=> $a[$orderColumn];
            }
            
            return $a[$orderColumn] <=> $b[$orderColumn];
        }
    );
    
    return $content;
}
