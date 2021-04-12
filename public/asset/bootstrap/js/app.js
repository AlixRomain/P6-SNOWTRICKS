$(function() {
  //gestion de la vues des tricks
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
  //Gestion de la vue des comments
  $('#loadMoreComment').click(function(){
    $('.hidden-tricks').css({
      display:'flex',

    })
    $("#loadMoreComment").hide('slow');
    $("#loadLessComment").show('slow');
  })

  $('#loadLessComment').click(function() {
    $('.hidden-tricks').css({
      display:'none'
    })
    $("#loadMoreComment").show();
    $("#loadLessComment").hide();
  })
  //Gestion de la vue des medias format mobile
  $('#seeMedia').click(function(){
    $('#carMedia').toggle('slow');
  })

  $('#carousel2').carousel()
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
  $("#encreComments").click(function(){
    scrollTo( $('#divComment') );
  });


  $("#more").click(function(){
    var toto =  $("#ulComment:nth-child(3)");
     $("html, body").stop().animate( { scrollTop: toto.offset().top }, 700);
  });

});
