<?php

use App\Models\Idea;
use App\Models\User;

test('it belongs to a user', function () {

    $idea = Idea::factory()->create();

    expect($idea->user)->toBeInstanceOf(User::class);
});

test('it can have steps', function () {

    $idea = Idea::factory()->create();

    expect($idea->steps)->toBeEmpty();

    $idea->steps()->create([
        'description' => 'Do the thing',
    ]);

    expect($idea->fresh()->steps)->toHaveCount(1);
});

test('it can for a description using markdown', function () {
    $idea = new Idea(['description' => 'Hello Jeffrey Way']);

    expect($idea->formattedDescription)->toEqual("<p>Hello Jeffrey Way</p>\n");
});
