$(function() {
  $('#loadMoreTrick').click(function(){
    $('.hidden-tricks').css({
      display:'inherit'
    })
    $("#loadMoreTrick").hide('slow');
    $("#loadLessTrick").show('slow');
  })

  $('#loadLessTrick').click(function() {
    $('.hidden-tricks').css({
      display:'none'
    })
    $("#loadMoreTrick").show('slow');
    $("#loadLessTrick").hide('slow');
  })

  /**
   * Smooth scrolling to a specific element
   **/
  function scrollTo( target ) {
    if( target.length ) {
      $("html, body").stop().animate( { scrollTop: target.offset().top }, 700);
    }
  }


  $("#down").click(function(){
    scrollTo( $('#tricks-title') );
  });
  $("#up").click(function(){
    scrollTo( $('#tricks-title') );
  });

});
