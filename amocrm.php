<?php
  require_once "vendor/autoload.php";
  require_once "config.php";
  require_once "functions.php";

  set_time_limit(0);  // global setting
  ini_set('memory_limit', '1024M'); // or you could use 1G
  date_default_timezone_set('Asia/Yekaterinburg');
  echo getAllCalls(true);
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

      foreach ($allCalls as $call) {
        $call['Время звонка'] = date('h:i:s', $call['date_create']);
        $call['Дата звонка'] = date('d.m.Y', $call['date_create']);
        $call['Ответственный менеджер'] = $users[array_search($call['created_user_id'], array_column($users, 'id'))]['name'];
        $call['Длительность звонка'] = json_decode($call['text'], true)['DURATION'];
        $call['Тип звонка'] = $call["note_type"] == 10 ? "Входящий" : "Исходящий";
        $call['Тип контакта'] = $call["element_type"] == 1 ? "Контакт" : "Компания";


        $result[] = $call;
      }

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
