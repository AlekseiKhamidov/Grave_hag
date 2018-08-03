<?php
  require_once "vendor/autoload.php";
  require_once "config.php";
  require_once "functions.php";

  echo getContactsAndCompanies(true);
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

  function getContactsAndCompanies($json = false) {
    set_time_limit(0);  // global setting
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
