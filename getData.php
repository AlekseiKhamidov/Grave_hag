<?php
  require_once "vendor/autoload.php";
  require_once "config.php";
  require_once "functions.php";

  echo getData(true);

  function getData($json = false) {
    $data = [
      ["id"=>"100","name" => "Vasya", "city" => "Perm", "tel"=>"8914545454544","email"=>"yftftyftf@gjg.yuy","21.06"=>"1#Звонки: 1,"],
      ["id"=>"100","name" => "Vasya", "city" => "Perm","13.06"=>"1#Звонки: 1454646464646dfsdfsdfsfsdfsfd464#Примечание:аьудкпушкпошду ку прукщшп йущшкпшщупщшй пщшй укпщшйукп<br/>Задачи: оашыовашыовадоываошыоадшощшп оп шукопокп ващшивф"],
      ["id"=>"200","name" => "Петя", "city" => "QQQQQ","count"=>"12#5#1","note"=>"fnewfhwjehf1111111111111kwehfkjwehdjwehdjkhwefhwejfhwekjfhjwefhwjkefh"]
    ];

    return $json ? json_encode($data) : $data;
  }
?>
