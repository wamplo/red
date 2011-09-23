(function ($) {
  $.fn.boastful = function(options){
    var output = $(this)
    var defaults = {
                      location: 'http://github.com',
                      empty_message: 'No one\'s mentioned this page on Twitter yet. '+
                                       '<a href="http://twitter.com?status='+ location.href +'">'
                                       +'You could be the first</a>.',
                      limit: 10
                   }
    options = $.extend({}, defaults, options)

    function format_tweetback(tweetback) {
      formatted  =  ''
      formatted +=  '<div class="comments">'
      formatted +=    '<li>'
      formatted +=      '<a class="u" href="'+tweetback.permalink_url+'">'
      formatted +=        '<span id="boastful_username">'+tweetback.author.url.split('/').pop()+'</span></a> says '
      formatted +=        '<span id="boastful_comment">'+tweetback.content+'</span>'
      formatted +=    '</li>'
      formatted +=  '</div>'
      return formatted
    }

    var parse_request = function(data){
      var author_urls = []
      if(data.response.list.length > 0) {

        output.append('<h4 style="text-align:center">Latest twitter comments</h4>')
        $.each(data.response.list, function(i,tweetback){
          if($.inArray(tweetback.author.url,author_urls) > -1) {
            return true
          }
          author_urls.push(tweetback.author.url)
          output.append(format_tweetback(tweetback))
        })
        $('.boastful').mouseover(function(){ $(this).children('.boastful_tweet, .boastful_pointer').show() })
        $('.boastful').mousemove(function(kmouse){
          $(this).children('.boastful_tweet').css({
            left:$(this).position().left-105,
            top:$(this).position().top+25
          })
          $(this).children('.boastful_pointer').css({
            left:$(this).position().left+18,
            top:$(this).position().top+15
          })
        })
        $('.boastful').mouseout(function(){ $(this).children('.boastful_tweet, .boastful_pointer').hide() })
      } else {
        output.append(options.empty_message)
      }
    }

    $.ajax({
      url:'http://otter.topsy.com/trackbacks.js',
      data:
        {
          url: options.location,
          perpage: options.limit
        },
      success:parse_request,
      dataType:'jsonp'}
    )

    return this
  }
})(jQuery)