<x-layout>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="flex justify-between text-muted-foreground items-center">
            {{-- Breadcrumb--}}
            <a href="{{ route('idea.index') }}" class="flex items-center gap-x-2 text-sm font-medium">
                <x-hugeicons-square-arrow-left-03 class="size-7 hover:text-amber-500 transition-colors" />
                Back to Ideas
            </a>

            {{-- Acctions --}}
            <div class="gap-x-3 flex items-center">
                <button
                    x-data
                    class="btn btn-outlined"
                    @click="$dispatch('open-modal', 'edit-idea')"
                >
                    <x-hugeicons-ai-editing class="size-5" />
                    Edit Idea
                </button>
                <form method="POST" action="{{ route('idea.destroy', $idea) }}">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-outlined text-red-500">
                        <x-hugeicons-delete-put-back />
                        Delete
                    </button>
                </form>
            </div>
        </div>

        {{-- Card --}}
        <div class="mt-8 space-y-6">
            {{-- Image --}}
            @if ($idea->image_path)
                <div class="rounded-lg overflow-hidden">
                    <img
                        src="{{ asset('storage/' . $idea->image_path) }}"
                        alt="{{ $idea->title }}"
                        class="object-cover w-full h-96"
                    >
                </div>
            @endif
            {{-- Title --}}
            <h1 class="font-bold text-4xl mt-4">{{ $idea->title }}</h1>

            {{-- Status --}}
            <div class="mt-2 flex gap-x-3 items-center">
                <x-idea.status-label :status="$idea->status->value">
                    {{ $idea->status->label() }}
                </x-idea.status-label>

                <div class="text-muted-foreground text-xs">
                    {{ $idea->created_at->diffForHumans() }}
                </div>
            </div>

            {{-- Description --}}
            @if ($idea->description)
                <x-card class="mt-6">
                    <div class="text-foreground max-w-none">{{ $idea->description }}</div>
                </x-card>
            @endif

            {{-- Steps --}}
            @if ($idea->steps->count())
                <h3 class="font-bold text-xl mt-6 text-muted-foreground">Actionable Steps</h3>
                <div class="mt-2 space-y-2">
                    @foreach ($idea->steps as $step)
                        <div>
                            <form action="{{ route('step.update', $step) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="text-sm font-medium flex items-center gap-x-3">
                                    <button
                                        type="submit"
                                        aria-label="{{ $step->completed ? 'Mark as incomplete' : 'Mark as complete' }}"
                                        class="size-5 flex items-center justify-center rounded-lg border border-primary {{ $step->completed ? 'bg-primary text-primary-foreground' : 'text-transparent' }}"
                                    >
                                        &check;
                                    </button>
                                    <span
                                        class="{{ $step->completed ? 'line-through text-muted-foreground' : '' }}"
                                    >
                                        {{ $step->description }}
                                    </span>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Links --}}
            @if ($idea->links->count())
                <h3 class="font-bold text-xl mt-6 text-muted-foreground">Links</h3>
                <div>
                    @if ($idea->links->count())
                        <div class="mt-2 space-y-2">
                            @foreach ($idea->links as $link)
                                <x-card :href="$link" target="_blank"
                                    class="text-primary font-medium flex gap-x-3 items-center">
                                    <x-hugeicons-link-01 />
                                    {{ $link }}
                                </x-card>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>

    <x-idea.modal :idea="$idea" />
</x-layout>
