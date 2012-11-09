jQuery('document').ready(function($) {
	setup_ajax_pagination();
});

function setup_ajax_pagination()
{
    jQuery.ias({
            container : '.post-list',
            item: '.post-item',
            pagination: '.pagination',
            next: '.next-link a',
            loader: '<img src="/img/loader.gif"/>'
    });
    jQuery.ias({
            container : '.page-comments',
            item: '.comment-item',
            pagination: '.pagination',
            next: '.next-link a',
            loader: '<img src="/img/loader.gif"/>'
    });
}