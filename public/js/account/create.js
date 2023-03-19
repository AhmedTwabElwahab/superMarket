$(document).ready(function()
{
    let accountType           = $('select[id=account_type_id]');
    let main_account          = $('select[id=main_account_id]');
    let sub_account_id        = $('select[id=sub_account_id]');
    let token                 = $('input[name=_token]').val();

    accountType.on('change',function()
    {
        $.ajax({
            url: '/superMarket/public/getMainAccount',
            data:{
                _token:token,
                type:$(this).val()
            },
            error: function()
            {
                console.log($(this).val() + 'error');
            },
            success: function(data)
            {
                if (data !== null)
                {
                    main_account.removeAttr('disabled');
                    main_account.find('option').remove();
                    $.each(data,function (index, value)
                    {
                        main_account.append(new Option(data[index].name, value.id));
                    });
                    sub_account_id.val('NULL');
                    sub_account_id.attr('disabled','disabled');
                    $('.input-account-name').css('display','none');
                }
            },
            type: 'POST'
        });
    });

    main_account.on('change',function()
    {
        $.ajax({
            url: '/superMarket/public/getSubAccount',
            data:{
                _token:token,
                main_account_id:$(this).val()
            },
            error: function()
            {
                console.log($(this).val() + 'error');
            },
            success: function(data)
            {
                if (data !== null)
                {
                    sub_account_id.removeAttr('disabled');
                    sub_account_id.find('option').remove();
                    if (data.length === 1)
                    {
                        sub_account_id.append(new Option("---", ""));
                    }
                    $.each(data,function (index, value)
                    {
                        sub_account_id.append(new Option(data[index].name, value.id));
                    });
                    $('.input-account-name').css('display','none');
                }
            },
            type: 'POST'
        });
    });

    sub_account_id.on('change',function()
    {
        $.ajax({
            url: 'http://localhost/superMarket/public/getAccount',
            data:{
                _token:token,
                type:$(this).val()
            },
            error: function()
            {
                console.log($(this).val() + 'error');
            },
            success: function(data)
            {
                if (data !== null)
                {
                    $('#DataTable tbody').find('tr').remove();
                    $.each(data,function (index, value)
                    {
                        $('#DataTable tbody').append(
                            '<tr>' +
                            '<td>'+ value.id +'</td>' +
                            '<td>'+ value.name +'</td>' +
                            '<td></td>' +
                            '</tr>'
                        );
                    });
                    $('.input-account-name').css('display','');
                }
            },
            type: 'POST'
        });
    });


});

