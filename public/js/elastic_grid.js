/*
* debouncedresize: special jQuery event that happens once after a window resize
*
* latest version and complete README available on Github:
* https://github.com/louisremi/jquery-smartresize/blob/master/jquery.debouncedresize.js
*
* Copyright 2011 @louis_remi
* Licensed under the MIT license.
*/
/*
* debouncedresize: special jQuery event that happens once after a window resize
*
* latest version and complete README available on Github:
* https://github.com/louisremi/jquery-smartresize/blob/master/jquery.debouncedresize.js
*
* Copyright 2011 @louis_remi
* Licensed under the MIT license.
*/
var $event = jQuery.event,
$special,
resizeTimeout;

$special = $event.special.debouncedresize = {
    setup: function() {
        jQuery( this ).on( "resize", $special.handler );
    },
    teardown: function() {
        jQuery( this ).off( "resize", $special.handler );
    },
    handler: function( event, execAsap ) {
        // Save the context
        var context = this,
            args = arguments,
            dispatch = function() {
                // set correct event type
                event.type = "debouncedresize";
                $event.dispatch.apply( context, args );
            };

        if ( resizeTimeout ) {
            clearTimeout( resizeTimeout );
        }

        execAsap ?
            dispatch() :
            resizeTimeout = setTimeout( dispatch, $special.threshold );
    },
    threshold: 250
};

// ======================= imagesLoaded Plugin ===============================
// https://github.com/desandro/imagesloaded

// jQuery('#my-container').imagesLoaded(myFunction)
// execute a callback when all images have loaded.
// needed because .load() doesn't work on cached images

// callback function gets image collection as argument
//  this is the container

// original: MIT license. Paul Irish. 2010.
// contributors: Oren Solomianik, David DeSandro, Yiannis Chatzikonstantinou

// blank image data-uri bypasses webkit log warning (thx doug jones)
var BLANK = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';

jQuery.fn.imagesLoaded = function( callback ) {
    var $this = this,
        deferred = jQuery.isFunction(jQuery.Deferred) ? jQuery.Deferred() : 0,
        hasNotify = jQuery.isFunction(deferred.notify),
        $images = $this.find('img').add( $this.filter('img') ),
        loaded = [],
        proper = [],
        broken = [];

    // Register deferred callbacks
    if (jQuery.isPlainObject(callback)) {
        jQuery.each(callback, function (key, value) {
            if (key === 'callback') {
                callback = value;
            } else if (deferred) {
                deferred[key](value);
            }
        });
    }

    function doneLoading() {
        var $proper = jQuery(proper),
            $broken = jQuery(broken);

        if ( deferred ) {
            if ( broken.length ) {
                deferred.reject( $images, $proper, $broken );
            } else {
                deferred.resolve( $images );
            }
        }

        if ( jQuery.isFunction( callback ) ) {
            callback.call( $this, $images, $proper, $broken );
        }
    }

    function imgLoaded( img, isBroken ) {
        // don't proceed if BLANK image, or image is already loaded
        if ( img.src === BLANK || jQuery.inArray( img, loaded ) !== -1 ) {
            return;
        }

        // store element in loaded images array
        loaded.push( img );

        // keep track of broken and properly loaded images
        if ( isBroken ) {
            broken.push( img );
        } else {
            proper.push( img );
        }

        // cache image and its state for future calls
        jQuery.data( img, 'imagesLoaded', { isBroken: isBroken, src: img.src } );

        // trigger deferred progress method if present
        if ( hasNotify ) {
            deferred.notifyWith( jQuery(img), [ isBroken, $images, jQuery(proper), jQuery(broken) ] );
        }

        // call doneLoading and clean listeners if all images are loaded
        if ( $images.length === loaded.length ){
            setTimeout( doneLoading );
            $images.unbind( '.imagesLoaded' );
        }
    }

    // if no images, trigger immediately
    if ( !$images.length ) {
        doneLoading();
    } else {
        $images.bind( 'load.imagesLoaded error.imagesLoaded', function( event ){
            // trigger imgLoaded
            imgLoaded( event.target, event.type === 'error' );
        }).each( function( i, el ) {
            var src = el.src;

            // find out if this image has been already checked for status
            // if it was, and src has not changed, call imgLoaded on it
            var cached = jQuery.data( el, 'imagesLoaded' );
            if ( cached && cached.src === src ) {
                imgLoaded( el, cached.isBroken );
                return;
            }

            // if complete is true and browser supports natural sizes, try
            // to check for image status manually
            if ( el.complete && el.naturalWidth !== undefined ) {
                imgLoaded( el, el.naturalWidth === 0 || el.naturalHeight === 0 );
                return;
            }

            // cached images don't fire load sometimes, so we reset src, but only when
            // dealing with IE, or image is complete (loaded) and failed manual check
            // webkit hack from http://groups.google.com/group/jquery-dev/browse_thread/thread/eee6ab7b2da50e1f
            if ( el.readyState || el.complete ) {
                el.src = BLANK;
                el.src = src;
            }
        });
    }

    return deferred ? deferred.promise( $this ) : $this;
};

