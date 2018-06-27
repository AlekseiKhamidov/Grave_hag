function linkFormat(value, row){
  var link = "<a href='value'>"+value+"</a>";
  return link;

}
function clear(value, row) {
  if (!value) value = "";
  return value;
};
function telFormat(value, row, index){
  if (value) {
    return "<i class='fa fa-phone' aria-hidden='true'></i><a href='tel:"+value+"' > "+value+"</a>";
  }
  return "";
}
function emailFormat(value, row, index){

  if (value) {
    return "</i></i><a onclick='copyToClipboard(this.href)' href='mailto:"+value+"' target='_self'> "+value+" <i class='fa fa-copy' aria-hidden='true'></i></a>";
  }
  return "";
}
function cellStyle(value, row, index){
  if (value){
    return {
           classes:'warning-color'
       };
  }
  return 0;
};
function cellDayFormat(value, row){
  var result="";
  if (value){
    var mas = value.split('#');
    var text, title,content="";
    if (mas.length>0){
      text = mas[0];
    }
    if (mas.length>1){
      title = mas[1];
    }
    if (mas.length>2){
      content = mas[2]
    }
    if (mas.length>1)
    result = "<a style='width:100%;  display:block;' data-toggle='popover' data-trigger='hover' data-html='true' title='"+title+"' data-content='"+content +"'>"+text+"</a>";
    {}

  };
  return result;
};
