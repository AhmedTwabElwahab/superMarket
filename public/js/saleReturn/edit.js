function CalcTotalRow (NumberRow)
{
    let quantity  = $('#quantity'+ NumberRow);
    let Max_return = $('#Max_return'+ NumberRow);
    let price     = $('#price'   + NumberRow);
    let total     = $('#total'   + NumberRow);

    if (Number(quantity.val()) > Number(Max_return.data('value')))
    {
        alert('لا يمكن ارتجاع هذه الكمية');
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
    let Max_return           = $('input[id=Max_return_id]');
    let quantity             = $('input[id=quantity]');
    let sale_price           = $('input[id=sale_price]');
    let product_unit         = $('input[id=product_unit_id]');
    let barcode              = $('#barcode');
    let token                = $('input[name=_token]').val();
    let product              = $('select[id=product_id]');
    let warehouse            = $('select[name=warehouse]');



    function EmptyFiled()
    {
        Max_return.val('');
        quantity.val('');
        sale_price.val('');
        product_unit.val('');
        barcode.val('');
        barcode.focus();
    }

    function Search()
    {
        let ret = false;
        let barcode_search =  barcode.val().toLowerCase();
        $("#saleReturn tr").filter(function()
        {
            if ($(this).text().toLowerCase().indexOf(barcode_search) > -1)
            {
                let td_Max_return = Number($(this).find('td:nth-of-type(3)').data('value')); //quantity
                let td_Quantity   = Number($(this).find('td:nth-of-type(5)').children().val()); //quantity
                let td_Price      = Number($(this).find('td:nth-of-type(6)').children().val()); //quantity
                let Current       = $(this).find('td:nth-of-type(5)').children();

                Current.val(td_Quantity + Number(quantity.val())); // add new quantity
                if (Current.val() > td_Max_return)
                {
                    alert('لا يمكن ارتجاع هذه الكمية');
                    Current.val(1);
                    ret = true;
                }else
                {
                    $(this).find('td:nth-of-type(7)').children().val(Number(Current.val()) * td_Price); //Total of row
                    TotalBill();
                }
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
                    if (data.stock[0]['sold_quantity'] !== 0)
                    {
                        if (data.product[0]['barcode'][0]['barcode'] !== null)
                        {
                            barcode.val(data.product[0]['barcode'][0]['barcode']);
                        }else {
                            barcode.val(null);
                        }

                        Max_return.val(data.stock[0]['sold_quantity']);
                        quantity.val(1);
                        sale_price.val(data.product[0]['sale_price']);
                        product_unit.val(data.product[0]['unit']['name']);
                    }else{
                        alert('لايمكن عمل مرتجع لهذا الصنف!!');
                    }
                }
            },
            type: 'POST'
        });
    });


    $(document).on('click','.btn-add',function ()
    {

        if (barcode.val() === '' || product.val() === '' || sale_price.val() === '' || quantity.val() === '')
        {
            return 0;
        }

        if (quantity.val() > Max_return.val())
        {
            return 0;
        }

        if(Search() === true)
        {
            return 0;
        }


        let n = $( "tr" ).length;
        $('#saleReturn').find('tbody').append(
            "<tr><td><input type='hidden' name='barcode_new_[]' value='" + barcode.val() + "'  readonly>"+barcode.val()+"</td>"+
            "<td><input type='hidden' name='product_id_new_[]' value='" + product.val() + "'  readonly>"+product.find('option:selected').text()+"</td>"+
            "<td id='Max_return"+ n +"' data-value='" + Max_return.val() +"'>" + Max_return.val() +"</td>\n" +
            "<td>" + product_unit.val() +"</td>\n" +
            "<td><input class='input-hide' min='0' id='quantity"+ n +"' onchange='CalcTotalRow("+n+")' style=\"width: 100px;-moz-appearance: textfield;\" type=\"number\" value='" + quantity.val() + "' name=\"quantity_new_[] \"></td>\n" +
            "<td><input class='input-hide' min='0' id='price"+ n +"' onchange='CalcTotalRow("+n+")' style=\"width: 100px;-moz-appearance: textfield;\" type=\"number\" value='"    + sale_price.val() + "' name=\"sale_price_new_[] \"></td>\n" +
            "<td><input  type='number' class='total_row' id='total"+ n +"' name='total_row_new[]' value='"+ sale_price.val()*quantity.val() +"' style=\"width: 100px;-moz-appearance: textfield;\" readonly>"+"</td>"+
            "<td><button  id='remove_row' type=\"button\"  style=\"color: red\" class='btn p-0'><i class='fa fa-trash'></i></button></td></tr>"
        );

        product.val('NULL');
        CalcTotalRow(n);
        EmptyFiled();
    });

    $('#saleReturn').on('click','tbody tr td button#remove_row',function ()
    {
        $(this).parents('tr').remove();
        TotalBill();
    });

});
