<?php
	require_once "curl.php";
   require_once "amocrm.php";
  require_once "functions.php";

// http://localhost/aez/getContactsCompaniesSave.php  получить все контакты и компании в файл .csv
// http://localhost/aez/updateContactsTag.php обновить все теги
// http://localhost/aez/getAllCalls.php получить все звонки - не работает пока

  // header('Content-Type: html/csv; charset=utf-8' );
  // header(sprintf( 'Content-Disposition: attachment; filename=my-csv-%s.csv', date( 'dmY-His' ) ) );
  // header('Content-Transfer-Encoding: binary');
  // header('Expires: 0');
  // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  // header('Pragma: public');
  // saveArrayToCSV(getContactsAndCompaniesSave());
//print_r(getContactsAndCompaniesSave());
//  getAllCalls();
   // saveArrayToCSV(getAllCalls());
//   $amo = new \AmoCRM\Client(
//     AMOCRM['subdomain'],
//     AMOCRM['login'],
//     AMOCRM['hash']
//   );
//   $account = $amo->account;
//   $accInfo = $account->apiCurrent();
//
//   $users = $accInfo["users"];
//
// //  $note = $amo->note;
//
// getTimeline('15632651', $users);
//  setTagsAndFieldsFromArray(); //Проставить теги всем компаниям и контактам
  // $contacts = getAllContacts();
  // // $companies = getAllCompanies();
  // $slice = 3;
  //
  // echo '<pre>';
  // // print_r($database);
  //
  // echo "Общее количество контактов: ".count($contacts)."<br>";
  // echo "Первые $slice из них:<br>";
  // print_r(array_slice($contacts, 0, $slice));
  // //
  // // echo "Общее количество компаний: ".count($companies)."<br>";
  // // echo "Первые $slice из них:<br>";
  // // print_r(array_slice($companies, 0, $slice));
  //
  // echo '</pre>';

 ?>
