if(typeof console=='undefined')console={log:function(){}};
(function($) {
    if($('.posts').length > 0) {
        $('#pagination').twbsPagination( {
            totalPages: parseInt($('.posts').data('num-posts'), 10),
            visiblePages: 10,
            onPageClick: function(event, page) {

            }
        });
    }
})(jQuery);
