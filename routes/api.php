<?php

use Illuminate\Support\Facades\Route;
use Module\Training\Http\Controllers\DashboardController;
use Module\Training\Http\Controllers\TrainingEventController;
use Module\Training\Http\Controllers\TrainingHistoryController;
use Module\Training\Http\Controllers\TrainingPostestController;
use Module\Training\Http\Controllers\TrainingPretestController;
use Module\Training\Http\Controllers\TrainingRundownController;
use Module\Training\Http\Controllers\TrainingSettingController;
use Module\Training\Http\Controllers\TrainingVillageController;
use Module\Training\Http\Controllers\TrainingPresenceController;
use Module\Training\Http\Controllers\TrainingCommitteeController;
use Module\Training\Http\Controllers\TrainingParticipantController;
use Module\Training\Http\Controllers\TrainingSubdistrictController;
use Module\Training\Http\Controllers\TrainingHistoryPostestController;
use Module\Training\Http\Controllers\TrainingHistoryPretestController;
use Module\Training\Http\Controllers\TrainingHistoryRundownController;
use Module\Training\Http\Controllers\TrainingHistoryPresenceController;
use Module\Training\Http\Controllers\TrainingHistoryCommitteeController;
use Module\Training\Http\Controllers\TrainingHistoryParticipantController;

Route::get('dashboard', [DashboardController::class, 'index']);
Route::get('report', [DashboardController::class, 'report']);

Route::post('event/{trainingEvent}/submission', [TrainingEventController::class, 'submission']);
Route::resource('event', TrainingEventController::class)
    ->parameters(['event' => 'trainingEvent']);

Route::resource('event.participant', TrainingParticipantController::class)
    ->parameters([
        'event' => 'trainingEvent',
        'participant' => 'trainingParticipant'
    ]);

Route::resource('event.committee', TrainingCommitteeController::class)
    ->parameters([
        'event' => 'trainingEvent',
        'committee' => 'trainingCommittee'
    ]);

Route::resource('event.rundown', TrainingRundownController::class)
    ->parameters([
        'event' => 'trainingEvent',
        'rundown' => 'trainingRundown'
    ]);

Route::resource('event.pretest', TrainingPretestController::class)
    ->parameters([
        'event' => 'trainingEvent',
        'pretest' => 'trainingQuestion'
    ]);

Route::resource('event.postest', TrainingPostestController::class)
    ->parameters([
        'event' => 'trainingEvent',
        'postest' => 'trainingQuestion'
    ]);

Route::resource('event.presence', TrainingPresenceController::class)
    ->parameters([
        'event' => 'trainingEvent',
        'presence' => 'trainingPresence'
    ]);

Route::resource('history', TrainingHistoryController::class)
    ->parameters(['history' => 'trainingEvent']);

Route::resource('history.participant', TrainingHistoryParticipantController::class)
    ->parameters([
        'history' => 'trainingEvent',
        'participant' => 'trainingParticipant'
    ]);

Route::resource('history.committee', TrainingHistoryCommitteeController::class)
    ->parameters([
        'history' => 'trainingEvent',
        'committee' => 'trainingCommittee'
    ]);

Route::resource('history.rundown', TrainingHistoryRundownController::class)
    ->parameters([
        'history' => 'trainingEvent',
        'rundown' => 'trainingRundown'
    ]);

Route::resource('history.pretest', TrainingHistoryPretestController::class)
    ->parameters([
        'history' => 'trainingEvent',
        'pretest' => 'trainingQuestion'
    ]);

Route::resource('history.postest', TrainingHistoryPostestController::class)
    ->parameters([
        'history' => 'trainingEvent',
        'postest' => 'trainingQuestion'
    ]);

Route::resource('history.presence', TrainingHistoryPresenceController::class)
    ->parameters([
        'history' => 'trainingEvent',
        'presence' => 'trainingPresence'
    ]);

Route::get('subdistrict/{trainingSubdistrict}/villages', [TrainingSubdistrictController::class, 'villages']);
Route::resource('subdistrict', TrainingSubdistrictController::class)
    ->parameters(['subdistrict' => 'trainingSubdistrict']);

Route::get('village/{trainingVillage}/particiables', [TrainingVillageController::class, 'particiables']);
Route::resource('subdistrict.village', TrainingVillageController::class)
    ->parameters([
        'subdistrict' => 'trainingSubdistrict',
        'village' => 'trainingVillage'
    ]);

Route::resource('setting', TrainingSettingController::class)
    ->parameters(['setting' => 'trainingSetting']);
