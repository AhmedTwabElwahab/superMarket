
$(document).ready(function() {
    let button      = $('#asideToggle');
    let aside       = $('.aside');
    let topNav      = $('.top-nav');
    let mainContant = $('.main-content');


    button.on('click',function ()
    {
        if (aside.hasClass('active'))
        {
            aside.removeClass('active').addClass('in-active');
            mainContant.removeClass('in-active').addClass('active');
            topNav.addClass('w-100');
        }
        else
        {
            aside.removeClass('in-active').addClass('active');
            mainContant.removeClass('active').addClass('in-active');
            topNav.removeClass('w-100');
        }
    });


    // $('li.nav-item').click(function ()
    // {
    //     $('a[class=nav-link]').each(function()
    //     {
    //         $(this).removeClass('active');
    //     });
    //     $(this).addClass('active');
    // });
});



