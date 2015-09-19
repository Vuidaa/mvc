<?php 

//Route must be define in following format: 'route/name/{param}' => ['RouteController', 'routeMethod'],

return 
[
	'/' 				=> ['HomeController', 		'index'],
	'contact-us'		=> ['HomeController', 		'contact'],
	'gallery'			=> ['GalleryController', 	'index'],
];