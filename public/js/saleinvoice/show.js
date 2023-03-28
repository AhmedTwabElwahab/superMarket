function printableDiv(printableAreaDivId)
{
    let printContents    = document.getElementById(printableAreaDivId).innerHTML;
    let originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}

$(document).ready(function()
{

});
