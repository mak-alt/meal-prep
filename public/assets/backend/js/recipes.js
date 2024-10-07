$(function () {
    $('#image').on('change', function () {
        let $this = $(this);

        if (typeof $this.prop('files')[0] !== 'undefined') {
            if ($this.prop('files')[0].type.split('/')[0] === 'image') {
                let reader = new FileReader();

                reader.onload = function (e) {
                    $('.image_block').find('img').attr('src', e.target.result);
                };
                reader.readAsDataURL($(this).prop('files')[0]);
                image = $this.prop('files')[0];
                $this.next('.custom-file-label').text(image.name);
            } else {
                swal.fire('Error!', 'The file must be an image.', 'error');
                $this.val('');
            }
        }
    });
});
