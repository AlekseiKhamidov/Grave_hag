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
    // print_r($account->apiCurrent());

    $contact = $amo->contact;
    $allContacts = fetchEntities($contact);

    $company = $amo->company;
    $allCompanies = fetchEntities($company);


    echo count($allContacts)." ".count($allCompanies);

    echo "</pre>";
  } catch (\AmoCRM\Exception $e) {
        printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
  }
?>
