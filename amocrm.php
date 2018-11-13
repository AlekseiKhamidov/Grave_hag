<?php
  require_once "vendor/autoload.php";
  require_once "config.php";
  require_once "functions.php";
  //header('Content-Encoding: UTF-8');
 // header('Content-Type: html/csv; charset=utf-8' );
 // header(sprintf( 'Content-Disposition: attachment; filename=my-csv-%s.csv', date( 'dmY-His' ) ) );
 // header('Content-Transfer-Encoding: binary');
 // header('Expires: 0');
 // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
 // header('Pragma: public');

  function setTagsAndFieldsFromArray() {
//Рекомендую сначала всем контактам и компаниям проставить тег Холодный,
//а после этого запустить функцию updateContactsCompaniesByDB()


    $database = csv_to_array('CSVs/Database.csv');
    try {
      $amo = new \AmoCRM\Client(
        AMOCRM['subdomain'],
        AMOCRM['login'],
        AMOCRM['hash']
      );

      $allContacts = getAllContacts();
       $allCompanies = getAllCompanies();
    //  setAllContactsCompaniesTag('Холодный',$amo, $allContacts, false);
  //    setAllContactsCompaniesTag('Холодный',$amo, $allCompanies, true);

       updateContactsCompaniesByDB($amo, $allContacts, $database, AMOCRM['contact_CFs'],false);

       updateContactsCompaniesByDB($amo, $allCompanies, $database,AMOCRM['company_CFs'], true);

    } catch (\AmoCRM\Exception $e) {
        printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
    }
  }
  function setAllContactsCompaniesTag($tag,$amo,$allContacts,$isCompany=false){
    foreach ($allContacts as $allContact) {
      $id = $allContact['id'];
      print_r($id);
      if ($isCompany)
        $contact = $amo->company;
      else
        $contact = $amo->contact;
       $contact['tags'] = [$tag];
      $contact->apiUpdate((int)$id, 'now');
    }
  }

  function updateContactsCompaniesByDB($amo,$allContacts,$database,$AMOCRM,$isCompany=false){
    foreach ($allContacts as $allContact) {
      $id = $allContact['id'];
      $key = array_search($id, array_column($database, 'amoID'));
      if ($isCompany)
        $contact = $amo->company;
      else
        $contact = $amo->contact;
      if ($key!==false){
      // Обновление контактов

       $contact->addCustomField($AMOCRM["sum"], $database[$key]['Sum']);
       $contact->addCustomField($AMOCRM["count"], $database[$key]['Count']);
       $contact->addCustomField($AMOCRM["first_month"], $database[$key]['First']);
       $contact->addCustomField($AMOCRM["last_month"], $database[$key]['Last']);
       $contact->addCustomField($AMOCRM["qualification"], $database[$key]['Qualification']);
       $contact->addCustomField($AMOCRM["just_bought"], $database[$key]['Bought last month']);
       $contact->addCustomField($AMOCRM["chance"], $database[$key]['Chance']);
       $contact['tags'] = [$database[$key]['Qualification']];
      $contact->apiUpdate((int)$id, 'now');
        usleep(300);
      print_r($contact);
    }
    else {
       //  $contact['tags'] = ['Холодный'];
       // $contact->apiUpdate((int)$id, 'now');
    }
  }
  }


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
      $result = [];
      $allCompanies = getAllCompanies();
      $allContacts = getAllContacts();

      $fp = fopen('php://output', 'w');
      // //This line is important:
      // fputs( $fp, "\xEF\xBB\xBF" ); // UTF-8 BOM !!!!!
      //
      // $part = getTimeline('15632651', $users);
      // $result = array_merge($result,$part);
      //
      //  $part = getTimeline('31270637', $users);
      // $result = array_merge($result,$part);

    //   print_r($result) ;
      //
      // $part = getTimeline('32240699', $users);
      // array_merge($result,$part);

      foreach ($allCompanies as $company) {
        if ($company['id']){
          $part = getTimeline($company['id'],$users, true);
          $result =  array_merge($result,$part);
        }
        usleep(300);
      }

      //
      // foreach ($allContacts as $contact) {
      //   if ($contact['id']){
      //     $part = getTimeline($contact['id'],$users, false);
      //     $result =  array_merge($result,$part);
      //   }
      //   usleep(300);
      // }
  //    getTimeline
 // echo '<pre>';
 // // print_r($call);
 // print_r($result);
 // echo '</pre>';

 fclose($fp);


      // $fp = fopen('php://output', 'w');
      // //This line is important:
      // fputs( $fp, "\xEF\xBB\xBF" ); // UTF-8 BOM !!!!!

    //   foreach ($allCalls as $call) {
    //     $timestamp =$call['date_create'];
    //     $callInfo['Время звонка'] = date('H:i:s', $timestamp);
    //     $callInfo['Дата звонка'] = date('d-m-Y', $timestamp);
    //     $callInfo['Ответственный менеджер'] = $users[array_search($call['created_user_id'], array_column($users, 'id'))]['name'];
    //     $callInfo['Длительность звонка'] = json_decode($call['text'], true)['DURATION'];
    //     $callInfo['Тип звонка'] = $call["note_type"] == 10 ? "Входящий" : "Исходящий";
    //     $callInfo['Тип контакта'] = $call["element_type"] == 1 ? "Контакт" : "Компания";
    //     $callInfo['ID'] = $call["element_id"];
    //     $callInfo['Ссылка'] = 'https://aezcompany.amocrm.ru/'.($call["element_type"] == 1 ? 'contacts' : 'companies').'/detail/'.$call['element_id'];
    //
    // //    array_push($result, $callInfo);
    //   }

      // fclose($fp);
    } catch (\AmoCRM\Exception $e) {
        printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
    }

    return $json ? json_encode($result) : $result;
  }

  function getAllContacts($json = false) {
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
        // $cont = getEntityInfo($cont, AMOCRM["contact_CFs"]);
        // $cont['Ответственный менеджер'] = $users[array_search($cont['Ответственный менеджер'], array_column($users, 'id'))]['name'];
        // $cont['GMT'] = "";
        // $cont['Ссылка'] = 'https://aezcompany.amocrm.ru/contacts/detail/'.$cont['id'];
        $result[] = $cont;
      }
    } catch (\AmoCRM\Exception $e) {
        printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
    }
    return $json ? json_encode($result) : $result;
  }

  function getAllCompanies($json = false) {
    try {
      $amo = new \AmoCRM\Client(
        AMOCRM['subdomain'],
        AMOCRM['login'],
        AMOCRM['hash']
      );
      $account = $amo->account;
      $accInfo = $account->apiCurrent();

      $users = $accInfo["users"];

      $company = $amo->company;
      $allCompanies = fetchEntities($company);
      foreach ($allCompanies as $comp) {


        // $comp = getEntityInfo($comp, AMOCRM["company_CFs"]);
        // $comp['Ответственный менеджер'] = $users[array_search($comp['Ответственный менеджер'], array_column($users, 'id'))]['name'];
        // if (!isset($comp['GMT'])) $comp['GMT'] = "";
        // $comp['Ссылка'] = 'https://aezcompany.amocrm.ru/companies/detail/'.$comp['id'];
        $result[] = $comp;
      }
    } catch (\AmoCRM\Exception $e) {
          printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
    }
    return $json ? json_encode($result) : $result;
  }
  function getContactsAndCompaniesSave($json = false) {
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
      $cont['Ссылка'] = 'https://aezcompany.amocrm.ru/contacts/detail/'.$cont['id'];
      $result[] = $cont;
    }
    $company = $amo->company;
    $allCompanies = fetchEntities($company);
    foreach ($allCompanies as $comp) {
      $comp = getEntityInfo($comp, AMOCRM["company_CFs"]);
      $comp['Ответственный менеджер'] = $users[array_search($comp['Ответственный менеджер'], array_column($users, 'id'))]['name'];
      $comp['Ссылка'] = 'https://aezcompany.amocrm.ru/companies/detail/'.$comp['id'];
      $result[] = $comp;
    }
  } catch (\AmoCRM\Exception $e) {
        printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
  }
  return $json ? json_encode($result) : $result;
}

  function getContactsAndCompanies($json = false) {
    $result = array_merge(getAllContacts(), getAllCompanies());
    return $json ? json_encode($result) : $result;
  }
?>
