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
      },
      {
            field: 'tel',
            title: 'Телефон',
            align: 'center',
            valign: 'middle',
            formatter:'telFormat'

      },
      {
            field: 'email',
            title: 'E-mail',
            align: 'center',
            valign: 'middle',
            formatter:'emailFormat'

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
  function copyToClipboard(text) {
      if (window.clipboardData) { // Internet Explorer
          window.clipboardData.setData("Text", text);
      } else {
          unsafeWindow.netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
          const clipboardHelper = Components.classes["@mozilla.org/widget/clipboardhelper;1"].getService(Components.interfaces.nsIClipboardHelper);
          clipboardHelper.copyString(text);
      }
  }
