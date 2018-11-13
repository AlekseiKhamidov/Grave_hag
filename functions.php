<?php
  require_once "vendor/autoload.php";
    // header('Content-Encoding: UTF-8');
    // header('Content-Type: html/csv; charset=utf-8' );
    // header(sprintf( 'Content-Disposition: attachment; filename=my-csv-%s.csv', date( 'dmY-His' ) ) );
    // header('Content-Transfer-Encoding: binary');
    // header('Expires: 0');
    // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    // header('Pragma: public');


  function csv_to_array($filename='', $delimiter=';')  {
    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;
    $f = file_get_contents($filename);
    $f = mb_convert_encoding($f, 'utf-8', 'cp1251');
    file_put_contents('CSVs/usable.csv', $f);

    $filename ='CSVs/usable.csv';

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 0, $delimiter)) !== FALSE)
        {
            if(!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    return $data;
  }

  function saveArrayToCSV($array = []) {
    $fp = fopen('php://output', 'w');
    //This line is import ant:
    fputs( $fp, "\xEF\xBB\xBF" ); // UTF-8 BOM !!!!!
    foreach ($array as $value) {
      fputcsv($fp, $value);
    }
    fclose($fp);
  }

  function deleteLineBreaks($string) {
    $string = str_replace("\n", "", $string);
    $string = str_replace("\r", "", $string);
    return $string;
  }

  function fetchEntities($entity, $params = []) {
    $i = 0;
    // print_r(__FUNCTION__);
    $entityList = array();
    try {
      do {
          $fetchedEntities = $entity->apiList(array_merge([
            'limit_rows' => 500,
            'limit_offset' => 500 * $i++
          ], $params));
          $entityList = array_merge($entityList, $fetchedEntities);
          usleep(600);
      } while ($fetchedEntities);
    } catch (\AmoCRM\Exception $e) {
      printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
    }
    return $entityList;
  }

  function getEntityInfo($entity, $fields = []) {
    $result['id'] = $entity['id'];
    $result['Наименование'] = deleteLineBreaks($entity["name"]);
    // $result['Tags'] = $entity["tags"];
    $result['Ответственный менеджер'] = $entity["responsible_user_id"];
    // if (isset($entity['custom_fields']) && $entity['custom_fields'] && $fields) {
    //    foreach ($fields as $id) {
    //      $CFs = $entity['custom_fields'];
    //      $key = array_search($id, array_column($CFs, 'id'));
    //      if ($key !== false) {
    //        $field = $CFs[$key];
    //        // print_r($field);
    //        $result[$field["name"]] = $field["values"][0]["value"];
    //     }
    //   }
    // }
    return $result;
  }
?>
