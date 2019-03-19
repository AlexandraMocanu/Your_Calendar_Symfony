(function() {
  var tooltip = $('<div/>').qtip({
    id: 'calendar-holder',
    prerender: true,
    content: {
      text: ' ',
      title: {
        button: true
      }
    },
    position: {
      my: 'bottom center',
      at: 'top center',
      target: 'mouse',
      viewport: $('#calendar-holder'),
      adjust: {
        mouse: false,
        scroll: false
      }
    },
    show: false,
    hide: false,
    style: 'qtip-light'
  }).qtip('api');

	$('#calendar-holder').fullCalendar({

    header: {
        left: 'prev, next',
        center: 'title',
        right: 'month, basicWeek, basicDay,'
    },
    lazyFetching: true,
    timeFormat: {
        agenda: 'h:mmt',
        '': 'h:mmt'
    },

        eventSources: [
            {
                url: '/full-calendar/load',
                type: 'POST',
                data: {
                    episode_title: 'episode_title',
                    premiere_countries: 'premiere_countries',
                    tvshow_name: 'tvshow_name',
                    movie_name: 'movie_name',
                    lk: 'lk'
                },
                error: function () {}
            }
        ],

        eventClick: function(data, event, view) {
          var content = '<h3>No data.</h3>';
          if(data.episode_title){
            var content = '<p><a href="'+data.lk+'"><b>'+data.tvshow_name+'</b></a></p><b>Title:</b> <p>'+data.episode_title+'</p>';
          }else{
            if(data.premiere_countries){
              var content = '<p><a href="'+data.lk+'"><b>'+data.movie_name+'</b></a></p><b>Countries:</b> <p>'+data.premiere_countries+'</p>';
            }
          }

          tooltip.set({
            'content.text': content
          })
          .reposition(event).show(event);
        },

        dayClick: function() { tooltip.hide() },
        eventResizeStart: function() { tooltip.hide() },
        eventDragStart: function() { tooltip.hide() },
        viewDisplay: function() { tooltip.hide() },



	});

}());
