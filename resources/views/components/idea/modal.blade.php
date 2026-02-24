@props(['idea' => new App\Models\Idea()])

<x-modal
    name="{{ $idea->exists ? 'edit-idea' : 'create-idea' }}"
    title="{{ $idea->exists ? 'Edit Idea' : 'New Idea' }}"
>
    <form
        x-data="{
            status: @js(old('status', $idea->status->value)),
            newLink: '',
            links: @js(old('links', $idea->links ?? [])),
            newStep: '',
            steps: @js(old('steps', $idea->steps->map->only(['id', 'description', 'completed']))),
            hasImage: false
        }"
        method="POST"
        action="{{ $idea->exists ? route('idea.update', $idea) : route('idea.store') }}"
        x-bind:enctype="hasImage ? 'multipart/form-data' : false"
    >
        @csrf

        @if ($idea->exists)
            @method('PATCH')
        @endif

        <div class="space-y-6">
            {{-- Title --}}
            <x-form.field
                label="Title"
                name="title"
                placeholder="Enter an idea for your title"
                autofocus
                required
                :value="$idea->title"
            />

            {{-- Status --}}
            <div class="space-y-2">
                <label for="status" class="label">Status</label>

                <div class="flex gap-x-3">
                    @foreach (App\IdeaStatus::cases() as $status)
                        <button
                            class="btn flex-1 h-10"
                            @click= "status = @js($status->value)"
                            type="button"
                            data-test="button-status-{{ $status->value }}"
                            :class="{ 'btn-outlined': status !== @js($status->value) }"
                        >
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
                :value="$idea->description"
            />

            {{-- Image --}}
            <div class="space-y-2">
                <label for="image" class="label">Featured Image</label>

                @if ($idea->image_path)
                    <div class="space-y-2.5">
                        <img
                            src="{{ asset('storage/' . $idea->image_path) }}"
                            alt="{{ $idea->title }}"
                            class="opacity-50 w-full h-48 object-cover"
                        >
                        <button
                            class="btn btn-outlined hover:bg-red-500 w-full h-8"
                            form="delete-image-idea"
                        >
                            Remove Image
                        </button>
                    </div>
                @endif

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/*"
                    @change="hasImage = true"
                />
                <x-form.error name="image" />
            </div>

            {{-- Steps --}}
            <div>
                <fieldset class="space-y-3">
                    <legend class="label">Actionable Steps</legend>

                    <template x-for="(step, index) in steps" :key="step.id || index">
                        <div class="flex gap-x-2 items-center">
                            <input
                                :name="`steps[${index}][description]`"
                                x-model="step.description"
                                class="input text-primary"
                                readonly
                            >
                            <input
                                type="hidden"
                                :name="`steps[${index}][completed]`"
                                :value="step.completed ? '1' : '0'"
                                class="input text-primary"
                                readonly
                            >
                            <button
                                type="button"
                                aria-label="Remove step"
                                @click="steps.splice(index, 1)"
                                class="form-muted-icon"
                            >
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
                            type="button"
                            @click="steps.push({description: newStep.trim(), completed:false}); newStep='';"
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
                            <input
                                name="links[]"
                                x-model="link"
                                class="input text-primary"
                                readonly
                            >
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
                <button
                    type="button"
                    class="btn btn-outlined"
                    @click="$dispatch('close-modal')"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="btn"
                >
                    {{ $idea->exists ? 'Update' : 'Create' }}
                </button>
            </div>
        </div>
    </form>

    {{-- Remove image idea --}}
    @if ($idea->image_path)
        <form method="POST" action="{{ route('idea.image.destroy', $idea) }}" id="delete-image-idea">
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-modal>
