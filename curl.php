<?php
	require_once "config.php";
	auth();

  function getTimeline($idCompany,$users, $isCompany){
  //  https://aezcompany.amocrm.ru/v3/companies/15632651/timeline?type=11
    $link=$isCompany?'https://'.AMOCRM['subdomain'].'.amocrm.ru/v3/companies/'.$idCompany.'/timeline':'https://'.AMOCRM['subdomain'].'.amocrm.ru/v3/contacts/'.$idCompany.'/timeline';
    $Response = processCURL($link);
    $data = $Response['_embedded']['items'];
    $income_keys = array_keys(array_column($data, 'type'),'11');

    // echo '<pre>';
    // print_r($users);
    //
    // echo '</pre>';

    $result = [];
    foreach ($income_keys as $income_key) {
      $call = $data[$income_key];
      $timestamp =$call['date_create'];
      $callInfo['Время звонка'] = date('H:i:s', $timestamp);
      $callInfo['Дата звонка'] = date('d-m-Y', $timestamp);
       $callInfo['Ответственный менеджер'] = $users[array_search($call['created_by'], array_column($users, 'id'))]['name'];
       $callInfo['Длительность звонка'] = $call['data']['params']['duration'];//json_decode($call['text'], true)['DURATION'];
       $callInfo['Тип звонка'] = "Исходящий";
       $callInfo['Тип контакта'] = $isCompany?"Компания":"Контакт";
       $callInfo['ID'] = $idCompany;//$call["id"];
       $callInfo['Ссылка'] = $isCompany?'https://aezcompany.amocrm.ru/companies/detail/'.$idCompany:'https://aezcompany.amocrm.ru/contacts/detail/'.$idCompany;

       array_push($result, $callInfo);
      // echo '<pre>';
      // // print_r($call);
      // print_r($callInfo);
      // echo '</pre>';
    }
    // echo '<pre>';
    // // print_r($call);
    // print_r($callInfo);
    // echo '</pre>';
    return $result;
  }


function auth() {
  #Массив с параметрами, которые нужно передать методом POST к API системы
  $post=array(
    'USER_LOGIN'=>AMOCRM['login'],
    'USER_HASH'=>AMOCRM['hash']
  );

  #Формируем ссылку для запроса
  $link='https://'.AMOCRM['subdomain'].'.amocrm.ru/private/api/auth.php?type=json';

  $Response = processCURL($link, $post);

  if(isset($Response['response']['auth'])) #Флаг авторизации доступен в свойстве "auth"
    return 'Авторизация прошла успешно';
  return 'Авторизация не удалась';
};
############################## Работа с CURL ########################################

	function processCURL($url, $postFields = array(), $date_modified='') {
		$curl=curl_init();  #Сохраняем дескриптор сеанса cURL
		#Устанавливаем необходимые опции для сеанса cURL
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
		curl_setopt($curl,CURLOPT_URL,$url);

		if ($postFields) {
			curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
			curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($postFields));
			curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
		}

		curl_setopt($curl,CURLOPT_HEADER,false);
		curl_setopt($curl,CURLOPT_COOKIEFILE,__DIR__.'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
		curl_setopt($curl,CURLOPT_COOKIEJAR,__DIR__.'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
		if ($date_modified) {
			curl_setopt($curl,CURLOPT_HTTPHEADER,array('IF-MODIFIED-SINCE: '.$date_modified));
		}

		$out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
		$code=curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
		curl_close($curl); #Завершаем сеанс cURL

		$code=(int)$code;
		$errors=array(
		  301=>'Moved permanently',
		  400=>'Bad request',
		  401=>'Unauthorized',
		  403=>'Forbidden',
		  404=>'Not found',
		  500=>'Internal server error',
		  502=>'Bad gateway',
		  503=>'Service unavailable'
		);
		try
		{
		   #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
		  if($code!=200 && $code!=204)
		    throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
		}
		catch(Exception $E)
		{
		  die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
		}

		/**
		 * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
		 * нам придётся перевести ответ в формат, понятный PHP
		 */
		$Response=json_decode($out, true);
		return $Response;
	};

	########################################################################################


 ?>
