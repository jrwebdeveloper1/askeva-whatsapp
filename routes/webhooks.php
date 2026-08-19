<?php

use Illuminate\Support\Facades\Route;
use Askeva\WhatsApp\Http\Controllers\AskevaWebhookController;

Route::get('/askeva/webhook', [AskevaWebhookController::class, 'verify'])->name('askeva.webhook.verify');
Route::post('/askeva/webhook', [AskevaWebhookController::class, 'handle'])->name('askeva.webhook.handle');
