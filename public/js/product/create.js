$(document).ready(function()
{
    let barcode               = $("input[id=barcode_input]");
    let btn_add               = $('a[id=add_barcode]');

    btn_add.on('click',function ()
    {
        if (barcode === '' || Search() === true)
        {
            return null;
        }
        $('#barcodeTable tbody').append(
            '<tr>' +
            '<td>'+ barcode.val() +'<input  type=\'hidden\' class=\'total_row\' id=\'total"+ n +"\' value=\"'+ barcode.val() +'\" name=\'barcode[]\'></td>' +
            '<td><button  id=\'remove_row\' type=\"button\"  style=\"color: red\" class=\'btn p-0\'><i class=\'fa fa-trash\'></i></button></td>' +
            '</tr>'
        );
        barcode.val('').focus();
    });

    $('#barcodeTable').on('click','tbody tr td button#remove_row',function ()
    {
        $(this).parents('tr').remove();
    });

    function Search()
    {
        let ret = false;
        let barcode_search =  barcode.val().toLowerCase();
        $("#barcodeTable tr").filter(function()
        {
            if ($(this).text().toLowerCase().indexOf(barcode_search) > -1)
            {
                ret = true;
            }
            return ret;
        });
        return ret;
    }
});

