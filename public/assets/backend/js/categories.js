$(function () {

    $('#thumb').on('change', function (){
        let length = $(this).prop('files').length;
        $('.thumb-label').empty();
        if( length > 0){
            let name = '';
            let $files = $(this).prop('files');
            $.each($files, function (index,item) {
                if (index === length-1){
                    name += item.name;
                }
                else{
                    name += item.name + ', ';
                }
            });
            $('.thumb-label').append(name);
        }
    });

});
