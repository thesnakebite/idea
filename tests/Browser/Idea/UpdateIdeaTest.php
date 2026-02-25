<?php

use App\Models\Idea;
use App\Models\Step;
use App\Models\User;

it('shows the input state', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()
        ->for($user)
        ->has(Step::factory()->count(1))
        ->create();

    $idea = $idea->fresh(['steps']);

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->assertValue('title', $idea->title)
        ->assertValue('description', $idea->description)
        ->assertValue('status', $idea->status->value)
        ->assertValue('links[]', $idea->links[0])
        ->assertValue('@step-description-0', $idea->steps->first()->description);
});

it('edits an existing idea', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->fill('title', 'Some Example Title')
        ->click('@button-status-completed')
        ->fill('description', 'An example description')
        ->fill('@new-link', 'https://laracasts.com')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'Do a thing')
        ->click('@submit-new-step-button')
        ->click('Update')
        ->assertRoute('idea.show', [$idea]);

    expect($idea = $user->ideas()->first())->not->toBeNull();

    expect($idea)->toMatchArray([
        'title' => 'Some Example Title',
        'status' => 'completed',
        'description' => 'An example description',
        'links' => [$idea->links[0], 'https://laracasts.com'],
    ]);

    expect($idea->steps)->toHaveCount(1);
});
