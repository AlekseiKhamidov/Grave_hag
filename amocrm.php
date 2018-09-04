<?php
  require_once "vendor/autoload.php";
  require_once "config.php";
  require_once "functions.php";


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

      // $fp = fopen('php://output', 'w');
      // //This line is important:
      // fputs( $fp, "\xEF\xBB\xBF" ); // UTF-8 BOM !!!!!

      foreach ($allCalls as $call) {
        $timestamp =$call['date_create'];
        $callInfo['Время звонка'] = date('H:i:s', $timestamp);
        $callInfo['Дата звонка'] = date('d-m-Y', $timestamp);
        $callInfo['Ответственный менеджер'] = $users[array_search($call['created_user_id'], array_column($users, 'id'))]['name'];
        $callInfo['Длительность звонка'] = json_decode($call['text'], true)['DURATION'];
        $callInfo['Тип звонка'] = $call["note_type"] == 10 ? "Входящий" : "Исходящий";
        $callInfo['Тип контакта'] = $call["element_type"] == 1 ? "Контакт" : "Компания";
        $callInfo['ID'] = $call["element_id"];
        $callInfo['Ссылка'] = 'https://aezcompany.amocrm.ru/'.($call["element_type"] == 1 ? 'contacts' : 'companies').'/detail/'.$call['element_id'];

        array_push($result, $callInfo);
      }

      // fclose($fp);
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
        $cont['GMT'] = "";
        $cont['Ссылка'] = 'https://aezcompany.amocrm.ru/contacts/detail/'.$cont['id'];
        $result[] = $cont;
      }

      $company = $amo->company;
      $allCompanies = fetchEntities($company);
      foreach ($allCompanies as $comp) {
        $comp = getEntityInfo($comp, AMOCRM["company_CFs"]);
        $comp['Ответственный менеджер'] = $users[array_search($comp['Ответственный менеджер'], array_column($users, 'id'))]['name'];
        if (!isset($comp['GMT'])) $comp['GMT'] = "";
        $comp['Ссылка'] = 'https://aezcompany.amocrm.ru/companies/detail/'.$comp['id'];
        $result[] = $comp;
      }
    } catch (\AmoCRM\Exception $e) {
          printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
    }

    return $json ? json_encode($result) : $result;
  }
?>