/**
 * jquery elastic_grid
 *
 * Copyright 2013, vukhanhtruong
 * http://www.bonchen.net
 */
jQuery(function() {
    jQuery.elastic_grid = {
        version: '1.0'
    };
    jQuery.fn.elastic_grid = function(config){
        config = jQuery.extend({}, {
            items: null,
            filterEffect: '',
            hoverDirection: true,
            hoverDelay: 0,
            hoverInverse: false,
            expandingHeight: 500,
            expandingSpeed: 300,
            allText: 'All',
            callback: function() {}
        }, config);

        // initial container object
        var container = jQuery(this);
        // number of questions
        var numOfItems = config.items.length;
        if(numOfItems == 0){
            return false;
        }

        //initial filter nav
        container.html('<div class="wagwep-container"><nav id="porfolio-nav" class="clearfix"><ul id="portfolio-filter" class="nav nav-tabs clearfix"></ul></nav></div>');

        //initial items
        var gridContent = "";
        var ulObject = jQuery('<ul id="og-grid" class="og-grid"></ul>');
        for (itemIdx = 0; itemIdx < numOfItems; itemIdx++) {
            if(config.items[itemIdx] != undefined){
                var item = config.items[itemIdx];

                //initial new li
                liObject = jQuery('<li></li>');

                //get tags
                var tags = item.tags;
                console.log(tags);
                strTag = "";
                for (var i = tags.length - 1; i >= 0; i--) {
                    strTag += ","+tags[i];
                };
                strTag = strTag.substring(1);
                liObject.attr('data-tags', strTag);

                //initial a object
                aObject = jQuery('<a></a>');
                aObject.attr('href', 'javascript:;;');

                //initial default photo
                imgObject = jQuery('<img/>');
                imgObject.attr('src', item.thumbnail[0]);
                imgObject.attr('data-largesrc', item.large[0]);


                //initial hover direction
                spanObject = jQuery('<span></span>');
                spanObject.html(item.title);
                figureObject = jQuery('<figure></figure>');
                figureObject.append(spanObject);

                imgObject.appendTo(aObject);
                figureObject.appendTo(aObject);
                aObject.appendTo(liObject);
                liObject.appendTo(ulObject);
            }
        }
        if(config.filterEffect == ''){
            config.filterEffect = 'moveup';
        }
        ulObject.addClass('effect-'+config.filterEffect);
        ulObject.appendTo(container);
/**************************************************************************
* HOVER DIR
***************************************************************************/
        if(config.hoverDirection == true){
            ulObject.find('li').each( function() {
                jQuery(this).hoverdir({
                    hoverDelay : config.hoverDelay,
                    inverse : config.hoverInverse
                });
            } );
        }

/**************************************************************************
* Tags to filter
***************************************************************************/
    var porfolio_filter = container.find('#portfolio-filter');
    var items = ulObject.find('li'),
    itemsByTags = {};
    numOfTag = 0;

    // Looping though all the li items:
    items.each(function(i){
        var elem = jQuery(this),
        tags = elem.data('tags').split(',');

        // Adding a data-id attribute. Required by the Quicksand plugin:
        elem.attr('data-id',i);

        elem.addClass(config.allText.toLowerCase());
        jQuery.each(tags,function(key,value){
            // Removing extra whitespace:
            value = jQuery.trim(value);

            //add class tags to li
            elem.addClass(value.toLowerCase().replace(' ','-'));

            if(!(value in itemsByTags)){
                // Create an empty array to hold this item:
                itemsByTags[value] = [];
                numOfTag++;
            }

            // Each item is added to one array per tag:
            itemsByTags[value].push(elem);
        });

    });

    if(numOfTag > 1){
        // Creating the "Everything" option in the menu:
        createList(config.allText);

        // Looping though the arrays in itemsByTags:
        jQuery.each(itemsByTags,function(k,v){
            createList(k);
        });
    }else{
        porfolio_filter.remove();
    }


    porfolio_filter.find('a').bind('click',function(e){
        //close expanding preview
        $grid.find('li.og-expanded').find('a').trigger('click');
        $grid.find('.og-close').trigger('click');

        $this = jQuery(this);
        $this.css('outline','none');
        porfolio_filter.find('.current').removeClass('current');
        $this.parent().addClass('current');

        var filterVal = $this.text().toLowerCase().replace(' ','-');
        var count  = numOfItems;
        ulObject.find('li').each( function(i, el) {
            classie.remove( el, 'hidden' );
            classie.remove( el, 'animate' );
            if(!--count){
                setTimeout( function() {
                    doAnimateItems(ulObject.find('li'), filterVal);
                }, 1);
            }
        });

        return false;
    });

    function doAnimateItems(objectLi, filterVal){
        objectLi.each(function(i, el) {
            if(classie.has( el, filterVal ) ) {
                classie.toggle( el, 'animate' );
                classie.remove( el, 'hidden' );
            }else{
                classie.add( el, 'hidden' );
                classie.remove( el, 'animate' );
            }
        });
    }

    porfolio_filter.find('li:first').addClass('current');

    function createList(text){
        var filter = text.toLowerCase().replace(' ','-');
        // This is a helper function that takes the
        // text of a menu button and array of li items
        if(text != ''){
            var li = jQuery('<li>');
            var a = jQuery('<a>',{
                html: text,
                'data-filter': '.'+filter,
                href:'#',
                'class':'filter',
            }).appendTo(li);

            li.appendTo(porfolio_filter);
        }
    }
/**************************************************************************
* EXPANDING
***************************************************************************/
        // list of items
        var $grid = ulObject,
            // the items
            $items = $grid.children( 'li' ),
            // current expanded item's index
            current = -1,
            // position (top) of the expanded item
            // used to know if the preview will expand in a different row
            previewPos = -1,
            // extra amount of pixels to scroll the window
            scrollExtra = 0,
            // extra margin when expanded (between preview overlay and the next items)
            marginExpanded = 10,
            $window = jQuery( window ), winsize,
            $body = jQuery( 'html, body' ),
            // transitionend events
            transEndEventNames = {
                'WebkitTransition' : 'webkitTransitionEnd',
                'MozTransition' : 'transitionend',
                'OTransition' : 'oTransitionEnd',
                'msTransition' : 'MSTransitionEnd',
                'transition' : 'transitionend'
            },
            transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
            // support for csstransitions
            support = Modernizr.csstransitions,
            // default settings
            settings = {
                minHeight : config.expandingHeight,
                speed : config.expandingSpeed,
                easing : 'ease'
            };


        // add more items to the grid.
        // the new items need to appended to the grid.
        // after that call Grid.addItems(theItems);
        function addItems( $newitems ) {

            $items = $items.add( $newitems );

            $newitems.each( function() {
                var $item = jQuery( this );
                $item.data( {
                    offsetTop : $item.offset().top,
                    height : $item.height()
                } );
            } );

            initItemsEvents( $newitems );

        }

        // saves the item offset top and height (if saveheight is true)
        function saveItemInfo(saveheight ) {
            $items.each( function() {
                var $item = jQuery( this );
                $item.data( 'offsetTop', $item.offset().top );
                if( saveheight ) {
                    $item.find('img').load(function() {
                        console.log($item.outerHeight(), 305);
                        $item.data( 'height', $item.height());
                    });

                    setTimeout(function(){
                        $item.data( 'height', $item.height());
                    });
                }
            } );
        }

        function initEvents() {

            // when clicking an item, show the preview with the item info and large image.
            // close the item if already expanded.
            // also close if clicking on the item cross
            initItemsEvents( $items );

            // on window resize get the windows size again
            // reset some values..
            $window.on( 'debouncedresize', function() {

                scrollExtra = 0;
                previewPos = -1;
                // save item offset
                saveItemInfo();
                getWinSize();
                var preview = jQuery.data( this, 'preview' );
                if( typeof preview != 'undefined' ) {
                    hidePreview();
                }

            } );

        }

        function initItemsEvents( $items ) {
            $items.on( 'click', 'span.og-close', function() {
                hidePreview();
                return false;
            } ).children( 'a' ).on( 'click', function(e) {
                var $item = jQuery( this ).parent();
                //jQuery(this).addClass('unhoverdir');
                //remove animate class
                $item.removeClass('animate');

                // check if item already opened
                current === $item.index() ? hidePreview(jQuery(this)) : showPreview( $item );
                return false;

            } );
        }

        function getWinSize() {
            winsize = { width : $window.width(), height : $window.height() };
        }

        function showPreview( $item ) {
            hidePreview();

            // console.log('--show--');

            var preview = jQuery.data( this, 'preview' ),
                // item offset top
                position = $item.data( 'offsetTop' );

            scrollExtra = 0;

            // if a preview exists and previewPos is different (different row) from item top then close it
            if( typeof preview != 'undefined' ) {

                // not in the same row
                if( previewPos !== position ) {
                    // if position > previewPos then we need to take te current previews height in consideration when scrolling the window
                    if( position > previewPos ) {
                        scrollExtra = preview.height;
                    }
                    hidePreview();
                }
                // same row
                else {
                    preview.update( $item );
                    return false;
                }

            }

            // update previewPos
            previewPos = position;
            // initialize new preview for the clicked item
            preview = jQuery.data( this, 'preview', new Preview( $item ) );
            // expand preview overlay
            preview.open();

        }

        function hidePreview() {
            //hide pointer
            $items.find('.og-pointer').remove();

            current = -1;
            var preview = jQuery.data( this, 'preview' );

            if(typeof preview == "undefined"){
                //do nothing
            }else{
                preview.close();
            }
            jQuery.removeData( this, 'preview' );
        }

        // the preview obj / overlay
        function Preview( $item ) {
            this.$item = $item;
            this.expandedIdx = this.$item.index();
            this.create();
            this.update();
        }

        Preview.prototype = {
            create : function() {
                // create Preview structure:
                this.$title = jQuery( '<h3></h3>' );
                this.$description = jQuery( '<p></p>' );
                this.$href = jQuery( '<a href="#">Visit website</a>' );
                this.$detailButtonList = jQuery( '<span class="buttons-list"></span>' );
                this.$detailsScroll = jQuery( '<div class="og-details-scroll"></div>' ).append( this.$description );
                this.$details = jQuery( '<div class="og-details"></div>' ).append( this.$title, this.$detailsScroll, this.$detailButtonList );
                this.$loading = jQuery( '<div class="og-loading"></div>' );
                this.$fullimage = jQuery( '<div class="og-fullimg"></div>' ).append( this.$loading );
                this.$closePreview = jQuery( '<span class="og-close"></span>' );
                this.$previewInner = jQuery( '<div class="og-expander-inner"></div>' ).append( this.$closePreview, this.$fullimage, this.$details );
                this.$previewEl = jQuery( '<div class="og-expander"></div>' ).append( this.$previewInner );
                // append preview element to the item
                this.$item.append( jQuery('<div class="og-pointer"></div>') );
                this.$item.append( this.getEl() );

                // set the transitions for the preview and the item
                if( support ) {
                    this.setTransition();
                }
            },
            update : function( $item ) {

                if( $item ) {
                    this.$item = $item;
                }

                // if already expanded remove class "og-expanded" from current item and add it to new item
                if( current !== -1 ) {
                    var $currentItem = $items.eq( current );
                    $currentItem.removeClass( 'og-expanded' );
                    this.$item.addClass( 'og-expanded' );
                    // position the preview correctly
                    this.positionPreview();
                }

                // update current value
                current = this.$item.index();


                // update previews content
                if(typeof config.items[current] === "undefined"){
                    //nothing happen
                }else{
                    eldata = config.items[current];

                    this.$title.html( eldata.title );
                    this.$description.html( eldata.description );
                    //clear current button list
                    this.$detailButtonList.html("");
                    urlList = eldata.button_list;

                    if(urlList.length > 0)
                    {
                        for (i = 0; i < urlList.length; i++)
                        {
                            var ObjA = jQuery('<a></a>');
                            ObjA.addClass('link-button');
                            if(i==0){
                                ObjA.addClass('first');
                            }
                            ObjA.attr("href", urlList[i]['url']);
                            ObjA.attr("target", "_blank");
                            ObjA.html( urlList[i]['title']);
                            this.$detailButtonList.append(ObjA);
                        }
                    }

                   var self = this;

                    // remove the current image in the preview
                    if( typeof self.$largeImg != 'undefined' ) {
                        self.$largeImg.remove();
                    }


                    //relate photo
                    glarge = eldata.large;
                    gthumbs = eldata.thumbnail;
                    if(glarge.length == gthumbs.length && glarge.length > 0){
                        var ObjUl = jQuery('<ul></ul>');
                        $numOfPhoto = gthumbs.length;
                        if($numOfPhoto > 1){
                            for (i = 0; i < $numOfPhoto; i++)
                            {
                                var Objli = jQuery('<li></li>');
                                var ObjA = jQuery('<a href="javascript:;;"></a>');
                                var ObjImg = jQuery('<img/>');

                                ObjImg.addClass('related_photo');
                                if(i==0){
                                    ObjImg.addClass('selected');
                                }
                                ObjImg.attr("src", gthumbs[i]);
                                ObjImg.attr("data-large", glarge[i]);
                                ObjA.append(ObjImg);
                                Objli.append(ObjA);
                                ObjUl.append(Objli);
                            }
                            // ObjUl.addClass("og-grid-small");
                            ObjUl.addClass("elastislide-list");
                            var preloaded = 0;
                            ObjUl.find('img').load(function(){
                                if (++preloaded === $numOfPhoto) {
                                    ObjUl.elastislide();
                                }
                            });
                            var carousel = jQuery('<div class="elastislide-wrapper elastislide-horizontal"></div>');
                            carousel.append(ObjUl).find('.related_photo').bind('click', function(){
                                carousel.find('.selected').removeClass('selected');
                                jQuery(this).addClass('selected');
                                $largePhoto = jQuery(this).data('large');

                                jQuery('<img/>').load(function(){
                                    self.$fullimage.find('img').fadeOut(500, function(){
                                        jQuery(this).fadeIn(500).attr('src', $largePhoto);
                                    })
                                }).attr('src', $largePhoto);
                            });

                            self.$details.append('<div class="infosep"></div>');
                            self.$details.append(carousel);
                        }
                    }else{
                        self.$details.find('.infosep, .og-grid-small').remove();
                    }


                    // preload large image and add it to the preview
                    // for smaller screens we dont display the large image (the media query will hide the fullimage wrapper)
                    if( self.$fullimage.is( ':visible' ) ) {
                        this.$loading.show();
                        jQuery( '<img/>' ).load( function() {
                            var $img = jQuery( this );
                            if( $img.attr( 'src' ) === self.$item.children('a').find('img').data( 'largesrc' ) ) {
                                self.$loading.hide();
                                self.$fullimage.find( 'img' ).remove();
                                self.$largeImg = $img.fadeIn( 350 );
                                self.$fullimage.append( self.$largeImg );
                            }
                        } ).attr( 'src', eldata.large[0] );
                    }

                }
            },
            open : function() {

                setTimeout( jQuery.proxy( function() {
                    // set the height for the preview and the item
                    this.setHeights();
                    // scroll to position the preview in the right place
                    this.positionPreview();

                    // console.log(this.height);
                    this.$item.find(".og-details-scroll").slimScroll({ 'height': 200, allowPageScroll:true});

                }, this ), 25 );

            },
            close : function() {

                var self = this,
                    onEndFn = function() {
                        if( support ) {
                            jQuery( this ).off( transEndEventName );
                        }
                        self.$item.removeClass( 'og-expanded' );
                        self.$item.find('figure').removeAttr('style');
                        self.$previewEl.remove();
                    };

                setTimeout( jQuery.proxy( function() {

                    if( typeof this.$largeImg !== 'undefined' ) {
                        this.$largeImg.fadeOut( 'fast' );
                    }
                    this.$previewEl.css( 'height', 0 );
                    // the current expanded item (might be different from this.$item)
                    var $expandedItem = $items.eq( this.expandedIdx );
                    $expandedItem.css( 'height', $expandedItem.data( 'height' ) ).on( transEndEventName, onEndFn );

                    if( !support ) {
                        onEndFn.call();
                    }

                }, this ), 25 );

                return false;

            },
            calcHeight : function() {

                var heightPreview = winsize.height - this.$item.data( 'height' ) - marginExpanded,
                    itemHeight = winsize.height;

                //console.log(heightPreview);
                if( heightPreview < settings.minHeight ) {
                    heightPreview = settings.minHeight;
                    itemHeight = parseInt(settings.minHeight) + parseInt(this.$item.data( 'height' )) + parseInt(marginExpanded);
                }
                //console.log(heightPreview);
                //console.log(this.$item.data( 'height' ));

                this.height = heightPreview;
                this.itemHeight = itemHeight;

            },
            setHeights : function() {

                var self = this,
                    onEndFn = function() {
                        if( support ) {
                            self.$item.off( transEndEventName );
                        }
                        self.$item.addClass( 'og-expanded' );
                    };

                this.calcHeight();
                // console.log(this.height);
                // console.log(this.itemHeight);
                this.$previewEl.css( 'height', this.height );
                this.$item.css( 'height', this.itemHeight ).on( transEndEventName, onEndFn );

                if( !support ) {
                    onEndFn.call();
                }

            },
            positionPreview : function() {

                // scroll page
                // case 1 : preview height + item height fits in windows height
                // case 2 : preview height + item height does not fit in windows height and preview height is smaller than windows height
                // case 3 : preview height + item height does not fit in windows height and preview height is bigger than windows height
                var position = this.$item.data( 'offsetTop' ),
                    previewOffsetT = this.$previewEl.offset().top - scrollExtra,
                    scrollVal = this.height + this.$item.data( 'height' ) + marginExpanded <= winsize.height ? position : this.height < winsize.height ? previewOffsetT - ( winsize.height - this.height ) : previewOffsetT;

                $body.animate( { scrollTop : scrollVal }, settings.speed );

            },
            setTransition  : function() {
                this.$previewEl.css( 'transition', 'height ' + settings.speed + 'ms ' + settings.easing );
                this.$item.css( 'transition', 'height ' + settings.speed + 'ms ' + settings.easing );
            },
            getEl : function() {
                return this.$previewEl;
            }
        }

        // return {
        //     init : init,
        //     addItems : addItems
        // };
        // $grid.imagesLoaded( function() {
        setTimeout( function() {

            // initialize some events
            initEvents();
            // get windows size
            getWinSize();
            // save item size and offset
            saveItemInfo( true );

        } );

    }
});