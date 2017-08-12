$(document).ready(function(){

  $('.category-class').each(function(){
    if ($(this).text() == "健康养育"){
      $(this).addClass('health-title');
    }
    else if ($(this).text() == "心理教育"){
      $(this).addClass('psychology-title');
    }
    else{
      $(this).addClass('grow-title');
    }
  });
    
});
    