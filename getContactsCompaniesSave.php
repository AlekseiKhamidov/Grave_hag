<?php
	require_once "curl.php";
   require_once "amocrm.php";
  require_once "functions.php";
  header('Content-Type: html/csv; charset=utf-8' );
  header(sprintf( 'Content-Disposition: attachment; filename=my-csv-%s.csv', date( 'dmY-His' ) ) );
  header('Content-Transfer-Encoding: binary');
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Pragma: public');
  saveArrayToCSV(getContactsAndCompaniesSave());
  ?>
