<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Modules\Backend\RAMPManagement\Entities\Event;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('app.registry.index'));
});

Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
	$trail->parent('home');
    $trail->push('Profile', route('app.profile.index'));
});

Breadcrumbs::for('profile.create', function (BreadcrumbTrail $trail) {
	$trail->parent('profile');
    $trail->push('Create', route('app.profile.create'));
});

Breadcrumbs::for('profile.edit', function (BreadcrumbTrail $trail, $profile_type, $profile_id) {
	$trail->parent('profile');
	$trail->push('Edit');
	$trail->push(ucwords($profile_type));
    $trail->push($profile_id, route('app.profile.edit', [
		'profile_type'	=> $profile_type, 
		'profile_id' 	=> $profile_id
	]));
});

Breadcrumbs::for('profile.show', function (BreadcrumbTrail $trail, $profile_type, $profile_id) {
	$trail->parent('profile');
	$trail->push('Show');
	$trail->push(ucwords($profile_type));
    $trail->push($profile_id, route('app.profile.edit', [
		'profile_type'	=> $profile_type, 
		'profile_id' 	=> $profile_id
	]));
});

Breadcrumbs::for('ramp', function (BreadcrumbTrail $trail) {
	$trail->parent('home');
	$trail->push('RAMP');
});

Breadcrumbs::for('ramp.apply.index', function (BreadcrumbTrail $trail) {
	$trail->parent('ramp');
	$trail->push('Apply', route('app.ramp.apply.index'));
});

Breadcrumbs::for('ramp.apply.create', function (BreadcrumbTrail $trail, Event $event) {
	$trail->parent('ramp.apply.index');
    $trail->push($event['name'], route('app.ramp.apply.index', ['event' => $event['id']]));
});



