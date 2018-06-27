function getColumns(){
      var columns = [{
            field: 'id',
            title: 'ID',
            align: 'center',
            valign: 'middle',
            sortable: true
      },
      {
            field: 'name',
            title: 'ФИО клиента',
            align: 'center',
            valign: 'middle',
            sortable: true
      },
      {
            field: 'city',
            title: 'Город',
            align: 'center',
            valign: 'middle',
            sortable: true
      }];
      Date.prototype.addDays = function(days) {
        var dat = new Date(this.valueOf());
        dat.setDate(dat.getDate() + days);
        return dat;
      }

    var now = new Date();
    for (var i=21;i>=0;i--){
      var date = now.addDays(-1*i);
    //  console.log(date.toLocaleDateString());
      columns.push({
          field: moment(date).format('DD.MM'),
           title:moment(date).format('DD.MM'),
          align: 'center',
          valign: 'middle',
          cellStyle:'cellStyle',
          class:'cellDay',
          formatter:'cellDayFormat'
      });

  }
   return columns;
  };
