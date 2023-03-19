function CalcTotalRow(NumberRow)
{
    let quantity  = $('#quantity'+ NumberRow);
    let available = $('#available'+ NumberRow);
    let price     = $('#price'   + NumberRow);
    let total     = $('#total'   + NumberRow);

    if (Number(quantity.val()) > Number(available.data('value')))
    {
        alert('لا يوجد لديك رصيد كافى');
        EmptyFiled();
        quantity.val(1);

    }

    total.val(Number( quantity.val() ) * Number( price.val() ));
    TotalBill();
}
function TotalBill()
{
    let total            = 0;
    let amount_required  = $('input[id=amount_required]')
    let amount_paid      = $('input[id=amount_paid]')
    let discount         = $('input[id=discount]')
    let amount_          = $('input[id=amount_]')


    $('*[class*=total_row]').each(function()
    {
        total += Number($(this).val());
    });

    amount_required.val(total); //before discount
    amount_.val(Number(amount_required.val()) - (Number(discount.val()) + Number(amount_paid.val())));//after discount
}



$(document).ready(function()
{
    CalcTotalRow();
    let available_quantity   = $('input[id=available_quantity]');
    let quantity             = $('input[id=quantity]');
    let product_price        = $('input[id=product_price]');
    let sale_price           = $('input[id=sale_price]');
    let product_unit         = $('input[id=product_unit_id]');
    let barcode              = $('#barcode');
    let token                = $('input[name=_token]').val();
    let product              = $('select[id=product_id]');
    let warehouse            = $('select[name=warehouse]');
    let supplier             = $('select[id=supplier_id_input]');
    let Supplier_balacnce    = $('span[id=Supplier_balacnce]');

    let discount             = $('#discount');

    function EmptyFiled()
    {
        available_quantity.val('');
        quantity.val('');
        product_price.val('');
        sale_price.val('');
        product_unit.val('');
        barcode.val('');
        available_quantity.focus();
    }

    function Search()
    {
        let ret = false;
        let barcode_search =  barcode.val().toLowerCase();
        $("#saleInvoices tr").filter(function()
        {
            if ($(this).text().toLowerCase().indexOf(barcode_search) > -1)
            {
                let td_Quantity = Number($(this).find('td:nth-of-type(5)').children().val()); //quantity
                let td_Price    = Number($(this).find('td:nth-of-type(6)').children().val()); //quantity
                let Current     = $(this).find('td:nth-of-type(5)').children();

                Current.val(td_Quantity + Number(quantity.val())); // add new quantity
                $(this).find('td:nth-of-type(7)').children().val(Number(Current.val()) * td_Price); //Total of row
                TotalBill();
                EmptyFiled();
                ret = true;
            }
            return ret;
        });
        return ret;
    }

    product.on('change',function ()
    {
        $.ajax({
            url: 'http://localhost/superMarket/public/getProduct',
            data:{warehouse_id:warehouse.val(),
                barcode:barcode.val(),
                  _token:token,
                  product_id:$(this).val()},
            error: function() {
                console.log('error');
            },
            success: function(data)
            {
                if (data !== null)
                {
                    if (data.product[0]['barcode'][0]['barcode'] !== null)
                    {
                        barcode.val(data.product[0]['barcode'][0]['barcode']);
                    }else {
                        barcode.val(null);
                    }

                    available_quantity.val(data.stock[0]['available']);
                    quantity.val(1);
                    product_price.val(data.product[0]['purchase_price']);
                    sale_price.val(data.product[0]['sale_price'])
                    product_unit.val(data.product[0]['unit']['name']);
                }
            },
            type: 'POST'
        });
    });

    discount.on('change',function ()
    {
        TotalBill();
    });

    supplier.on('change',function ()
    {
        let Debit   = Number($(this).find(":selected").data('accountd'));
        let Credit  = Number($(this).find(":selected").data('accountc'));

        if (Credit < Debit)
        {
            Supplier_balacnce.text('مـدين: '+ Debit);
            Supplier_balacnce.addClass('badge_d');
        }
        else
        {
            Supplier_balacnce.text('دائـن: ' + Credit);
            Supplier_balacnce.addClass('badge_c');
        }
    });

    $(document).on('click','.btn-add',function ()
    {

        if (barcode.val() === '' || product.val() === '' || product_price.val() === '' || quantity.val() === '')
        {
            return 0;
        }

        if (Search() === true)
        {
            return 0;
        }


        let n = $( "tr" ).length;
        $('#saleInvoices').find('tbody').append(
            "<tr><td><input type='hidden' name='barcode_new_[]' value='" + barcode.val() + "'  readonly>"+barcode.val()+"</td>"+
            "<td><input type='hidden' name='product_id_new_[]' value='" + product.val() + "'  readonly>"+product.find('option:selected').text()+"</td>"+
            "<td><input class='input-hide' step='0.01' name='sale_price_new_[]' style=\"width: 100px;-moz-appearance: textfield;\" value='" + sale_price.val() + "'></td>"+
            "<td>" + product_unit.val() +"</td>\n" +
            "<td><input class='input-hide' min='0' step='0.01' id='quantity"+ n +"' onchange='CalcTotalRow("+n+")' style=\"width: 100px;-moz-appearance: textfield;\" type=\"number\" value='" + quantity.val() + "' name=\"quantity_new_[] \"></td>\n" +
            "<td><input class='input-hide' min='0' step='0.01' id='price"+ n +"' onchange='CalcTotalRow("+n+")' style=\"width: 100px;-moz-appearance: textfield;\" type=\"number\" value='"    + product_price.val() + "' name=\"purchase_price_new_[] \"></td>\n" +
            "<td><input  type='number' class='total_row' id='total"+ n +"' name='total_row_new[]' value='"+ product_price.val()*quantity.val() +"' style=\"width: 100px;-moz-appearance: textfield;\" readonly>"+"</td>"+
            "<td><button  id='remove_row' type=\"button\"  style=\"color: red\" class='btn p-0'><i class='fa fa-trash'></i></button></td></tr>"
        );

        CalcTotalRow(n);
        EmptyFiled();
    });

    $('#saleInvoices').on('click','tbody tr td button#remove_row',function ()
    {
        $(this).parents('tr').remove();
        TotalBill();
    });

});
