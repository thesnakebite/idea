<x-layout>
    <div class="text-muted-foreground">
        {{-- Header --}}
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Ideas</h1>
            <p class="text-muted-foreground text-sm mt-2">Capture your thoughts. Make a plan.</p>

            <x-card
                x-data
                @click="$dispatch('open-modal', 'create-idea')"
                is="button"
                type="button"
                data-test="create-idea-button"
                class="mt-10 cursor-pointer h-32 w-full text-left align-text-top"
            >
                <p>What's the idea</p>
            </x-card>
        </header>

        {{-- Filtered --}}
        <div class="flex items-center justify-center space-x-3">
            <a href="/ideas" class="btn {{ request()->has('status') ? 'btn-outlined' : '' }}">All</a>

            @foreach (App\IdeaStatus::cases() as $status)
                <a href="/ideas?status={{ $status->value }}"
                    class="btn {{ request('status') === $status->value ? '' : 'btn-outlined' }}">
                    {{ $status->label() }} <span class="text-xs pl-2">
                        {{ $statusCounts->get($status->value) }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>

    <div class="mt-10">
        <div class="grid md:grid-cols-2 gap-6">
            @forelse ($ideas as $idea)
                <x-card href="{{ route('idea.show', $idea) }}">
                    @if ($idea->image_path)
                        <div class="mb-4 -mx-4 -mt-4 rounded-t-lg overflow-hidden">
                            <img
                                src="{{ asset('storage/' . $idea->image_path) }}"
                                alt="{{ $idea->title }}"
                                class="w-full h-auto object-cover"
                            />
                        </div>
                    @endif
                    <h3 class="text-foreground text-lg">{{ $idea->title }}</h3>

                    <div class="mt-1">
                        <x-idea.status-label status="{{ $idea->status }}">
                            {{ $idea->status->label() }}
                        </x-idea.status-label>
                    </div>

                    <div class="mt-5 line-clamp-3">{{ $idea->description }}</div>
                    <div class="text-muted-foreground text-xs mt-5">{{ $idea->created_at->diffForHumans() }}</div>
                </x-card>
            @empty
                <x-card class="md:col-span-2 flex justify-center items-center border border-primary/50">
                    <div class="inline-flex items-center gap-2">
                        <x-hugeicons-bookmark-remove-01 class="size-7" />
                        <p class="text-sm text-amber-500">No ideas at this time.</p>
                    </div>
                </x-card>
            @endforelse
        </div>
    </div>

    <!-- Modal -->
    <x-modal name="create-idea" title="New Idea">
        <form
            x-data="{
                status: 'pending',
                newLink: '',
                links: [],
                newStep: '',
                steps: [],
                hasImage: false
            }"
            method="POST"
            action="{{ route('idea.store') }}"
            x-bind:enctype="hasImage ? 'multipart/form-data' : false"
        >
            @csrf

            <div class="space-y-6">
                {{-- Title --}}
                <x-form.field
                    label="Title"
                    name="title"
                    placeholder="Enter an idea for your title"
                    autofocus
                    required
                />

                {{-- Status --}}
                <div class="space-y-2">
                    <label for="status" class="label">Status</label>

                    <div class="flex gap-x-3">
                        @foreach (App\IdeaStatus::cases() as $status)
                            <button class="btn flex-1 h-10" @click = "status = @js($status->value)"
                                type="button" data-test="button-status-{{ $status->value }}"
                                :class="{ 'btn-outlined': status !== @js($status->value) }">
                                {{ $status->label() }}
                            </button>
                        @endforeach
                        <input type="hidden" name="status" :value="status" class="input" />
                    </div>

                    <x-form.error name="status" />
                </div>

                {{-- Description --}}
                <x-form.field
                    label="Description"
                    name="description"
                    type="textarea"
                    placeholder="Describe your idea..."
                />

                {{-- Image --}}
                <div class="space-y-2">
                    <label for="image" class="label">Featured Image</label>

                    <input type="file" id="image" name="image" accept="image/*" @change="hasImage = true" />
                    <x-form.error name="image" />
                </div>

                {{-- Steps --}}
                <div>
                    <fieldset class="space-y-3">
                        <legend class="label">Actionable Steps</legend>

                        <template x-for="(step, index) in steps" :key="step">
                            <div class="flex gap-x-2 items-center">
                                <label for="" class="sr-only text-xs">Steps</label>
                                <input name="steps[]" x-model="step" class="input text-primary" readonly>
                                <button type="button" aria-label="Remove step" @click="steps.splice(index, 1)"
                                    class="form-muted-icon">
                                    <x-hugeicons-minus-sign class="form-muted-icon" />
                                </button>
                            </div>
                        </template>

                        <div class="flex gap-x-2 items-center">
                            <input
                                x-model="newStep"
                                id="new-step"
                                data-test="new-step"
                                placeholder="What needs to be done?"
                                class="input flex-1"
                                spellcheck="false"
                            />

                            <button
                                type="button" @click="steps.push(newStep.trim()); newStep = '';"
                                data-test="submit-new-step-button"
                                :disabled="newStep.trim().length === 0"
                                aria-label="Add a new step"
                            >
                                <x-hugeicons-plus-sign class="form-muted-icon" />
                            </button>
                        </div>
                    </fieldset>
                </div>

                {{-- Links --}}
                <div>
                    <fieldset class="space-y-3">
                        <legend class="label">Links</legend>

                        <template x-for="(link, index) in links" :key="link">
                            <div class="flex gap-x-2 items-center">
                                <label for="" class="sr-only text-xs">Links</label>
                                <input name="links[]" x-model="link" class="input text-primary ">
                                <button
                                    type="button"
                                    aria-label="Remove link"
                                    @click="links.splice(index, 1)"
                                    class="form-muted-icon"
                                >
                                    <x-hugeicons-minus-sign class="form-muted-icon" />
                                </button>
                            </div>
                        </template>

                        <div class="flex gap-x-2 items-center">
                            <input
                                x-model="newLink"
                                type="url"
                                id="new-link"
                                data-test="new-link"
                                placeholder="https://example.com"
                                autocomplete="url"
                                class="input flex-1"
                                spellcheck="false"
                            />

                            <button
                                type="button"
                                @click="links.push(newLink.trim()); newLink = '';"
                                data-test="submit-new-link-button"
                                :disabled="newLink.trim().length === 0"
                                aria-label="Add a new link"
                            >
                                <x-hugeicons-plus-sign class="form-muted-icon" />
                            </button>
                        </div>
                    </fieldset>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-x-5">
                    <button type="button" class="btn btn-outlined" @click="$dispatch('close-modal')">Cancel</button>
                    <button type="submit" data-test="submit-idea" class="btn">Create</button>
                </div>
            </div>
        </form>
    </x-modal>
</x-layout>
