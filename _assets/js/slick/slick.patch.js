$(window).load(function() {
      $('.slides').on('setPosition', function () {
      $(this).find('.slick-slide').height('auto');
      var slickTrack = $(this).find('.slick-track');
      var slickTrackHeight = $(slickTrack).height();
      $(this).find('.slick-slide').css('height', slickTrackHeight + 'px');
      });
})
