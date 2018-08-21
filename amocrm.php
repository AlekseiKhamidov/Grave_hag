<?php
  require_once "vendor/autoload.php";
  require_once "config.php";
  require_once "functions.php";

  header('Content-Encoding: UTF-8');
  header('Content-Type: text/csv; charset=utf-8' );
  header(sprintf( 'Content-Disposition: attachment; filename=my-csv-%s.csv', date( 'dmY-His' ) ) );
  header('Content-Transfer-Encoding: binary');
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Pragma: public');

  set_time_limit(0);  // global setting
  ini_set('memory_limit', '1024M'); // or you could use 1G
  date_default_timezone_set('Etc/GMT-4');

  getAllCalls();
  // echo json_encode(getAllCalls());
  // echo json_encode(array_slice($all, 0, count($all)/2));
  // echo getContactsAndCompanies(true);
  // test();
  //
  // function test() {
  //   $amo = new \AmoCRM\Client(
  //     AMOCRM['subdomain'],
  //     AMOCRM['login'],
  //     AMOCRM['hash']
  //   );
  //   $account = $amo->account;
  //   $accInfo = $account->apiCurrent();
  //
  //   print_r($accInfo["users"]);
  // }

  function getAllCalls($json = false) {
    try {
      // print_r(__FUNCTION__);

      $amo = new \AmoCRM\Client(
        AMOCRM['subdomain'],
        AMOCRM['login'],
        AMOCRM['hash']
      );
      $account = $amo->account;
      $accInfo = $account->apiCurrent();

      $users = $accInfo["users"];

      $note = $amo->note;
      $allCalls = fetchEntities($note, [
        "note_type" => 11,
        "type" => "contact",
      ]);
      $allCalls = array_merge($allCalls, fetchEntities($note, [
        "note_type" => 10,
        "type" => "contact",
      ]));
      $allCalls = array_merge($allCalls, fetchEntities($note, [
        "note_type" => 11,
        "type" => "company",
      ]));
      $allCalls = array_merge($allCalls, fetchEntities($note, [
        "note_type" => 10,
        "type" => "company",
      ]));
      $result = [];

      // echo count($allCalls);


      $fp = fopen('php://output', 'w');
      //This line is important:
      fputs( $fp, "\xEF\xBB\xBF" ); // UTF-8 BOM !!!!!

      foreach ($allCalls as $call) {
        $timestamp =$call['date_create'];
        $callInfo['Время звонка'] = date('H:i:s', $timestamp);
        $callInfo['Дата звонка'] = date('d-m-Y', $timestamp);
        $callInfo['Ответственный менеджер'] = $users[array_search($call['created_user_id'], array_column($users, 'id'))]['name'];
        $callInfo['Длительность звонка'] = json_decode($call['text'], true)['DURATION'];
        $callInfo['Тип звонка'] = $call["note_type"] == 10 ? "Входящий" : "Исходящий";
        $callInfo['Тип контакта'] = $call["element_type"] == 1 ? "Контакт" : "Компания";
        $callInfo['ID'] = $call["element_id"];
        fputcsv($fp, $callInfo);
        // array_push($result, $callInfo);
      }

      fclose($fp);

    } catch (\AmoCRM\Exception $e) {
          printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
    }

    return $json ? json_encode($result) : $result;
  }

  function getContactsAndCompanies($json = false) {

    try {
      $amo = new \AmoCRM\Client(
        AMOCRM['subdomain'],
        AMOCRM['login'],
        AMOCRM['hash']
      );
      $account = $amo->account;
      $accInfo = $account->apiCurrent();

      $users = $accInfo["users"];

      $contact = $amo->contact;
      $allContacts = fetchEntities($contact);
      foreach ($allContacts as $cont) {
        $cont = getEntityInfo($cont, AMOCRM["contact_CFs"]);
        $cont['Ответственный менеджер'] = $users[array_search($cont['Ответственный менеджер'], array_column($users, 'id'))]['name'];
        $result[] = $cont;
      }

      $company = $amo->company;
      $allCompanies = fetchEntities($company);
      foreach ($allCompanies as $comp) {
        $comp = getEntityInfo($comp, AMOCRM["company_CFs"]);
        $comp['Ответственный менеджер'] = $users[array_search($comp['Ответственный менеджер'], array_column($users, 'id'))]['name'];
        $result[] = $comp;
      }
    } catch (\AmoCRM\Exception $e) {
          printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
    }

    return $json ? json_encode($result) : $result;
  }
?>
