<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Modules\App\Profile\Entities\Participant;
use Modules\App\Profile\Entities\Profile;
use Modules\Backend\RAMPManagement\Entities\Event;
use Modules\Backend\RAMPManagement\Entities\Programme;
use Modules\Backend\RAMPManagement\Entities\Vertical;

Breadcrumbs::for('app', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('app.index'));
});

Breadcrumbs::for('app.profile', function (BreadcrumbTrail $trail) {
	$trail->parent('app');
    $trail->push('Profile', route('app.profile.index'));
});

Breadcrumbs::for('app.profile.create', function (BreadcrumbTrail $trail) {
	$trail->parent('app.profile');
    $trail->push('Create', route('app.profile.create'));
});

Breadcrumbs::for('app.profile.edit', function (BreadcrumbTrail $trail, Profile $profile) {
	$trail->parent('app.profile');
	$trail->push('Edit '.ucwords($profile->type->value).' Profile');
    $trail->push($profile['id'], route('app.profile.edit', [
		'profile' 	=> $profile['id']
	]));
});

Breadcrumbs::for('app.profile.show', function (BreadcrumbTrail $trail, Profile $profile) {
	$trail->parent('app.profile');
	$trail->push('View '.ucwords($profile->type->value).' Profile');
    $trail->push($profile['id'], route('app.profile.show', [
		'profile' 	=> $profile['id']
	]));
});

Breadcrumbs::for('app.participant', function (BreadcrumbTrail $trail) {
	$trail->parent('app');
	$trail->push('Participants', route('app.participant.index'));
});

Breadcrumbs::for('app.participant.create', function (BreadcrumbTrail $trail) {
	$trail->parent('app.participant');
    $trail->push('Create', route('app.participant.create'));
});

Breadcrumbs::for('app.participant.edit', function (BreadcrumbTrail $trail, Participant $participant) {
	$trail->parent('app.participant');
	$trail->push('Edit Participant');
    $trail->push($participant['id'], route('app.participant.edit', [
		'participant' 	=> $participant['id']
	]));
});

Breadcrumbs::for('backend', function (BreadcrumbTrail $trail) {
    $trail->push('Backend', route('backend.dashboard'));
});

Breadcrumbs::for('backend.bulk.import.create', function (BreadcrumbTrail $trail, $model, $studly) {
	$trail->parent('backend');
    $trail->push('Bulk');
    $trail->push('Import');
    $trail->push(\Illuminate\Support\Str::studly($model), route('backend.bulk.import.create', ['model' => $model]));
});

Breadcrumbs::for('backend.moderation', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push('Moderation', route('backend.moderation.index'));
});

Breadcrumbs::for('backend.moderation.profile', function (BreadcrumbTrail $trail) {
	$trail->parent('backend.moderation');
    $trail->push('Profile', route('app.profile.index'));
});

Breadcrumbs::for('backend.moderation.profile.edit', function (BreadcrumbTrail $trail, Profile $profile) {
	$trail->parent('backend.moderation.profile');
	$trail->push('Edit '.ucwords($profile->type->value).' Profile');
    $trail->push($profile['id']);
});

Breadcrumbs::for('backend.rampmanagement', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push('RAMP Management', route('backend.rampmanagement.dashboard.index'));
});

Breadcrumbs::for('backend.rampmanagement.verticals', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.rampmanagement');
    $trail->push('Verticals', route('backend.rampmanagement.verticals.index'));
});

Breadcrumbs::for('backend.rampmanagement.verticals.create', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.rampmanagement.verticals');
    $trail->push('Create', route('backend.rampmanagement.verticals.create'));
});

Breadcrumbs::for('backend.rampmanagement.verticals.edit', function (BreadcrumbTrail $trail, Vertical $vertical) {
    $trail->parent('backend.rampmanagement.verticals');
	$trail->push('Edit');
    $trail->push($vertical['id'], route('backend.rampmanagement.verticals.edit', ['vertical' => $vertical['id']]));
});

Breadcrumbs::for('backend.rampmanagement.programmes', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.rampmanagement');
    $trail->push('Programmes', route('backend.rampmanagement.programmes.index'));
});

Breadcrumbs::for('backend.rampmanagement.programmes.create', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.rampmanagement.programmes');
    $trail->push('Create', route('backend.rampmanagement.programmes.create'));
});

Breadcrumbs::for('backend.rampmanagement.programmes.edit', function (BreadcrumbTrail $trail, Programme $programme) {
    $trail->parent('backend.rampmanagement.programmes');
	$trail->push('Edit');
    $trail->push($programme['id'], route('backend.rampmanagement.programmes.edit', ['programme' => $programme['id']]));
});

Breadcrumbs::for('backend.rampmanagement.events', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.rampmanagement');
    $trail->push('Events', route('backend.rampmanagement.events.index'));
});

Breadcrumbs::for('backend.rampmanagement.events.create', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.rampmanagement.events');
    $trail->push('Create', route('backend.rampmanagement.events.create'));
});

Breadcrumbs::for('backend.rampmanagement.events.edit', function (BreadcrumbTrail $trail, Event $event) {
    $trail->parent('backend.rampmanagement.events');
	$trail->push('Edit');
    $trail->push($event['id'], route('backend.rampmanagement.events.edit', ['event' => $event['id']]));
});

Breadcrumbs::for('backend.rampmanagement.events.registrations', function (BreadcrumbTrail $trail, Event $event) {
	$trail->parent('backend.rampmanagement.events');
	$trail->push($event->name);
	$trail->push('Registrations', route('backend.rampmanagement.events.registrations.index', ['event' => $event->id]));
});

Breadcrumbs::for('backend.rampmanagement.events.registrations.create', function (BreadcrumbTrail $trail, Event $event) {
    $trail->parent('backend.rampmanagement.events.registrations', $event);
	$trail->push('Upload');
});

Breadcrumbs::for('backend.rampmanagement.enterprises', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.rampmanagement');
    $trail->push('Enterprises', route('backend.rampmanagement.enterprises.index'));
});

Breadcrumbs::for('backend.rampmanagement.registrations', function (BreadcrumbTrail $trail) {
	$trail->parent('backend.rampmanagement');
	$trail->push('Registrations', route('backend.rampmanagement.registrations.index'));
});


