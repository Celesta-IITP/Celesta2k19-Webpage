;(function($, window, document, undefined) {
	var router = null;
	var routerActive = false;
	var skrollrInstance = null;
	var wowInstance = null;
	var isMobile = (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))){return true;} else {return false;}})(navigator.userAgent||navigator.vendor||window.opera);

	$(document).on('click', '.router-link', function(event) {
		event.preventDefault();
    
		if(routerActive) {
			return;
		};
    
		router.setState({
			data: {
				animationIn: $(this).attr('data-animation-in') || 'fade',
				animationOut: $(this).attr('data-animation-out') || 'fade'
			},
			url: $(this).attr('href')
		});
	});

	$(document).on('click', function(event) {
		if(!isMobile) {
			if ( $('.talent-popup.open').length ) {
				$('.content').addClass('blur-content');
			} else {
				$('.content').removeClass('blur-content');
			}
		}
	});


	$(document).on('click', '.scrollto', function(event) {
		event.preventDefault();

		scrollToElement($(this).attr('href'));
	});

	$(document).on('page:unload', function(event, page) {
		// Blur Slider
		var blurSliderElement = page.querySelector('.slider-intro .slides');

		if(blurSliderElement && 'blurSlider' in blurSliderElement) {
			blurSliderElement.blurSlider.destroy();
		};

		var masonryWallElements = page.querySelectorAll('.isotope-items');

		if(masonryWallElements.length) {
			for (var i = 0; i < masonryWallElements.length; i++) {
				if('masonryWall' in masonryWallElements[i]) {
					masonryWallElements[i].masonryWall.destroy();
				};
			};
		};
	});

	$(document).on('page:ready', function(event, page) {

		if(isMobile) {
			$('.talent-popup .talent-popup-body .talent-popup-content').scrollbar();
		} else {
			$('.talent-popup .talent-popup-body .talent-popup-content').each(function() {

				if($(this).outerHeight() > 450) {
					$(this).css({ 'max-height': '450px', 'overflow' : 'hidden' });
					$(this).scrollbar({
						'disableBodyScroll' : true
					});					
				}
			});
		}

		$(page).find('.widget-nav-sort a').on('click', function(event) {
			event.preventDefault();

			$('.isotope-items-secondary').find('.item').removeClass('card-fade').filter(':not(' + $(this).attr('data-filter-selector') + ')').addClass('card-fade');

			var masonryWallElements = document.querySelectorAll('.isotope-items');

			if($(this).attr('data-filter-selector') == '*') {

				//masonryWallElements[0].masonryWall.isotope.arrange({ sortBy : 'random' });

				$('.isotope-items-secondary').find('.item:not(.noncard)').each(function() {
					$(this).find('.thesorter').html( Math.floor((Math.random() * 100) + 1) );
				});
				$('.isotope-items-secondary').find('.item.noncard').find('.thesorter').html('-2');


				$(this).closest('li').addClass('active').siblings().removeClass('active');
			
				masonryWallElements[0].masonryWall.resort();
				$('html, body').stop().animate({ 'scrollTop' : 0 }, 800);

				window.setTimeout(function() {
					tagPositionAll();
				}, 500);

			} else {
				$('.isotope-items-secondary').find('.item').find('.thesorter').html('0');
				$('.isotope-items-secondary').find('.item').filter(':not(' + $(this).attr('data-filter-selector') + ')').find('.thesorter').html('-1');
				$('.isotope-items-secondary').find('.item.noncard').find('.thesorter').html('-2');

				$(this).closest('li').addClass('active').siblings().removeClass('active');
			
				masonryWallElements[0].masonryWall.resort();
				$('html, body').stop().animate({ 'scrollTop' : 0 }, 800);
				
				tagPosition();
			}

			window.currentTag = $(this).attr('data-filter-selector');
		});

		// Say Hello Text
		if($(page).find('.intro-message-text').length) {
			setHelloText(new Date());
		};


		// Blur Slider
		var blurSliderElement = page.querySelector('.slider-intro .slides');
		
		_removeSliderIntoOne = true;
		
		if(blurSliderElement) {

			if(_removeSliderIntoOne) {
				var _rand = (Math.floor((Math.random() * 3) + 1));
				
				if($('.slider-intro .slides li').size() > 1) 
					$('.slider-intro .slides li:not(:nth-child('+ _rand +'))').remove();
				
				_removeSliderIntoOne = false;
			}

			blurSliderElement.blurSlider = new BlurSlider(blurSliderElement);
		};

		var masonryWallElements = page.querySelectorAll('.isotope-items');


		if(masonryWallElements.length) {
			for (var i = 0; i < masonryWallElements.length; i++) {
				masonryWallElements[i].masonryWall = new MasonryWall(masonryWallElements[i]);
			};
		};

		if(skrollrInstance) {
			skrollrInstance.destroy();
			skrollrInstance = null;
		};

		/*
		if($(page).find('.skrollr-element').length && !isMobile) {
			
			skrollrInstance = skrollr.init({
				forceHeight 	: false,
				smoothScrolling	: false
			});
		};
		*/


		if($('.skrollertrigger').find('.skrollr-element').length && !isMobile) {
			
			skrollrInstance = skrollr.init({
				forceHeight 	: false,
				smoothScrolling	: false
			});
		};


		if($(page).find('.wow').length) {
			wowInstance = new WOW({
				mobile : false
			});
			wowInstance.init();
		}

		// Slider Preview
		$('.slider-preview .slides-images .slide').each(function(i) {
			$(this).data('index', i);
		});

		var totalPreviewSlides = $('.slider-preview .slides-images .slide').length;

		$('.slider-preview .slides-images').carouFredSel({
			auto: false,
			synchronise: ['.slides-content', false], // TELL FIRST CAROUSEL TO SYNC WITH THE SECOND
			width: '100%',
			items: {
				visible: 1,
				height: '68.42%'
			},

			responsive: true,
			prev: '.slider-preview .slider-prev',
			next: '.slider-preview .slider-next',
			scroll: {
				duration: 500,
				timeoutDuration: 2500,
				onBefore: function(data) {
					$('.slider-preview .slider-timer').width((data.items.visible.data('index') + 1) / totalPreviewSlides * 100 + '%');

					$('.slider-preview .slider-head .idx').text((data.items.visible.data('index') + 1));
				}
			},
			onCreate: function() {
				$('.slider-preview .slider-timer').width(1 / totalPreviewSlides * 100 + '%');
			}
		});

		$('.slider-preview .slides-content').carouFredSel({
			auto: false,
			responsive: true
		});

		// Sound Design Slider
		$('.section-image .slides-images .slide').each(function(i) {
			$(this).data('index', i);
		});

		var totalPreviewSlides2 = $('.section-image .slides-images .slide').length;
		$('.section-image .slides-images').carouFredSel({
			auto: false,
			synchronise: ['.testimonial-secondary .slides-content', false],
			width: '100%',
			responsive: true,
			prev: '.testimonial-secondary .slider-prev',
			next: '.testimonial-secondary .slider-next',
			scroll: {
				duration: 1000,
				onBefore: function(data) {
					$('.section-about .section-image .timer span').width(((data.items.visible.data('index') + 1) / totalPreviewSlides2 * 100 + '%'));
				}
			},
			onCreate: function() {
				$('.section-about .section-image .timer span').width((1 / totalPreviewSlides2 * 100) + '%');
			}
		});

		$('.testimonial-secondary .slides-content').carouFredSel({
			auto: false,
			responsive: true,
			scroll: {
				duration: 1000
			}
		});
	});

	$(document).ready(function() {

		$(document).on('mouseup', function (e) {

		    var container = $('.talent-popup.open');

		    if(container.size()) {

			    if (!container.is(e.target) && container.has(e.target).length === 0) {
			        container.find('.btn-close').click();
			    }
		    }
		});

		$('.position-item:first').fadeIn();

		$('.list-positions li a').on('click', function(e) {
			e.preventDefault();

			$('.list-positions li a').parent('li').removeClass('active');
			$(this).parent('li').addClass('active');

			$('.position-item').hide();
			$('.position-item[data-id="'+ $(this).attr('data-target') +'"]').fadeIn();
		});

		$(document).trigger('page:ready', [$('.page')[0]]);

		var ua = navigator.userAgent.toLowerCase();

		if (ua.indexOf("safari/") !== -1 &&  // It says it's Safari
		    ua.indexOf("windows") !== -1 &&  // It says it's on Windows
		    ua.indexOf("chrom")   === -1     // It DOESN'T say it's Chrome/Chromium
		    ) {
		    // alert('safari');
			$('.slider-intro').addClass('safari-browser');
		}	

		if ( $('.talent-popup.open').length ) {
			$('.content').addClass('blur-content');
		};

		// side navigation active class
		var sections = $('section'), 
			nav = $('.widget-nav'), 
			nav_height = nav.outerHeight();
		 
		$(window).on('scroll', function () {
			var cur_pos = $(this).scrollTop();

			sections.each(function() {
				var top = $(this).offset().top,
					bottom = top + $(this).outerHeight();
		 
				if (cur_pos >= top && cur_pos <= bottom) {
					nav.find('a').removeClass('active');
					sections.removeClass('active');


					$(this).addClass('active');
					nav.find('a[href="#'+$(this).attr('id')+'"]').addClass('active');
				}

				if (($(document).height() - ($(window).scrollTop() + $(window).height())) == 0) {
					if(nav.find('a:last').hasClass('scrollto')) {
						nav.find('a').removeClass('active');
						sections.removeClass('active');

						$('section:last').addClass('active');
						nav.find('a:last').addClass('active');
					}
				}
		  });
		});

		// Video Popup
		$('.popup-video').magnificPopup({
			type: 'iframe',
			mainClass: 'mfp-fade',
			preloader: false,
			fixedContentPos: false,
			patterns: {
				youtube: {
					index : 'youtube.com/',
					id    : 'v=',
					src   : '//youtube.com/embed/%id%?autoplay=1'
				}
			}
		});

		$(window).on('load', function(event) {
			var masonryWallElements = document.querySelectorAll('.isotope-items');

			if(masonryWallElements.length) {
				for (var i = 0; i < masonryWallElements.length; i++) {
					if('masonryWall' in masonryWallElements[i]) {
						masonryWallElements[i].masonryWall.isotope.layout();
					};
				};
			};

			$(document).trigger('page:ready', [$('.page')[0]]);
		});

		if(isMobile) {
			// Toggle Navigation
			$(document).on('click', '.btn-menu', function(event) {
				event.preventDefault();
				var ww = $(window).width();

				if (ww > 1024) {
					if ( !$('.nav-expanded').length ) {
						setTimeout(function() {
							$('.container').after($('.container').clone().addClass('container-ghost'));

							$('.container-ghost .container-inner').width( $(window).width() - 48 )
						}, 400);

					} else {
						$('.container-ghost').empty().remove()
					}
				};



				$('body').toggleClass('nav-expanded');

				var masonryWallElements = document.querySelectorAll('.isotope-items');

				if(masonryWallElements.length) {
					for (var i = 0; i < masonryWallElements.length; i++) {
						if('masonryWall' in masonryWallElements[i]) {
							masonryWallElements[i].masonryWall.isotope.layout();
						};
					};
				};
			});
		} else {
			$(window).on('load', function(event) {
				// Toggle Navigation
				$(document).on('click', '.btn-menu', function(event) {
					event.preventDefault();
					var ww = $(window).width();

					if (ww > 1024) {
						if ( !$('.nav-expanded').length ) {
							setTimeout(function() {
								$('.container').after($('.container').clone().addClass('container-ghost'));

								$('.container-ghost .container-inner').width( $(window).width() - 48 )
							}, 400);

						} else {
							$('.container-ghost').empty().remove()
						}
					};



					$('body').toggleClass('nav-expanded');

					var masonryWallElements = document.querySelectorAll('.isotope-items');

					if(masonryWallElements.length) {
						for (var i = 0; i < masonryWallElements.length; i++) {
							if('masonryWall' in masonryWallElements[i]) {
								masonryWallElements[i].masonryWall.isotope.layout();
							};
						};
					};
				});
			});
		}


		var routerTimeouts = {};

		$(window).on('resize', function(event) {
			var ww = $(window).width(),
				wh = $(window).height();

			if (ww > 1260) {
				$('.slider-intro, .slider-intro .caroufredsel_wrapper').height(wh)
			} else {
				$('.slider-intro').height('100%')
				$('.slider-intro .caroufredsel_wrapper').height( $('.slider-intro .slides').height() )
			}
		}).trigger('resize');

		router = new Router({
			resolveStart: function() {
				routerActive = true;
				$('body').addClass('loading');
				NProgress.start();
			},
			resolveSuccess: function(data) {

				var $newPage = $('.page', data.content);
				var $oldPage = $('.page');

				$newPage.addClass('animating in ' + data.stateObject.data.animationIn);

				$oldPage.after($newPage);
				
				NProgress.done();

				$('html, body').animate({
					scrollTop: 0
				});

				routerTimeouts.preAnimate = setTimeout(function() {

					/* Additional code to change header state */
					$('body').addClass('hide-logo');

					clearTimeout(routerTimeouts.preAnimate);
					routerTimeouts.preAnimate = null;

					$oldPage.addClass('animating out ' + data.stateObject.data.animationOut);

					$newPage.removeClass(data.stateObject.data.animationIn);

					document.title = $(data.content).filter('title').text();


					if(window.currentTag)
						$('.isotope-items.isotope-items-secondary .item').addClass('card-fade');

					routerTimeouts.animate = setTimeout(function() {
						clearTimeout(routerTimeouts.animate);
						routerTimeouts.animate = null;

						$(document).trigger('page:unload', [$oldPage[0]]);

						$newPage.removeClass('in');

						/* Additional code to change header state */
						$('body').removeClass('hide-logo');
						$('header').attr('class', $('header.header', data.content).attr('class'));

						resortTagPosition();

						routerTimeouts.postAnimate = setTimeout(function() {
							clearTimeout(routerTimeouts.postAnimate);
							routerTimeouts.postAnimate = null;

							$newPage.removeClass('animating');

							routerActive = false;

							/* This is for work page ajax */
							if($('#work-entry-nav.main').size()) {

								var _curpage = $('#work-entry-nav.main').attr('data-id');

								for(var i = 0; i<=(window.tagPosition.length - 1); i++ ) {
									var _id = window.tagPosition[i];

									if(_id == _curpage) {

										// Prev
										var _prev = i + 1;
										if(window.tagPosition[_prev]) {
											$('.btn-action-left.router-link').attr('href', window.tagURL[_prev]).show();
										}

										// Next
										var _next = i - 1;
										if(window.tagPosition[_next]) {
											$('.btn-action-right.router-link').attr('href', window.tagURL[_next]).show();
										}
									}
								}
							}

						}, 100);

						$oldPage.empty().remove();


						/* Workaround for slider inside project */
						$('.slider-preview .slides-images, .slider-preview .slides-content').trigger('destroy');

						$('.slider-preview .slides-images .slide').each(function(i) {
							$(this).data('index', i);
						});

						var totalPreviewSlides = $('.slider-preview .slides-images .slide').length;

						$('.slider-preview .slides-images').carouFredSel({
							auto: false,
							synchronise: ['.slides-content', false], // TELL FIRST CAROUSEL TO SYNC WITH THE SECOND
							width: '100%',
							items: {
								visible: 1,
								height: '68.42%'
							},

							responsive: true,
							prev: '.slider-preview .slider-prev',
							next: '.slider-preview .slider-next',
							scroll: {
								duration: 500,
								timeoutDuration: 2500,
								onBefore: function(data) {
									$('.slider-preview .slider-timer').width((data.items.visible.data('index') + 1) / totalPreviewSlides * 100 + '%');

									$('.slider-preview .slider-head .idx').text((data.items.visible.data('index') + 1));
								}
							},
							onCreate: function() {
								$('.slider-preview .slider-timer').width(1 / totalPreviewSlides * 100 + '%');
							}
						});

						$('.slider-preview .slides-content').carouFredSel({
							auto: false,
							responsive: true
						});

						/* End Workaround */

					}, 1000);

				}, 100);

				$('body').removeClass('loading');

				$(document).trigger('page:ready', [$newPage[0]]);
			},
			resolveAbort: function() {
				for (var key in routerTimeouts) {
					if(routerTimeouts[key]) {
						clearTimeout(routerTimeouts[key]);
					};
				};
				$('.page.in').empty().remove();

				$('.page:not(.in)').removeClass('out animating slide-top slide-bottom slide-left slide-right fade');
			}
		});

	});

	function setHelloText(time) {
		$('.intro-message-text').removeClass('current').each(function() {

			if(this.getAttribute('data-till-hour') - 0 >= time.getHours()) {
				$(this).addClass('current');

				return false;
			};
		});
	};

	function scrollToElement(selector) {
		if(!selector || selector === '#') {
			selector = 'body';
		};

		if($(selector).length) {			
			$('html, body').stop().animate({
				scrollTop: $(selector).offset().top
			}, 900);
		};
	};

	function getSortedKeys(obj) {
	    var keys = []; for(var key in obj) keys.push(key);
	    return keys.sort(function(a,b){return obj[b]-obj[a]});
	};

	function tagPositionAll() {

		if($('.section-cards .isotope-items .item').size() && !$('#work-entry-nav').size()) {
			var x = [];
			
			$('.section-cards .item').each(function(){
				var _curid  = $(this).attr('id'),
				    _curpos = parseInt($(this).css('top')) + ((parseInt($(this).css('left')) > 0) ? 1 : 0);

				if(_curpos != undefined)
					x[_curid] = _curpos;
			});

			z = getSortedKeys(x);
			
			window.tagPosition = z;
			window.tagURL      = [];

			window.tagPosition.forEach(function(y) {

				window.tagURL.push( $('.item[id="'+ y +'"]').find('a.router-link').attr('href') );
			});
		}
	};

	function tagPosition() {
		
		window.tagPosition = [];
		window.tagURL      = [];
		window.currentTag  = '';

		i = 0;

		$('.section-cards .item:not(.card-fade)').each(function() {

			var _curid  = $(this).attr('id'),
			    _curpos = $(this).find('.thesorter').html();

			if(_curid) {
				window.tagPosition[ i ] = _curid;
				window.tagURL[ i ] = $(this).find('a.router-link').attr('href');
				i++;
			}
		});
	};

	function resortTagPosition() {

		if(window.currentTag != '*') {
			$('.widget-nav-sort a[data-filter-selector="'+ window.currentTag +'"]').click();
		} else {
			$('.widget-nav-sort a:first').parent('li').addClass('active');
			$('.section-cards .item').removeClass('card-fade');
		}
			
		if(window.tagPosition) {

			x = 1;

			for(var i = 0; i<=(window.tagPosition.length - 1); i++ ) {
				var _id = window.tagPosition[i];

				$('.section-cards .item:not(.card-fade)[id="'+ _id +'"]').find('.thesorter').html(x);
				x++;
			}

			window.setTimeout(function(){;
				var masonryWallElements = document.querySelectorAll('.isotope-items');
				
				masonryWallElements[0].masonryWall.resort();
				$('html, body').stop().animate({ 'scrollTop' : 0 }, 800);
			}, 100)
		}
	};

})(jQuery, window, document);

