/*
 * @author     Andrei Eftimie
 * @email      k3liutZu@gmail.com
 * @copyright  (c) Andrei Eftimie
 * @web        http://www.eftimie.ro
 *
 *
 * If you want persistance, you should use the jquery.cookie.js plugin
 *
 * You should call this plugin on the element you have defined the lowest font-size denominator.
 * Usually the body or the html, sometimes on a #content or #wrapper.
 *
 * You site must be built using em's, or this plugin wont work. It only changes the font-size of 1 element.
 * If the other elements are not related to that element (by using em's), no font-resize magic will happen
 *
 * Calling
 * -------
 * $('body').textResize({
 *              plus:           '.increase-text-size',          //Increase text size button
 *              minus:  '.decrease-text-size',          //Decrease text size button
 *              reset:  '.default-text-size',           //Reset text size button {optionally}
 *              pace:   1,                                      //How big the textsize jump will be (default 1px)
 *              original:       16,                                     //The original value, to where .reset updates the text-size
 *              limit:          [10,24]                         //Lower and High limit values. It won't let the text go beyond these
 * });
 *
 */

(function($){
    $.fn.textResize = function(options) {

        var defaults = {
            plus:  '.increase-text-size',
            minus: '.decrease-text-size',
            reset: '.default-text-size',
            pace:  1,
            original: 16,
            limit: [10,24] //lower and higher limit
        };

        var options = $.extend(defaults, options);

        return this.each(function() {

            var body                         = $(this);
            var plus                         = options.plus;
            var minus                        = options.minus;
            var reset                        = options.reset;
            var pace                         = options.pace;
            var textSize             = 16;
            var original             = options.original;
            var limit                        = options.limit;

            //we read the cookie
            var cookie = $.cookie('text-size');

            //we update the document with the cookie value (persistance)
            if (cookie) {
                update(cookie);
            }

            //Initialize the size variable
            init();

            //Apply events to the buttons
            $(plus).click(function(){
                if (textSize < limit[1] ) {
                    newText = textSize+pace;
                    if (newText > limit[1]) newText = limit[1];
                    update(newText);
                }
                init();
                return false;
            });

            $(minus).click(function(){
                if (textSize > limit[0] ) {
                    newText = textSize-pace;
                    if (newText < limit[0]) newText = limit[0];
                    update(newText);
                }
                init();
                return false;
            });

            $(reset).click(function(){
                update(original);
                init();
                return false;
            });

            function init(){
                //Current font-size
                textSize = body.css('font-size');
                //Weird thing, IE7 is reporting an intial font-size of 1037px.
                //Must investigate further. We currently hack it here
                if (textSize == undefined || textSize == '1037px') textSize = original+'px';
                textSize = parseInt(textSize.substring(0,textSize.length-2));

                //Write cookie
                $.cookie('text-size', textSize);
            }

            function update(value){
                body.css('font-size',value+'px');
            }
        })

    };
})(jQuery);