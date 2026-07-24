<?php

use Illuminate\Support\Facades\Route;
use Module\Training\Models\TrainingEvent;
use Module\Training\Models\TrainingParticipant;

function trainingDashboardUri(): string
{
    $route = collect(Route::getRoutes())->first(
        fn ($route) => str_contains($route->getActionName(), 'Training\Http\Controllers\DashboardController@index')
            && ! str_contains($route->getActionName(), 'MyTraining')
    );

    return '/' . ltrim($route->uri(), '/');
}

it('returns training KPI counts', function () {
    $baseline = [
        'total' => TrainingEvent::count(),
        'upcoming' => TrainingEvent::whereIn('status', ['ASSIGNED', 'PUBLISHED'])->where('startdate', '>=', now()->toDateString())->count(),
        'completed' => TrainingEvent::whereIn('status', ['COMPLETED', 'CERTIFIED'])->count(),
        'accepted' => TrainingParticipant::whereNotNull('accepted_at')->count(),
    ];

    TrainingEvent::factory()->upcoming()->count(2)->create();
    TrainingEvent::factory()->completed()->count(3)->create();

    $event = TrainingEvent::factory()->completed()->create();
    TrainingParticipant::factory()->accepted()->count(4)->create(['event_id' => $event->id]);
    TrainingParticipant::factory()->count(2)->create(['event_id' => $event->id]); // not accepted

    $user = licensedUser('training-superadmin');

    $response = $this->actingAs($user)->getJson(trainingDashboardUri());

    $response->assertOk();
    expect($response->json('record.totalEvents'))->toBe($baseline['total'] + 6);
    expect($response->json('record.upcomingEvents'))->toBe($baseline['upcoming'] + 2);
    expect($response->json('record.completedEvents'))->toBe($baseline['completed'] + 4);
    expect($response->json('record.acceptedParticipants'))->toBe($baseline['accepted'] + 4);
});
