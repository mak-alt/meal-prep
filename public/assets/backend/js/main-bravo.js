var $ = jQuery.noConflict();

$(document).ready(function () {
    $('.select2').select2();  
    $(".btn-edit").click(function(e){
        e.preventDefault();
        $(this).closest("tr").find(".editing").addClass("active");
        $(this).closest("tr").find("span").css("display", "none");
    });
    $(".btn-save").click(function(e){
        e.preventDefault();
        $(this).closest("tr").find(".editing").removeClass("active");
        $(this).closest("tr").find("span").css("display", "block");
    });
    $("#check_all").click(function () {
        if (!$("#check_all").is(":checked"))
            $(".module__check input").removeAttr("checked");
        else
            $(".module__check input").attr("checked","checked");
    });
});
