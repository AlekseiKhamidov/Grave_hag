<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>amoCRM Backup</title>
  <meta charset="utf-8">
  <meta name="description" content="Contacts & Companies">
  <meta name="author" content="AlekseiKhamidov">
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
           <th data-field="Город #1">Город</th>
           <th data-field="Телефон #1">Телефон #1</th>
           <th data-field="Телефон #2">Телефон #2</th>
           <th data-field="Телефон #3">Телефон #3</th>
           <th data-field="Телефон #4">Телефон #4</th>
           <th data-field="Телефон #5">Телефон #5</th>
           <th data-field="Телефон #6">Телефон #6</th>
           <th data-field="Телефон #7">Телефон #7</th>
           <th data-field="Телефон #8">Телефон #8</th>
           <th data-field="Телефон #9">Телефон #9</th>
           <th data-field="Email #1">Email #1</th>
           <th data-field="Email #2">Email #2</th>
           <th data-field="Email #3">Email #3</th>
           <th data-field="Email #4">Email #4</th>
           <th data-field="Email #5">Email #5</th>
           <th data-field="Email #6">Email #6</th>
   </thead>
  </table>

  <script>
    $('#tab').bootstrapTable({
     url: "amocrm.php"
    });
  </script>
</body>
</html>