var utils = (function() {

	function generateID(prefix) {
		return (prefix || '') + new Date().getTime();
	};

	return {
		generateID: generateID
	};

}());



var BlurSlider = (function($) {

	function BlurSlider(element) {

		this.id = utils.generateID('blur-slider-')

		this.element = element;

		this.blurTemplate = null;

		this.init();
		
	};

	BlurSlider.prototype.init = function() {
		this.blurTemplate = new Templator(document.getElementById('blur-template').innerHTML);

		var _this = this;

		$(window).on('load', function() {
			_this.initSlider();
		});

		this.bind();
	};

	BlurSlider.prototype.bind = function() {
		var that = this;

		$('body').on('mousemove.' + this.id, function(event) {
			that.updateCirclePosition(event);
		});
	};

	BlurSlider.prototype.unbind = function() {
		$('body').off('mousemove.' + this.id);
	};

	BlurSlider.prototype.destroy = function() {
		this.unbind();
	};

	BlurSlider.prototype.updateCirclePosition = function(event) {

		var posX = event.clientX;
		var posY = event.clientY;

		$(this.element).find('.mask circle').each(function () {
			this.setAttribute('cy', ((posY) + 'px'));
			this.setAttribute('cx', ((posX) + 'px'));
		});
	};

	BlurSlider.prototype.initSlider = function() {
		var that = this;
		var totalSlides = $(this.element).find('.slide').length;

		$(this.element).find('.slide').each(function(i) {
			$(this).data('index', i);
		});

		// Slider Intro
		$(this.element).carouFredSel({
			auto: false,
			responsive: true,
			width: '100%',
			items: {
				visible: 1
			},
			scroll: {
				fx: 'crossfade',
				duration: 1500,
				onBefore: function (data) {
					that.addBlur(data.items.visible);

					$('.slider-intro .slider-progress .bar').width((data.items.visible.data('index') + 1) / totalSlides * 100 + '%');
				}
			},
			onCreate: function() {
				that.addBlur($(that.element).find('.slide').first());

				$('.slider-intro .slider-progress .bar').width(1 / totalSlides * 100 + '%');

				$(window).on('resize', function() {
					var heights = $(that.element).children().map(function() { return $(this).height(); });
				  $(that.element).parent().add($(that.element)).height(Math.max.apply(null, heights));
				}).trigger('resize');
			},
			circular: false,
			prev: {
				button: $(that.element).closest('.intro').find('.slider-prev'),
				key: 'left'
			},
			next: {
				button: $(that.element).closest('.intro').find('.slider-next'),
				key: 'right'
			}
		});
	};

	BlurSlider.prototype.addBlur = function($slide) {
		$slide.find('.blur').empty().remove();

		$slide.find('.pic').append(this.blurTemplate.compile({
			image: $slide.find('.pic-image').attr('src'),
			filter: utils.generateID('filter-'),
			mask: utils.generateID('mask-')
		}));
	};

	return BlurSlider;

})(jQuery);

