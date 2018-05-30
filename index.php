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
           <th data-field="Город #1" data-formatter="clear">Город</th>
           <th data-field="Телефон #1" data-formatter="clear">Телефон #1</th>
           <th data-field="Телефон #2" data-formatter="clear">Телефон #2</th>
           <th data-field="Телефон #3" data-formatter="clear">Телефон #3</th>
           <th data-field="Телефон #4" data-formatter="clear">Телефон #4</th>
           <th data-field="Телефон #5" data-formatter="clear">Телефон #5</th>
           <th data-field="Телефон #6" data-formatter="clear">Телефон #6</th>
           <th data-field="Телефон #7" data-formatter="clear">Телефон #7</th>
           <th data-field="Телефон #8" data-formatter="clear">Телефон #8</th>
           <th data-field="Телефон #9" data-formatter="clear">Телефон #9</th>
           <th data-field="Email #1" data-formatter="clear">Email #1</th>
           <th data-field="Email #2" data-formatter="clear">Email #2</th>
           <th data-field="Email #3" data-formatter="clear">Email #3</th>
           <th data-field="Email #4" data-formatter="clear">Email #4</th>
           <th data-field="Email #5">Email #5</th>
           <th data-field="Email #6">Email #6</th>
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
