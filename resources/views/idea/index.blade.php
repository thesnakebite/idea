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
                                class="w-full h-80 object-cover"
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

    <x-idea.modal />
</x-layout>
