<<?php

    $database = csv_to_array('CSVs/Database.csv');
    try {
      $amo = new \AmoCRM\Client(
        AMOCRM['subdomain'],
        AMOCRM['login'],
        AMOCRM['hash']
      );

      $allContacts = getAllContacts();
       $allCompanies = getAllCompanies();
      setAllContactsCompaniesTag('Холодный',$amo, $allContacts, false);
      setAllContactsCompaniesTag('Холодный',$amo, $allCompanies, true);

      // updateContactsCompaniesByDB($amo, $allContacts, $database, AMOCRM['contact_CFs'],false);

    //   updateContactsCompaniesByDB($amo, $allCompanies, $database,AMOCRM['company_CFs'], true);

    } catch (\AmoCRM\Exception $e) {
        printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
    }
 ?>
