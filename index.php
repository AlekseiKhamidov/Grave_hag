<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>amoCRM Backup</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-table.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap-table.js"></script>
  <script src="js/bootstrap-table-export.min.js"></script>
  <script src="//rawgit.com/hhurz/tableExport.jquery.plugin/master/tableExport.js"></script>
</head>

<body>
  <table id='tab' data-show-export="true" data-toggle="table">
    <thead>
        <tr>
           <th data-field="Время звонка">Время звонка</th>
           <th data-field="Дата звонка">Дата звонка</th>
           <th data-field="Ответственный менеджер" data-formatter="clear">Ответственный менеджер</th>
           <th data-field="Длительность звонка" data-formatter="clear">Длительность звонка</th>
           <th data-field="Тип звонка" data-formatter="clear">Тип звонка</th>
           <th data-field="Тип контакта" data-formatter="clear">Тип контакта</th>
           <th data-field="ID" data-formatter="clear">ID контакта</th>

   </thead>
  </table>

  <script>
    $('#tab').bootstrapTable({
     url: "amocrm.php"
    });
    function clear(value, row) {
      if (!value) value = "";
      return value;
    };
  </script>
</body>
</html>
