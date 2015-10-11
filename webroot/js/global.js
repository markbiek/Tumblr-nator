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
                var offset = ( (page-1) * 10) + 1;
                console.log('Page ' + page + ', offset ' + offset);
            }
        });
    }
})(jQuery);
