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
           <th data-field="id">ID</th>
           <th data-field="Наименование">Наименование</th>
           <th data-field="Ответственный менеджер" data-formatter="clear">Ответственный менеджер</th>
           <th data-field="Телефон" data-formatter="clear">Телефон</th>
           <th data-field="Описание" data-formatter="clear">Описание</th>

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
