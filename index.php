<?php
  require_once "vendor/autoload.php";
  require_once "config.php";

  try {
    $amo = new \AmoCRM\Client(AMOCRM['subdomain'], AMOCRM['login'], AMOCRM['hash']);
    echo "<pre>";
    $account = $amo->account;
    print_r($account->apiCurrent());
    echo "</pre>";
  } catch (\AmoCRM\Exception $e) {
        printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
  }


?>
