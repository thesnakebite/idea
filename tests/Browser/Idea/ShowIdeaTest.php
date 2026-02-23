<?php

use App\Models\Idea;
use App\Models\User;

it('must be signed in to view an idea', function () {
    $idea = Idea::factory()->create();

    $this->get(route('idea.show', $idea))->assertRedirectToRoute('login');
});

it('disallows accessing an idea you did not create authentication', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $idea = Idea::factory()->create();

    $this->get(route('idea.show', $idea))->assertForbidden();
});
