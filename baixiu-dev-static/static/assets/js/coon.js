

require.config({
    paths:{
        "jquery": "/static/assets/vendors/jquery/jquery",
        "template": "/static/assets/vendors/art-template/template-web",
        "pagination": "/static/assets/vendors/twbs-pagination/jquery.twbsPagination",
        "bootstrap": "/static/assets/vendors/bootstrap/js/bootstrap"
    },
    shim: {
        "pagination": {
            deps: ["jquery"]
        },
        "bootstrap": {
            deps: ["jquery"]
        }
    },
});

require(["jquery", "template", "pagination", "bootstrap"], function ($, template, pagination, bootstrap) {
    $(function () {
        var currentPage = 1;
        var pageSize = 20;
        var pageCount;

        getCommentsData();

        function getCommentsData() {
            $.ajax({
                type: "post",
                url: "../api/_getComments.php",
                data: {
                    currentPage: currentPage,
                    pageSize: pageSize
                },
                success: function (response) {
                    if (response.code == 1) {
                        pageCount = response.pageCount;
                        var html = template("template", response.data);
                        $("tbody").html(html);

                        $('.pagination').twbsPagination({
                            totalPages: pageCount,
                            visiblePages: 11,
                            onPageClick: function (event, page) {
                                currentPage = page;
                                getCommentsData();
                            }
                        });
                    };
                }
            })
        };
    })
})