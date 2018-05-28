<?php
  require_once "vendor/autoload.php";

  function fetchEntities($entity) {
    $i = 0;
    $entityList = array();
    try {
      do {
          $fetchedEntities = $entity->apiList([
            'limit_rows' => 500,
            'limit_offset' => 500 * $i++
          ]);
          $entityList = array_merge($entityList, $fetchedEntities);
          usleep(600);
      } while ($fetchedEntities);
    } catch (\AmoCRM\Exception $e) {
      printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
    }
    return $entityList;
  }

?>