var MasonryWall = (function($) {

	function MasonryWall(element) {
		this.id = utils.generateID('iso-');

		this.element = element;

		this.infinite = this.element.getAttribute('data-infinite');

		this.itemSelector = this.element.getAttribute('data-item-selector');

		this.isotope = null;

		this.request = null;

		this.onloadmore = true;

		this.init();
	};

	MasonryWall.prototype.resort = function() {
		
		this.isotope.updateSortData();

		return this.isotope.arrange({ 
			sortBy : 'thesorter',
			sortAscending: false
		});
	};

	MasonryWall.prototype.init = function() {
		this.isotope = new Isotope(this.element, {
			getSortData : {
	          thesorter : function( $elem ) {
	            return parseInt( $($elem).find('.thesorter').text(), 10 );
	          }
	        },
	        sortBy : 'thesorter',
			itemPositionDataEnabled: true
		});

		this.bind();
	};

	MasonryWall.prototype.bind = function() {
		var that = this;

		$(this.element).closest('.isotope-holder').find('.nav-filters').on('click', 'a', function(event) {
			event.preventDefault();

			$(this).closest('li').addClass('active').siblings().removeClass('active');

			that.isotope.arrange({
				filter: $(this).attr('href')
			}).layout();

			if($(this).attr('href') == '.update-item-media') {
				$('ul.update-items.isotope-items').css('background', '#fff');
			} else {
				$('ul.update-items.isotope-items').css('background', '#0B202B');
			}
		});

		if(this.infinite) {
			$(window).on('scroll.' + this.id, function(e) {
				e.stopImmediatePropagation();
				window.setTimeout(function() {  
					if($(window).scrollTop() + $(window).height() * 2 > $(that.element).offset().top + $(that.element).height()) {
						that.loadMore();
					};
				}, 100);
			});
		};
	};

	MasonryWall.prototype.loadMore = function() {
		var that = this;

		if(this.request) {
			return;
		};

		this.request = $.ajax({
			url: this.infinite,
			type: 'get',
			success: function(response) {
				that.request = null;

				that.infinite = that.infinite.replace(/\d+/, function(match) {
					return match - 0 + 1;
				});

				var elements = $(that.itemSelector, response).get();

				$(that.element).append(elements);

				that.isotope.appended( elements );

				that.isotope.layout();

				this.onloadmore = true;
			},
			error: function() {
				that.unbindInfinite();
			}
		})
	};

	MasonryWall.prototype.unbindInfinite = function() {
		$(window).off('scroll.' + this.id);
	};

	MasonryWall.prototype.destroy = function() {
	};

	return MasonryWall;
})(jQuery);




