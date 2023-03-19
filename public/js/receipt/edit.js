$(document).ready(function()
{
    let accountType           = $('select[id=account_type_id]');
    let account               = $('select[id=account_id]');
    let token                 = $('input[name=_token]').val();

    accountType.on('change',function()
    {
        $.ajax({
            url: '/superMarket/public/getAccount',
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
                    account.removeAttr('disabled');
                    account.find('option').remove();
                    $.each(data,function (index, value)
                    {
                        account.append(new Option(data[index].name, value.id));
                    });
                }
            },
            type: 'POST'
        });
    });

});

