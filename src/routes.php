<?php

/**
 * Created by PhpStorm.
 * User: neil
 * Date: 26/11/2016
 * Time: 00:14.
 */
$app->get('/', 'VinylStore\\Controllers\\MainController::indexAction');
$app->get('/home', 'VinylStore\\Controllers\\MainController::indexAction');
$app->get('/login', 'VinylStore\\Controllers\\LoginController::loginAction');
$app->get('/vinyl/{genre}/{artist}/{title}/{id}', 'VinylStore\\Controllers\\MainController::getReleaseByIdAction');
$app->get('/vinyl', 'VinylStore\\Controllers\\MainController::getVinylAction');
$app->get('/vinyl/{genre}', 'VinylStore\\Controllers\\MainController::getGenreAction');
$app->get('/vinyl/{genre}/page/{page}', 'VinylStore\\Controllers\\MainController::getGenreAction')->value('page', 1);
$app->match('/refine', 'VinylStore\\Controllers\\MainController::refineAction');
$app->get('/faq', 'VinylStore\\Controllers\\MainController::faqAction');
$app->post('/contact', 'VinylStore\\Controllers\\ContactFormController::sendContactFormAction');
$app->get('/randomise', 'VinylStore\\Controllers\\RandomiseController::randomiseAction');
$app->get('/vinyl/page/{page}', 'VinylStore\\Controllers\\MainController::getVinylAction')->value('page', '1');
$app->post('/snip-webhook', 'VinylStore\\Controllers\\SnipCartController::getWebHookAction');
$app->post('/snip-shippingRates-webhook', 'VinylStore\\Controllers\\SnipCartController::getShippingRatesAction');
$app->post('/events/item-added', 'VinylStore\\Controllers\\SnipCartController::eventItemAddedAction');
$app->get('/tracklist', 'VinylStore\\Controllers\\TracklistController::getTracklistAction');
$app->get('/admin/dashboard', 'VinylStore\\Controllers\\LoginController::dashboardAction');
$app->get('/admin/view-releases', 'VinylStore\\Controllers\\ReleaseController::getReleasesAction');
$app->match('/admin/create-release', 'VinylStore\\Controllers\\ReleaseController::createReleaseAction');
$app->match('/admin/edit-release/{id}', 'VinylStore\\Controllers\\ReleaseController::editReleaseAction');
$app->match('/admin/upload-image', 'VinylStore\\Controllers\\ImageController::uploadImageAction');
$app->get('/admin/view-images', 'VinylStore\\Controllers\\ImageController::viewImagesAction');
$app->get('/admin/delete-image/{id}', 'VinylStore\\Controllers\\ImageController::deleteImageAction');
$app->post('/admin/attach-image/{imageId}/{releaseId}', 'VinylStore\\Controllers\\ImageController::attachImageAction');
$app->match('/admin/create-pricing', 'VinylStore\\Controllers\\PricingController::indexAction');
$app->get('/admin/view-pricing', 'VinylStore\\Controllers\\PricingController::viewPricingAction');
$app->match('/admin/edit-pricing/{id}', 'VinylStore\\Controllers\\PricingController::editPricingAction');
$app->get('/admin/view-shippingRates', 'VinylStore\\Controllers\\ShippingController::viewShippingRatesAction');
$app->match('/admin/shippingRates', 'VinylStore\\Controllers\\ShippingController::shippingRatesAction');
$app->match('/admin/edit-shippingRates/{quantity}', 'VinylStore\\Controllers\\ShippingController::editShippingRatesAction');
