<x-layout>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="flex justify-between text-muted-foreground items-center">
            <a href="{{ route('idea.index') }}" class="flex items-center gap-x-2 text-sm font-medium">
                <x-hugeicons-square-arrow-left-03 class="size-7 hover:text-amber-500 transition-colors" />
                Back to Ideas
            </a>

            <div class="gap-x-3 flex items-center">
                <button class="btn btn-outlined">
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

        <div class="mt-8 space-y-6">
            <h1 class="font-bold text-4xl mt-4">{{ $idea->title }}</h1>

            <div class="mt-2 flex gap-x-3 items-center">
                <x-idea.status-label :status="$idea->status->value">
                    {{ $idea->status->label() }}
                </x-idea.status-label>

                <div class="text-muted-foreground text-xs">
                    {{ $idea->created_at->diffForHumans() }}
                </div>
            </div>

            <x-card class="mt-6">
                <div class="text-foreground max-w-none">{{ $idea->description }}</div>
            </x-card>

            <h3 class="font-bold text-xl mt-6 text-muted-foreground">Links</h3>
            <div>
                @if ($idea->links->count())
                    <div class="mt-2 space-y-2">
                        @foreach ($idea->links as $link)
                            <x-card :href="$link" class="text-primary font-medium flex gap-x-3 items-center">
                                <x-hugeicons-link-01 />
                                {{ $link }}
                            </x-card>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>
