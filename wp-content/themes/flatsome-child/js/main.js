$ = jQuery;
$("a").removeAttr("title");

$('.run-continuously').slick({
	infinite: true,
	slidesToShow: 6,
	slidesToScroll: 1,
	autoplay: true,
	autoplaySpeed: 0,
	speed: 8000,
	cssEase: 'linear',
	pauseOnHover: false,
	pauseOnFocus: false,
	arrows: false,
	dots: false,
	responsive: [
		{
			breakpoint: 768.1,
			settings: {
				slidesToShow: 4
			}
		},
		{
			breakpoint: 549,
			settings: {
				slidesToShow: 2
			}
		}
	]
});

$('.slide-4').slick({
	dots: true,
	infinite: true,
	speed: 300,
	autoplay: true,
	autoplaySpeed: 3000,
	slidesToShow: 4,
	slidesToScroll: 1,
	prevArrow: '<button type="button" class="slick-prev"><svg class="flickity-button-icon" viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow"></path></svg></button>',
	nextArrow: '<button type="button" class="slick-next"><svg class="flickity-button-icon" viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow" transform="translate(100, 100) rotate(180) "></path></svg></button>',
	responsive: [
		{
			breakpoint: 849,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 549,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}
	]
});