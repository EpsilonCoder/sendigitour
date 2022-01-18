<?php 
//Header Setting
$aneeq_theme_layout = get_theme_mod('aneeq_theme_layout', 'wide');
?>
<style>
	<?php if($aneeq_theme_layout=='boxed'){ ?>
		.loader-wrapper {
			width: 1170px;
		}
	<?php } ?>

	/* Service Box Style
	====================================*/
	.serviceBox_1 .service-icon i { color: #29B6F6;}
	.serviceBox_4 .service-icon { background: #29B6F6;}
	.serviceBox_4 .service-icon:before { border: 3px solid #29B6F6;}
	.serviceBox_5> span {background:#29B6F6;}
	.serviceBox_7 .service-icon{background: #29B6F6;}
	.serviceBox_4 .read a,
	.serviceBox_5 .read a, 
	#site-searchform #searchsubmit, 
	#site-searchform #searchsubmit:hover, 
	#filter li.selected a:after, #filter li a:hover:after {
		background: #29B6F6 opacity: 0, 0, 0, 0; linear-gradient(to right, #29B6F6 0%, #29B6F6 50%, #29B6F6 50%) repeat scroll 100% 0 / 200% 100%;
	}

	/* Common Background Color Style
	====================================*/
	.flickr-feed li .hover,
	.progress_skill .bar,
	.swipe-navi .swipe-left,
	.swipe-navi .swipe-right,
	.highlight.default,
	.carousel-pagination li.active,
	.theme-color-pt .pricingTable:before,
	.pricingBlock.theme-color-pt .pricingTable-header .price-value,
	.slide-btn, 
	#aneeq-slider .owl-prev:hover, 
	#aneeq-slider .owl-next:hover, 
	.site-content .owl-prev:hover, 
	.site-content .owl-next:hover,
	#aneeq-portfolio-slider .owl-prev:hover, 
	#aneeq-portfolio-slider .owl-next:hover,
	.masonry_blog .owl-prev:hover, 
	.masonry_blog .owl-next:hover, 


	.top-info li a:hover, 
	.top-info li a:hover, 
	.page_head, 
	.navbar-default .navbar-nav > li > a:after, 

	.navbar-nav > li.active > a,
	.navbar-default .navbar-nav > .active > a,
	.navbar-default .navbar-nav > .active > a:hover,
	.navbar-default .navbar-nav > .active > a:focus,
	.navbar-default .navbar-nav > .open > a,
	.navbar-default .navbar-nav > .open > a:hover,
	.navbar-default .navbar-nav > .open > a:focus, 

	.navbar-nav > li > a:hover,
	.navbar-nav > li > a:focus,
	.navbar-default .navbar-nav .open .dropdown-menu > .active > a,
	.navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover,
	.navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus,
	.navbar-default .navbar-nav .open .dropdown-menu > .disabled > a,
	.navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:hover,
	.navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:focus, 

	.navbar-nav .dropdown-menu > li > a:hover, 

	.widget_social li a:hover, .widget_social li a:focus, 
	div.widget-item h4:before, 
	.blogPic .blog-hover .icon, 
	.blog_large .day, .blog_single .day, 
	.blog_medium .day, 
	.author_desc,
	.shares li a:hover, 
	.comment-container:hover, 
	.blog-section .owl-theme .owl-dots .owl-dot.active span, .blog-section .owl-theme .owl-dots .owl-dot:hover span, 
	.testimonial-content .owl-theme .owl-dots .owl-dot.active span, .testimonial-content .owl-theme .owl-dots .owl-dot:hover span, 
	.icon_lists .fa-hover a:hover, 
	.testimonial-content .owl-theme .owl-controls .owl-buttons div:hover, 
	.serviceBox_2 .service-icon, 
	.serviceBox_4 .service-icon, 
	.serviceBox_5> span, 
	.serviceBox_7 .service-icon, 
	.btn-default, 
	.theme-color-pt .pricingTable:before,
	.pricingTable:before, 
	.theme-color-pt .btn-default, 
	.progress_skill .bar, 
	.promo_box.reverse, 
	.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus, 
	.pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus, 
	.dividerHeading h2::before, 
	.dividerHeading h4::before,
	.widget-title::before, 




	.dropcap_block, 
	.dropcap_block.default, 
	.highlight.default, 
	.swipe-navi .swipe-left,
	.swipe-navi .swipe-right, 
	.carousel-pagination li.active, 
	.flickr-feed li .hover, 
	.list_style.circle li:before, 
	.list_style.square li:before, 
	.list-group-item.active,
	.list-group-item.active:focus,
	.list-group-item.active:hover, 
	.btntoTop, 
	.navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus, 
	.our-client-section .owl-theme .owl-dots .owl-dot.active span, 
	.our-client-section .owl-theme .owl-dots .owl-dot:hover span, 
	.our-client-section .owl-theme .owl-dots .owl-dot.active span, 
	.our-client-section .owl-theme .owl-dots .owl-dot:hover span, 
	.widget table#wp-calendar caption, 
	.tagcloud a:hover, 
	.footbot_social li a:hover, .footbot_social li a:focus
	{
		background-color: #29B6F6;
	}

	/* Common Text Color Style
	====================================*/
	.testimonial-review small,
	#breadcrumbs ul li:last-child a,
	.dropcap.default,
	.panel-heading:hover a,
	.active_acc .panel-title a,
	.panel-heading:hover  a,
	.panel-heading:hover .accordian-icon,
	.panel.panel-default i,
	.panel .panel-title > a:before,
	.recent_tab_list li a:hover,
	.feature-block h4,
	.option a.fa:hover,
	.sidebar .widget ul.arrows_list li a:hover,
	.sidebar .widget ul.archives_list li a:hover,
	.parallax-testimonial-review small,
	.footer li a:hover,.author_bio > h5 a,.author_name > a:hover,.project_details .details li a:hover, 
	tbody a, p a, dl dd a, .top-info span i, 
	#breadcrumbs ul li:last-child a,
	#breadcrumbs ul li a, 
	div.widget-item ul li a:hover, 
	.sidebar .widget ul.list_style li a:hover, 
	#filter li.selected a, #filter li a:hover, 
	.blogTitle > a:hover h2, 
	.blogMeta a:hover, .blogTitle span:hover, 
	.blog_large .post_meta h2:hover a, .blog_single .post_meta h2:hover a, .blog_medium .metaInfo a:hover,
	.blog_medium .post_meta .metaInfo > span > a:hover, 
	.blog_medium .post_meta h2:hover a, 
	.masonry_wrapper_blog .metaInfo a:hover,
	.blog-item > span a:hover,
	.blog-title a:hover, 
	.author_name > a:hover, 
	.author_bio > h5 a, 
	#comment-list li .comment-container:hover a, 
	#comment-list li .comment-container:hover .comment-date, 
	#comment-list li .comment-container:hover h4, 
	.post-detail a:hover, 
	.post-detail .read-more, 
	.post-slide a.readmore, 
	.post-title > a:hover, 
	.team_social li a:hover, .team_social li a:focus, 
	.testimonial .designation .website, 
	.serviceBox_1 .service-icon i, 
	.serviceBox_2 .read a:hover, 
	.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, 
	.nav-tabs li.active, .nav-tabs li.active a, .nav-tabs li.active a:hover, 
	.recent_tab_list li a:hover, 
	.comments_list a, 
	.panel .panel-title > a:before, 
	.promo_box.reverse .pb_action a.btn:hover, 
	.dropcap.default, 
	.multi-icon li i, 
	.list_style li a:hover, 
	.list_style li a.active, 
	.list_style.star li:before, 
	.list_style.right-arrow li:before, 
	.list_style.hand li:before, 
	.list_style.play li:before, 
	.list_style.dubble-right-arrow li:before, 
	.widget ul li a:hover, .widget ul li a:focus, 
	.widget table#wp-calendar tbody a:hover, .widget table#wp-calendar tbody a:focus, 
	.footer .widget a, 
	.copyright a:hover, .copyright a:focus, 
	.site-url a, .site-url a:hover, .site-url a:focus {
		color: #29B6F6;
	}

	/* Tabs Style
	====================================*/
	.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus,
	.nav-tabs li.active, .nav-tabs li.active a, .nav-tabs li.active a:hover
	{ border-top-color:#29B6F6; color:#29B6F6;}

	/* List & Bullets Style
	====================================*/
	.list_style.square li:before,
	.list_style.circle li:before{
		background: #29B6F6;
	}

	.list_style li a:hover,
	.multi-icon li i.fa,
	.list_style.star li:before,
	.list_style.right-arrow li:before,
	.list_style.hand li:before,
	.list_style.play li:before,
	.list_style.dubble-right-arrow li:before{
		color: #29B6F6;
	}

	/* Buttons & Headings Style
	====================================*/
	.btn-default,
	.dropcap_block.default,
	.icon_lists .fa-hover a:hover,
	.dividerHeading h4::after,
	.dividerHeading h4::before,
	.widget_title h4::after,
	.widget_title h4::before,
	.widget-title::before
	{
		background-color:#29B6F6;
	}

	.theme-color-pt .btn-default {background:#29B6F6;}
	.theme-color-pt { background-color:#29B6F6;}
	.btntoTop{background-color: #29B6F6;}
	.btntoTop.active:hover{
		background-color: #29B6F6;
		opacity: 0.80;
	}


	/* Blog Page Style
	====================================*/
	#site-searchform #searchsubmit,
	.tags li a:hover,
	.shares li a:hover,
	.blogPic .blog-hover .icon,
	.blog_large .day, .blog_single .day,
	.author_desc{
		background-color: #29B6F6;
	}

	#site-searchform #searchsubmit:hover{background-color:#29B6F6;}
	.blogPic .blog-hover .icon,
	.author_desc,
	.blog_large .day, .blog_single .day,
	#filter li.selected a:before{background-color: #29B6F6;}

	.list-group-item.active,
	.list-group-item.active:focus,
	.list-group-item.active:hover{
		background-color: #29B6F6;
		border-color: #29B6F6;
	}
	.blog_medium .day{background:#29B6F6;}
	.panel.active_acc, .panel:hover{border-top-color:#29B6F6;}
	.comment-container:hover { border-color:#29B6F6;}

	.blogTitle > a:hover h2,
	.blog_large .post_meta .metaInfo > span > a:hover, .blog_single .post_meta .metaInfo > span > a:hover,
	.blogMeta a:hover, .blogTitle span:hover,
	.blog_medium .post_meta .metaInfo > span > a:hover,
	.blog_medium .post_meta h2:hover a,
	.blog_large .post_meta h2:hover a, .blog_single .post_meta h2:hover a,
	#comment-list li .comment-container:hover a,
	#comment-list li .comment-container:hover .comment-date,
	.comments_list a,
	.post-title > a:hover,
	.post-slide a.readmore:hover{
		color: #29B6F6;
	}
	.pager li>a, .pager li>span { color: #29B6F6;}
	.pager li>a:hover, .pager li>span:hover { background-color: #29B6F6; color: #fff;}

	.form-control:focus,#site-searchform #s:focus {border-color:#29B6F6;box-shadow:0 1px 1px #29B6F6 opacity: 0, 0, 0, 0.075; inset, 0 0 8px #29B6F6 opacity: 204, 137, 124, 0.6;}
	blockquote.default,.theme-color-pt .pricingTable {border-color:#29B6F6;}


	/* Navigation Menu Bar Style
	====================================*/
	.navbar-nav > li.active > a,
	.navbar-default .navbar-nav > .active > a,
	.navbar-default .navbar-nav > .active > a:hover,
	.navbar-default .navbar-nav > .active > a:focus,
	.navbar-default .navbar-nav > .open > a,
	.navbar-default .navbar-nav > .open > a:hover,
	.navbar-default .navbar-nav > .open > a:focus{
		background: #29B6F6;
	}


	/* .navbar-nav > li > a:hover, */
	.navbar-nav > li > a:focus,
	.navbar-default .navbar-nav .open .dropdown-menu > .active > a,
	.navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover,
	.navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus,
	.navbar-default .navbar-nav .open .dropdown-menu > .disabled > a,
	.navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:hover,
	.navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:focus
	{
		background:#29B6F6 !important;
	}
	.navbar-default .navbar-nav > li > a:after {background: #29B6F6;}
	.navbar-default .navbar-nav > li > a > span.data-hover::before {background: #29B6F6;}
	.navbar-nav > li.active {
		background: #29B6F6;
	}

	.navbar-nav > li > ul:before{ border-bottom-color:#29B6F6; }
	.navbar-nav .dropdown-menu > li > a:hover{ background: #29B6F6; /*color: #fff;*/}

	@media only screen and (max-width: 767px) {
		.navbar-nav > li > a:hover,.navbar-nav > li > a:focus,.navbar-nav > li.active > a,
		.navbar-default .navbar-nav > .active > a,
		.navbar-default .navbar-nav > .active > a:hover,
		.navbar-default .navbar-nav > .active > a:focus,
		.navbar-default .navbar-nav > .open > a,
		.navbar-default .navbar-nav > .open > a:hover,
		.navbar-default .navbar-nav > .open > a:focus,
		.navbar-default .navbar-nav .open .dropdown-menu > .active > a,
		.navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover,
		.navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus,
		.navbar-default .navbar-nav .open .dropdown-menu > .disabled > a,
		.navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:hover,
		.navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:focus
		{
			background:#29B6F6 !important;
		}
		.navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus
		{
			background:#29B6F6;
		}
	}

	/* blog Pagination color setting*/
	.pagination li span { background : #29B6F6; color : #ffffff; }
	.pagination li span:hover { background : #29B6F6; color : #ffffff; }


	/* Title bar */
	.dividerHeading h2::before {
		background: #29B6F6 !important;
	}

	/* header icon color */
	.top-info span i { color: #29B6F6; }
	.top-info li a:hover {
		border: 1px solid #29B6F6;
		background-color: #29B6F6;
		color: #29B6F6 !important;
	}
	.top-info li:hover a {color:#fff!important;}


	/* logo text color */

	/* Slider caption color */
	.slide-btn { background-color: #29B6F6; }

	/* service color */
	.serviceBox_2.blue .service-icon { background: #29B6F6 none repeat scroll 0 0 !important;}
	.serviceBox_2.blue .read a {color: #29B6F6 !important;}
	.serviceBox_2.blue .read a:hover {
		color: #186A89 !important;
	}

	/* blog post read more color*/
	.post-slide a.readmore { color: #29B6F6; } 

	/*Border Color*/
	#aneeq-slider .owl-prev:hover, 
	#aneeq-slider .owl-next:hover, 
	.site-content .owl-prev:hover, 
	.site-content .owl-next:hover, 
	#aneeq-portfolio-slider .owl-prev:hover, 
	#aneeq-portfolio-slider .owl-next:hover, 
	.masonry_blog .owl-prev:hover, 
	.masonry_blog .owl-next:hover {  border: 2px solid #29B6F6; }

	.top-info li a:hover, .widget_social li a:hover, .widget_social li a:focus { border: 1px solid #29B6F6; }
	.sub_heading { border-left: 2px solid #29B6F6; }

	.form-control:focus,#site-searchform #s:focus { border-color: #29B6F6; }

	.serviceBox_4 .service-icon:before { border: #29B6F6; }
	.theme-color-pt .pricingTable,
	.pricingTable {
		border-bottom:3px solid #29B6F6;
	}
	.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, 
	.nav-tabs li.active, .nav-tabs li.active a, .nav-tabs li.active a:hover
	{
		
		border-top: 1px solid #29B6F6;
	}
	.panel.active_acc,
	.panel:hover{ border-top-color: #29B6F6; }

	.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus, 
	.pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus, blockquote.default, 
	.list-group-item.active,
	.list-group-item.active:focus,
	.list-group-item.active:hover {
		border-color: #29B6F6;
	}

	blockquote { border-left: 5px solid #29B6F6; }
	
	

/*WOOCOMMERCE CSS----------------------------------------------------------------------------------------------------*/
/* Woocommerce Colors-------------------------------------------------------------------------------------------- */
.woocommerce .variations td.label, .woocommerce-cart table.cart td.actions .coupon .input-text, .select2-container .select2-choice { color: #29B6F6; }
.woocommerce div.product span.price, .woocommerce .posted_in a, .woocommerce-product-rating a, .woocommerce .tagged_as a, .woocommerce div.product form.cart .variations td.label label, .woocommerce #reviews #comments ol.commentlist li .meta strong, .owl-item .item .cart .add_to_cart_button, .woocommerce ul.cart_list li a, .woocommerce-error, .woocommerce-info, .woocommerce-message { color: #29B6F6; }
.woocommerce ul.products li.product .button { color: #fff; }
.woocommerce ul.product_list_widget li a:hover, .woocommerce ul.product_list_widget li a:focus, 
.woocommerce .posted_in a:hover, .woocommerce .posted_in a:focus { color: #29B6F6; }
.woocommerce ul.products li.product:hover .button, 
.woocommerce ul.products li.product:focus .button, 
.woocommerce div.product form.cart .button:hover, 
.woocommerce div.product form.cart .button:focus, 
.woocommerce div.product form.cart .button, .woocommerce a.button, .woocommerce a.button:hover, .woocommerce input.button:disabled, .woocommerce input.button:disabled[disabled], .woocommerce-EditAccountForm input.woocommerce-Button, .owl-item .item .cart .add_to_cart_button:hover, #add_payment_method table.cart img, .woocommerce-cart table.cart img, .woocommerce-checkout table.cart img { border: 4px double #eee; }
.woocommerce div.product form.cart .button, .woocommerce a.button, .woocommerce a.button:hover, .woocommerce a.added_to_cart, .woocommerce table.my_account_orders .order-actions .button { color: #fff; }
.woocommerce ul.products li.product .button,  
 .owl-item .item .cart .add_to_cart_button { background: #29B6F6 !important; }
.woocommerce ul.products li.product .button, .woocommerce ul.products li.product .button:hover, .owl-item .item .cart .add_to_cart_button { border: 1px solid #29B6F6 !important; }
.woocommerce ul.products li.product, 
.woocommerce-page ul.products li.product { background-color: #ffffff; }
.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt { background-color: #29B6F6; }
.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover {
    background-color: #29B6F6;
    color: #fff;
}
.woocommerce .star-rating span { color: #29B6F6; }
.woocommerce ul.products li.product:before, .woocommerce ul.products li.product:after, .woocommerce-page ul.products li.product:before, .woocommerce-page ul.products li.product:after {
    content: "";
    position: absolute;
    z-index: -1;
    top: 50%;
    bottom: 0;
    /* left: 10px; */
    right: 10px;
    -moz-border-radius: 100px / 10px;
    border-radius: 100px / 10px;
}
.woocommerce ul.products li.product:before, .woocommerce ul.products li.product:after, .woocommerce-page ul.products li.product:before, .woocommerce-page ul.products li.product:after {
    -webkit-box-shadow: 0 0 15px rgba(0,0,0,0.8);
    -moz-box-shadow: 0 0 15px rgba(0,0,0,0.8);
    box-shadow: 0 0 15px rgba(0,0,0,0.8);
}
.woocommerce a.remove, .woocommerce .woocommerce-Button, .woocommerce .cart input.button, .woocommerce input.button.alt, .woocommerce button.button, .woocommerce #respond input#submit, .woocommerce .cart input.button:hover, 
.woocommerce .cart input.button:focus, 
.woocommerce input.button.alt:hover, 
.woocommerce input.button.alt:focus, 
.woocommerce input.button:hover, 
.woocommerce input.button:focus, 
.woocommerce button.button:hover, 
.woocommerce button.button:focus, 
.woocommerce #respond input#submit:hover, 
.woocommerce #respond input#submit:focus, 
.woocommerce ul.products li.product:hover .button, 
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce .return-to-shop a.button  { color: #ffffff !important; }
.woocommerce div.product form.cart .button, .woocommerce a.button, .woocommerce a.button:hover, .woocommerce a.button, .woocommerce .woocommerce-Button, .woocommerce .cart input.button, .woocommerce input.button.alt, .woocommerce button.button, .woocommerce #respond input#submit, .woocommerce .cart input.button:hover, .woocommerce .cart input.button:focus, 
.woocommerce input.button.alt:hover, .woocommerce input.button.alt:focus, 
.woocommerce input.button:hover, .woocommerce input.button:focus, 
.woocommerce button.button:hover, .woocommerce button.button:focus, 
.woocommerce #respond input#submit:hover, .woocommerce #respond input#submit:focus, 
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button { background: #29B6F6; border: 1px solid transparent !important; }
.woocommerce-product-search button[type="submit"] {
    background-color: #29B6F6;
    border: 2px solid #29B6F6;
}
.widget.woocommerce.widget_product_search .woocommerce-product-search button[type="submit"]:hover {
    background: #29B6F6;
}
.woocommerce-message, .woocommerce-info {
    border-top-color: #29B6F6;
}
.woocommerce-message::before, .woocommerce-info::before { color: #29B6F6; }
.woocommerce div.product div.summary {
    margin-bottom: 2em;
    padding: 0;
    background-color: #fff;
}

.woocommerce ul.products li.product .onsale, .woocommerce span.onsale {
	background-color: #29B6F6;
	border: none;
	color:#fff
}

.products .onsale {
	background-color: #29B6F6;
}

.price_label { color: #727272; }
.woocommerce a.added_to_cart { background: #21202e; border: 1px solid #ffffff; }
.woocommerce a.button { border-radius: 0px; box-shadow: none; }
.woocommerce #reviews #comments ol.commentlist li .comment-text { border: 1px solid #e4e1e3; }
.woocommerce #reviews #comments ol.commentlist li .meta time { color: #8f969c; }
.woocommerce #review_form #respond textarea, .woocommerce-cart table.cart td.actions .coupon .input-text { border: 1px solid #eee; }
.woocommerce-error, .woocommerce-info, .woocommerce-message { background-color: #fbfbfb; box-shadow: 0 7px 3px -5px #e0e0e0; }
.woocommerce table.shop_table, .woocommerce table.shop_table td { border: 1px solid rgba(0, 0, 0, .1); }
.woocommerce table.shop_table th { background-color: #fbfbfb; }
#add_payment_method table.cart img, .woocommerce-cart table.cart img, .woocommerce-checkout table.cart img { border: 4px double #eee; }
.woocommerce a.remove { background: #555555; }
.woocommerce .checkout_coupon input.button, 
.woocommerce .woocommerce-MyAccount-content input.button, .woocommerce .login input.button { background-color: #29B6F6; color: #ffffff; border: 1px solid transparent; }
.woocommerce-page #payment #place_order { border: 1px solid transparent; }
.select2-container .select2-choice, .select2-drop-active, .woocommerce .woocommerce-ordering select, .woocommerce .widget select { 
    border: 1px solid #eee;
}
.woocommerce-checkout #payment ul.payment_methods { background-color: #fbfbfb; border: 1px solid rgba(0, 0, 0, .1); }
#add_payment_method #payment div.payment_box, .woocommerce-cart #payment div.payment_box, .woocommerce-checkout #payment div.payment_box { background-color: #ebe9eb; }
#add_payment_method #payment div.payment_box:before, 
.woocommerce-cart #payment div.payment_box:before, 
.woocommerce-checkout #payment div.payment_box:before { 
    border: 1em solid #ebe9eb;
    border-right-color: transparent;
    border-left-color: transparent;
    border-top-color: transparent;
}   
.woocommerce nav.woocommerce-pagination ul li a, 
.woocommerce nav.woocommerce-pagination ul li span { background-color: #f5f6f9;
    border: 1px solid #e9e9e9; color: #2a2e34; }
.woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current { background-color: #29B6F6; border: 1px solid #29B6F6; color: #ffffff; }
.woocommerce-MyAccount-navigation ul li { border-bottom: 1px solid #ebe9eb; }
.woocommerce-EditAccountForm input.woocommerce-Button { border: 1px solid #ffffff; }
.ui-slider .ui-slider-handle {
    border: 1px solid rgba(0, 0, 0, 0.25);
    background: #e7e7e7;
    background: -webkit-gradient(linear,left top,left bottom,from(#FEFEFE),to(#e7e7e7));
    background: -webkit-linear-gradient(#FEFEFE,#e7e7e7);
    background: -moz-linear-gradient(center top,#FEFEFE 0%,#e7e7e7 100%);
    background: -moz-gradient(center top,#FEFEFE 0%,#e7e7e7 100%);
    -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.65) inset;
    -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.65) inset;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.65) inset;
}
.price_slider_wrapper .ui-widget-content {
    background: #1e1e1e;
    background: -webkit-gradient(linear,left top,left bottom,from(#1e1e1e),to(#6a6a6a));
    background: -webkit-linear-gradient(#1e1e1e,#6a6a6a);
    background: -moz-linear-gradient(center top,#1e1e1e 0%,#6a6a6a 100%);
    background: -moz-gradient(center top,#1e1e1e 0%,#6a6a6a 100%);
}
.sidebar-widget .widget-title { border-bottom: 2px solid #eeeeee; }
.sidebar-widget .woocommerce ul.cart_list li { border-bottom: 1px dotted #d1d1d1; }
.woocommerce div.product .woocommerce-tabs .panel { background: #fff; border: 1px solid #eee; }
.woocommerce .widget_price_filter .ui-slider .ui-slider-range { background-color: #29B6F6; }
.add-to-cart a.added_to_cart, 
.add-to-cart a.added_to_cart:hover, 
.add-to-cart a.added_to_cart:focus { 
	background: #29B6F6;
}

/*===================================================================================*/
/*	WOOCOMMERCE PRODUCT CAROUSEL
/*===================================================================================*/

.product_container { background-color: #ffffff; border: 1px solid #eee; }
.wpcs_product_carousel_slider .owl-item .item h4.product_name, .wpcs_product_carousel_slider .owl-item .item h4.product_name a, 
.wpcs_product_carousel_slider .owl-item .item .cart .add_to_cart_button { color: #0f0f16 !important; }
.wpcs_product_carousel_slider .owl-item .item .cart:hover .add_to_cart_button,
.testimonial-section .wpcs_product_carousel_slider .title, .top-header-detail .wpcs_product_carousel_slider .title { color: #ffffff !important; }
.woocommerce.rating span {
    color: #29B6F6;
}

/*Woocommerce Section----------------------------------------------------------------------------------------*/
.woocommerce-section {  background-color: #29B6F6; }
.rating li i { color: #29B6F6; }

#wooproduct-slider .owl-prev:hover,
#wooproduct-slider .owl-next:hover {
	background-color: #29B6F6; 
	color: #fff;
}
.cart-header > a .cart-total { background-color: #29B6F6; }
</style>