var Router = (function($) {

	function escapeRegExp(str) {
		return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
	}

	function Router(config) {
		this.config = config || {};

		this.state = null;

		this.request = null;

		this.init();
	};

	Router.prototype.init = function() {
		this.bind();
	};

	Router.prototype.bind = function() {
		var that = this;
		var isMobile = (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))){return true;} else {return false;}})(navigator.userAgent||navigator.vendor||window.opera);

		if(isMobile) {
			$(window).on('load', function() {

				setTimeout(function() {

					$(window).on('popstate', function(event) {

						if(window.location.pathname == '/work') {

							that.resolveState({
								url: window.location.pathname,
								data: history.state
							});

							return;
						}

						if(history.state === null) {
							return;
						};

						that.abort();


						that.resolveState({
							url: window.location.pathname,
							data: history.state
						});
					});

				}, 0);
			});
		} else {
			$(window).on('popstate', function(event) {

				if(window.location.pathname == '/work') {

					that.resolveState({
						url: window.location.pathname,
						data: history.state
					});

					return;
				}

				if(history.state === null) {
					return;
				};

				that.abort();


				that.resolveState({
					url: window.location.pathname,
					data: history.state
				});
			});
		}
	};

	Router.prototype.setState = function(stateObject) {
		if(new RegExp('/' + escapeRegExp(stateObject.url) + '$').test(window.location.pathname)) {
			return;
		};

		history.pushState(stateObject.data, stateObject.title || null, stateObject.url);

		this.resolveState(stateObject);
	};

	Router.prototype.prevPage = function() {
		var idx = this.getCurrentPageIdxFromCollection(this.config.pages);

		if((idx - 1) in this.config.pages) {
			this.setState({
				url: this.config.pages[idx - 1],
				data: {
					direction: 'right'
				}
			});
		};
	};

	Router.prototype.nextPage = function() {
		var idx = this.getCurrentPageIdxFromCollection(this.config.pages);

		if((idx + 1) in this.config.pages) {
			this.setState({
				url: this.config.pages[idx + 1],
				data: {
					direction: 'left'
				}
			});
		};
	};

	Router.prototype.getCurrentPageIdxFromCollection = function(collection) {
		for (var i = 0; i < collection.length; i++) {
			if(new RegExp('/' + escapeRegExp(collection[i]) + '$').test(window.location.pathname)) {
				return i;
			};
		};
	};

	Router.prototype.resolveState = function(stateObject) {
		var that = this;

		if(!('data' in stateObject) || stateObject.data === null) {
			stateObject.data = {
				direction: 'left'
			};
		} else if (!('direction' in stateObject.data)) {
			stateObject.data.direction = 'left';
		};


		this.triggerCallback('resolveStart');

		this.request = this.getUrlContent(stateObject.url)
			.success(function(response) {
				that.triggerCallback('resolveSuccess', {
					stateObject : stateObject,
					content     : response
				});
			})
			.error(function() {
				that.triggerCallback('resolveError');
			});
	};

	Router.prototype.abort = function() {
		if(this.request) {
			this.request.abort();
		};

		this.triggerCallback('resolveAbort');
	};

	Router.prototype.getUrlContent = function(url) {
		return $.ajax({
			url: url
		});
	};

	Router.prototype.triggerCallback = function(name, data) {
		if(name in this.config) {
			this.config[name](data);
		};
	};


	return Router;

})(jQuery);