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

  /*  /* Get path File and replace placeholder input with it */

  /* --------------------------------------------------------------------------------- */

  $(document).on('change', '.custom-file-input', function(event){
    $(this).next('.custom-file-label').html(event.target.files[0].name); })

  /* --------------------------------------------------------------------------------- */

  /*  /* Trick collection */

  /* --------------------------------------------------------------------------------- */

  function displayCounter() {
    const countCategory = +$("#tricks_update_category option:selected").length;
    if (countCategory >= 3) {
      $("#tricks_update_category ").find('option:not(:selected)').hide();
    } else {
      $("#tricks_update_category").find('option:not(:selected)').show();;
    }
    if (countCategory) {
      const progress = countCategory * 33.33
      $("#barCategory").css({'width': progress +'%',
      })
      if(progress > 99){
        $("#barCategory").addClass('bg-success');
        $("#barCategory").removeClass('bg-warning');
      }else{
        $("#barCategory").addClass('bg-warning');
      }
    }


    const countImage = +$("#tricks_update_media div.form-group").length;
    if (countImage >= 4) {
      $("#add-image").hide();
    } else {
      $("#add-image").show();
    }
    if (countImage) {
        const progress = countImage * 25
        $("#barImage").css({'width': progress +'%',
        })
        if(progress > 99){
          $("#barImage").addClass('bg-success');
          $("#barImage").removeClass('bg-warning');
        }else{
            $("#barImage").addClass('bg-warning');
        }
    }else{
      $("#barImage").css({'width': 0,})
    }

    const countVideo = +$("#tricks_update_video div.form-group").length;
    if (countVideo >= 4) {
      $("#add-video").hide();
    } else {
      $("#add-video").show();
    }

    if (countVideo) {
      console.log(countVideo);
      const progress = countVideo * 25
      $("#barVideo").css({'width': progress +'%',
      })
      if(progress > 99){
        $("#barVideo").addClass('bg-success');
        $("#barVideo").removeClass('bg-warning');
      }else{
        $("#barVideo").addClass('bg-warning');
      }
    }else{
      $("#barVideo").css({'width': 0,})
    }
  }


  $("#tricks_update_category").click(function () {
    const index = +$("#category-counter").val();
    $("#category-counter").val(index + 1);
    displayCounter();
  });

  function updateCounterCategory() {
    const count = +$("#tricks_update_category option:selected").length;
    $("#category-counter").val(count);
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
  updateCounterCategory();
  updateCounterVideo();
  updateCounterImage();
  handleDeleteButtons();

});
