if(typeof console=='undefined')console={log:function(){}};
(function($) {
    if($('.posts').length > 0) {
        var pageSize = parseInt($('.posts').data('pagesize'), 10);
        var totalPages = Math.ceil(parseInt($('.posts').data('num-posts'), 10) / 10);

        console.log('pageSize=' + pageSize);
        console.log('totalPages=' + totalPages);

        $('#pagination').twbsPagination( {
            totalPages: totalPages,
            visiblePages: 10,
            onPageClick: function(event, page) {
                var id = '#page' + page;

                //Check to see if we've already loaded the content for this page
                if($(id).length <= 0) {
                    //We haven't loaded this page before so
                    //we'll do a call to the tumblr api to get the content
                    var offset = ( (page-1) * 10) + 1;
                    var url = '/via/posts';
                    $.get(url, { offset: offset }, function(data, stat, xhr) {
                        console.log(data);
                        //Once we have the content, we'll create
                        //a hidden div containing the html
                    });
                }else {
                    //We've already loaded this page so we
                    //can just drop the html in
                    $('.posts').html( $(id).html());
                }

                console.log('Page ' + page + ', offset ' + offset);
                console.log(url);
            }
        });
    }
})(jQuery);
