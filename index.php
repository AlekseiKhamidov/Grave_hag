<?php
  require_once "vendor/autoload.php";
  require_once "config.php";
  require_once "functions.php";

  set_time_limit(0);  // global setting

  try {
    $amo = new \AmoCRM\Client(
      AMOCRM['subdomain'],
      AMOCRM['login'],
      AMOCRM['hash']
    );
    echo "<pre>";

    $account = $amo->account;
    $accInfo = $account->apiCurrent();

    // print_r($accInfo);

    $contact = $amo->contact;
    $allContacts = fetchEntities($contact);
    foreach ($allContacts as $cont) {
      print_r(getEntityInfo($cont, AMOCRM["contact_CFs"]));
    }

    $company = $amo->company;
    $allCompanies = fetchEntities($company);
    foreach ($allCompanies as $comp) {
      print_r(getEntityInfo($comp, AMOCRM["company_CFs"]));
    }

    echo "</pre>";
  } catch (\AmoCRM\Exception $e) {
        printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
  }
?>
