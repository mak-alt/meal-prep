$(function () {
    let pdf_export = false;
    let today = new Date();
    let weekAgo = new Date();
    weekAgo.setDate(weekAgo.getDate() - 7);

    if (window.location.href.includes('?')){
        $('#clear-filters').removeClass('btn-gray').addClass('btn-danger');
        $('#export').attr('href', $('#export').attr('href')+window.location.search);
        $('#pdf-export').attr('href', $('#pdf-export').attr('href')+window.location.search);
    }

    $('#order-date-picker').daterangepicker();
    $('#delivery-date-picker').daterangepicker();
    $('#pdf-export').daterangepicker({
        startDate : weekAgo,
        endDate : today,
        opens : 'left',
    });
    $('#export').daterangepicker({
        startDate : weekAgo,
        endDate : today,
        opens : 'left',
    });

    $('#search-field').on('change', function () {
        if (window.location.href.includes('?search')){
            window.location.href = window.location.href.replace( new RegExp('\\?search=.*?(?=&|$)','gm'), '?search='
                + $(this).val());
        } else if(window.location.href.includes('&search')){
            window.location.href = window.location.href.replace( new RegExp('&search=.*?(?=&|$)','gm'), '&search='
                + $(this).val());
        }else if(window.location.href.includes('?')){
            window.location.href = window.location.href + '&search=' + $(this).val();
        } else{
            window.location.href = window.location.href + '?search=' + $(this).val();
        }
    });

    $('#order-date-picker').on('apply.daterangepicker', function (ev, picker) {
        if (window.location.href.includes('?orderDate')){
            window.location.href = window.location.href.replace( new RegExp('\\?orderDate=.*?(?=&|$)','gm'), '?orderDate='
                + picker.startDate.format('YYYY-MM-DD') +
                ':' + picker.endDate.format('YYYY-MM-DD'));
        } else if(window.location.href.includes('&orderDate')){
            window.location.href = window.location.href.replace( new RegExp('&orderDate=.*?(?=&|$)','gm'), '&orderDate='
                + picker.startDate.format('YYYY-MM-DD') +
                ':' + picker.endDate.format('YYYY-MM-DD'));
        }else if(window.location.href.includes('?')){
            window.location.href = window.location.href + '&orderDate=' + picker.startDate.format('YYYY-MM-DD') +
                ':' + picker.endDate.format('YYYY-MM-DD');
        } else{
            window.location.href = window.location.href + '?orderDate=' + picker.startDate.format('YYYY-MM-DD') +
                ':' + picker.endDate.format('YYYY-MM-DD');
        }
    });

    $('#delivery-date-picker').on('apply.daterangepicker', function (ev, picker) {
        if (window.location.href.includes('?deliveryDate')){
            window.location.href = window.location.href.replace( new RegExp('\\?deliveryDate=.*?(?=&|$)','gm'), '?deliveryDate='
                + picker.startDate.format('YYYY-MM-DD') +
                ':' + picker.endDate.format('YYYY-MM-DD'));
        } else if(window.location.href.includes('&deliveryDate')){
            window.location.href = window.location.href.replace( new RegExp('&deliveryDate=.*?(?=&|$)','gm'), '&deliveryDate='
                + picker.startDate.format('YYYY-MM-DD') +
                ':' + picker.endDate.format('YYYY-MM-DD'));
        } else if(window.location.href.includes('?')){
            window.location.href = window.location.href + '&deliveryDate=' + picker.startDate.format('YYYY-MM-DD') +
                ':' + picker.endDate.format('YYYY-MM-DD');
        } else{
            window.location.href = window.location.href + '?deliveryDate=' + picker.startDate.format('YYYY-MM-DD') +
                ':' + picker.endDate.format('YYYY-MM-DD');
        }
    });

    $('#clear-filters').on('click', function (e) {
        e.preventDefault();

        if (window.location.href.includes('?')){
            window.location.href = window.location.href.replace(window.location.search,'');
        }
    });

    if($("#empty_row").length !== 0) {
        $('#export, #pdf-export').addClass('btn-inactive');
    } else {
        $('#export, #pdf-export').removeClass('btn-inactive');
    }

    $('#pdf-export, #export').on('apply.daterangepicker', function (ev, picker) {
        let link;
        link = $(this).data('href');

        if (link.includes('?deliveryDate')){
            link = link.replace( new RegExp('\\?deliveryDate=.*?(?=&|$)','gm'), '?deliveryDate='
                + picker.startDate.format('YYYY-MM-DD') +
                ':' + picker.endDate.format('YYYY-MM-DD'));
        } else if(link.includes('&deliveryDate')){
            link = link.replace( new RegExp('&deliveryDate=.*?(?=&|$)','gm'), '&deliveryDate='
                + picker.startDate.format('YYYY-MM-DD') +
                ':' + picker.endDate.format('YYYY-MM-DD'));
        }else if(link.includes('?')){
            link = link + '&deliveryDate=' + picker.startDate.format('YYYY-MM-DD') +
                ':' + picker.endDate.format('YYYY-MM-DD');
        } else{
            link = link + '?deliveryDate=' + picker.startDate.format('YYYY-MM-DD') +
                ':' + picker.endDate.format('YYYY-MM-DD');
        }

        $.ajax({
            url : link,
            type : 'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success : function (response) {
                if (response.success){
                    window.location.href=link;
                }
                else{
                    swal.fire('Warning!', response.message, 'warning');
                }
            },
        });
    });

    $('#last-p').on('click', function (e) {
        e.preventDefault();
        let $this = $(this);

        $('.text-danger.days').text('');
        if ($('#days').val().length === 0){
            $('.text-danger.days').text('You have to input the amount of days.');
            return false;
        }
        $.ajax({
            url : linkChangeDay($this.attr('href'), $('#days').val()),
            type : 'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success : function (response) {
                if (response.success){
                    window.location.href=linkChangeDay($this.attr('href'), $('#days').val());
                }
                else{
                    swal.fire('Warning!', response.message, 'warning');
                }
            },
        });
    });

    $('#last-e').on('click', function (e) {
        e.preventDefault();
        let $this = $(this);

        $('.text-danger.days-e').text('');
        if ($('#days-e').val().length === 0){
            $('.text-danger.days-e').text('You have to input the amount of days.');
            return false;
        }
        $.ajax({
            url : linkChangeDay($this.attr('href'), $('#days-e').val()),
            type : 'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success : function (response) {
                if (response.success){
                    window.location.href=linkChangeDay($this.attr('href'), $('#days-e').val());
                }
                else{
                    swal.fire('Warning!', response.message, 'warning');
                }
            },
        });
    });

    $('#today-e, #today-p, #all-e, #all-p').on('click', function (e) {
        e.preventDefault();
        let $this = $(this);
        $.ajax({
            url : $this.attr('href'),
            type : 'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success : function (response) {
                if (response.success){
                    window.location.href=$this.attr('href');
                }
                else{
                    swal.fire('Warning!', response.message, 'warning');
                }
            },
        });
    })

    $('#type').on('change', function () {
        let $this = $(this);
        if ($this.val() ==='pickup'){
            $('#today-p').attr('href', linkChangeType($('#today-p').attr('href'), 'pickup'));
            $('#all-p').attr('href', linkChangeType($('#all-p').attr('href'), 'pickup'));
            $('#last-p').attr('href', linkChangeType($('#last-p').attr('href'), 'pickup'));
            $('#pdf-export').data('href', linkChangeType( $('#pdf-export').data('href'), 'pickup'));
        }
        else if ($this.val() ==='delivery'){
            $('#today-p').attr('href', linkChangeType($('#today-p').attr('href'), 'delivery'));
            $('#all-p').attr('href', linkChangeType($('#all-p').attr('href'), 'delivery'));
            $('#last-p').attr('href', linkChangeType($('#last-p').attr('href'), 'delivery'));
            $('#pdf-export').data('href', linkChangeType( $('#pdf-export').data('href'), 'delivery'));
        }
        else if ($this.val() ==='all'){
            $('#today-p').attr('href', linkChangeType($('#today-p').attr('href'), 'delivery', true));
            $('#all-p').attr('href', linkChangeType($('#all-p').attr('href'), 'delivery', true));
            $('#last-p').attr('href', linkChangeType($('#last-p').attr('href'), 'delivery', true));
            $('#pdf-export').data('href', linkChangeType( $('#pdf-export').data('href'), 'delivery', true));
        }

    });

    $('#type-e').on('change', function () {
        let $this = $(this);
        if ($this.val() ==='pickup'){
            $('#today-e').attr('href', linkChangeType($('#today-e').attr('href'), 'pickup'));
            $('#all-e').attr('href', linkChangeType($('#all-e').attr('href'), 'pickup'));
            $('#last-e').attr('href', linkChangeType($('#last-e').attr('href'), 'pickup'));
            $('#export').data('href', linkChangeType( $('#export').data('href'), 'pickup'));
        }
        else if ($this.val() ==='delivery'){
            $('#today-e').attr('href', linkChangeType($('#today-e').attr('href'), 'delivery'));
            $('#all-e').attr('href', linkChangeType($('#all-e').attr('href'), 'delivery'));
            $('#last-e').attr('href', linkChangeType($('#last-e').attr('href'), 'delivery'));
            $('#export').data('href', linkChangeType( $('#export').data('href'), 'delivery'));
        }
        else if ($this.val() ==='all'){
            $('#today-e').attr('href', linkChangeType($('#today-e').attr('href'), 'delivery', true));
            $('#all-e').attr('href', linkChangeType($('#all-e').attr('href'), 'delivery', true));
            $('#last-e').attr('href', linkChangeType($('#last-e').attr('href'), 'delivery', true));
            $('#export').data('href', linkChangeType( $('#export').data('href'), 'delivery', true));
        }
    });

    function linkChangeType(link,type, remove = false) {
        if (remove){
            if (link.includes('?type')){
                link = link.replace( new RegExp('\\?type=.*?(?=&|$)','gm'), '');
            } else if(link.includes('&type')){
                link = link.replace( new RegExp('&type=.*?(?=&|$)','gm'), '');
            }
        }else{
            if (link.includes('?type')){
                link = link.replace( new RegExp('\\?type=.*?(?=&|$)','gm'), '?type=' + type);
            } else if(link.includes('&type')){
                link = link.replace( new RegExp('&type=.*?(?=&|$)','gm'), '&type=' + type);
            }else if(link.includes('?')){
                link = link + '&type=' + type;
            } else{
                link = link + '?type=' + type;
            }
        }
        return link;
    }

    function linkChangeDay(link,date) {
        if (link.includes('?date')){
            link = link.replace( new RegExp('\\?date=.*?(?=&|$)','gm'), '?date=' + date);
        } else if(link.includes('&date')){
            link = link.replace( new RegExp('&date=.*?(?=&|$)','gm'), '&date=' + date);
        }else if(link.includes('?')){
            link = link + '&date=' + date;
        } else{
            link = link + '?date=' + date;
        }
        return link;
    }

});
