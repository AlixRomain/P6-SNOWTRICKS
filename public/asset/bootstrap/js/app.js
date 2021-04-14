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


  $(function () {
    $('.apoper').popover({
      container: '.row'
    });
  })
  /* --------------------------------------------------------------------------------- */

  /*  /* Get alt and replace placeholder with it */

  /* --------------------------------------------------------------------------------- */
  var i = 0;
  $(".img-trick").each(function () {
    var alt = $(this).attr("alt");
    $("label[for=trick_images_" + i + "_image]").text(alt);
    i++;
  });

  /* --------------------------------------------------------------------------------- */

  /*  /* Trick collection */

  /* --------------------------------------------------------------------------------- */

  function displayCounter() {
    const countImage = +$("#tricks_update_media div.form-group").length;
    const counterImage = countImage + "/4";
    $(".counter-image").text(counterImage);
    if (countImage >= 4) {
      $("#add-image").hide();
    } else {
      $("#add-image").show();
    }
    const countVideo = +$("#tricks_update_video div.form-group").length;
    const counterVideo = countVideo + "/4";
    $(".counter-video").text(counterVideo);
    if (countVideo >= 8) {
      $("#add-video").hide();
    } else {
      $("#add-video").show();
    }
  }

  function updateCounterImage() {
    const count = +$("#tricks_update_media div.form-group").length;
    $("#image-counter").val(count);
  }

  function updateCounterVideo() {
    const count = +$("#tricks_update_video div.form-group").length;
    $("#video-counter").val(count);
  }

  function handleDeleteButtons() {
    $("button[data-action='delete']").click(function () {
      const target = this.dataset.target;
      $(target).remove();
      updateCounterImage();
      updateCounterVideo();
      displayCounter();
    });
  }

  $("#add-image").click(function () {
    const index = +$("#image-counter").val();
    const tmpl = $("#tricks_update_media").data("prototype").replace(/__name__/g, index);
    $("#tricks_update_media").append(tmpl);
    $("#image-counter").val(index + 1);
    handleDeleteButtons();
    displayCounter();
  });
  $("#add-video").click(function () {
    const index = +$("#video-counter").val();
    const tmpl = $("#tricks_update_video").data("prototype").replace(/__name__/g, index);
    $("#tricks_update_video").append(tmpl);
    $("#video-counter").val(index + 1);
    handleDeleteButtons();
    displayCounter();
  });

  displayCounter();
  updateCounterVideo();
  updateCounterImage();
  handleDeleteButtons();

});
