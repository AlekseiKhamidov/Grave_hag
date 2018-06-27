<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Material Design Bootstrap</title>
      <link href="css/style.css" rel="stylesheet">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   <!-- Bootstrap core CSS -->
   <link href="css/bootstrap.min.css" rel="stylesheet">
   <!-- Material Design Bootstrap -->
   <link href="css/mdb.min.css" rel="stylesheet">
   <!-- Your custom styles (optional) -->

   <link rel="stylesheet" href="css/bootstrap-table.min.css">
   <style>

   </style>

</head>

<body>
  <div class="table-responsive">
  <table id='tab' data-show-export="true" data-toggle="table">

  </table>
</div>
  <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
    <script src="js/bootstrap-table.js"></script>
    <script src="js/bootstrap-table-export.min.js"></script>
    <script src="//rawgit.com/hhurz/tableExport.jquery.plugin/master/tableExport.js"></script>
      <script src="js/function.js"></script>
      <script src="js/formatter.js"></script>
      <script src="js/moment-with-locales.js"></script>
      <script type="text/javascript">

   </script>
  <script>
//
  $('#tab').bootstrapTable({
   url: "getData.php",
   columns:getColumns()
  });
  $("#tab").on('post-body.bs.table', function (){

      $("#tab tbody > tr > td").each(function(){
        $(this).attr('data-toggle',"tooltip");
        $(this).attr('title',$(this).text());
        $(this).tooltip();
      });
  });

  $(function () {

  });

  </script>
</body>
</html>
