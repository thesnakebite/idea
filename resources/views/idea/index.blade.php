<x-layout>
    <div class="text-muted-foreground">
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Ideas</h1>
            <p class="text-muted-foreground text-sm mt-2">Capture your thoughts. Make a plan.</p>

            <x-card
                x-data @click="$dispatch('open-modal', 'create-idea')"
                is="button"
                type="button"
                class="mt-10 cursor-pointer h-32 w-full text-left align-text-top"
            >
                <p>What's the idea</p>
            </x-card>
        </header>

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

        <div class="mt-10">
            <div class="grid md:grid-cols-2 gap-6">
                @forelse ($ideas as $idea)
                    <x-card href="{{ route('idea.show', $idea) }}">
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
                    <div class="inline-flex items-center gap-2">
                        <x-hugeicons-bookmark-remove-01 class="size-7" />

                        <p class="text-sm text-amber-500">No ideas at this time.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal -->
    <x-modal name="create-idea" title="New Idea">
        <form method="POST" action="">
            @csrf
        </form>
    </x-modal>

</x-layout>
