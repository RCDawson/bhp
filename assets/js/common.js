$(document).ready(function() {
    /*
         * Focus login field onload
         *
        */
    $('form input').first().focus();
    
    $('.manage li').hover(function() {
    	$(this).css('cursor','pointer');
    });
    $('.manage li').click(function() {
    	window.location.href = $('a:first-child',this).attr('href');
    });

    /*
         * Focus login field onload
         *
        */
    $('[class^=cms-msg-]:not(".cms-msg-error")').delay(4000).hide(500, function() {
        $(this).remove();
    });

    /**
	 * [System]
	 *
	 * Toggler
	 *
	 * toggle content area
	 */
    $('.toggle').each(function(){

        var $toggler = $(this);
        var $togglee = $toggler.next();
        var $indicator = $('<span class="icon indicator"/>');

        if( $toggler.hasClass('minimized') ){
            $indicator.text('+');
            $togglee.animate({
                height: 'toggle'
            }, {
                duration: 0,
                queue: false
            });
        }else if( $toggler.hasClass('maximized') ){
            $indicator.text('-');
        }else{
            $indicator.text('-');
            $toggler.addClass('maximized');
        }

        $toggler.prepend($indicator);

        $toggler.click(function(){
            if( $togglee.is(':visible') ){
                $indicator.text('-');
                $toggler.removeClass('maximized').addClass('minimized');
            }else{
                $indicator.text('+');
                $toggler.removeClass('minimized').addClass('maximized');
            }
            $togglee.animate({
                height: 'toggle',
                marginBottom: 'toggle'
            }, {
                duration: 300,
                easing: 'easeInOutQuad',
                queue: false
            });
        }).css({
            cursor: 'pointer'
        });

    });
});