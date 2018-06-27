function linkFormat(value, row){
  var link = "<a href='value'>"+value+"</a>";
  return link;

}
function clear(value, row) {
  if (!value) value = "";
  return value;
};
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
    result = mas[0];
    if (mas.length>1)
    {}

  };
  return result;
};
