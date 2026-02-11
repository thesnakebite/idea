<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2 text-foreground hover:text-amber-500 transition-colors">
            <svg class="size-7 text-amber-500" viewBox="0 0 24 24" aria-hidden="true">
                <path
                    d="M12 3a6 6 0 0 0-3 11.24V17a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-2.76A6 6 0 0 0 12 3z"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
                <path
                    d="M10 21h4"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                />
            </svg>

            <span class="text-lg font-semibold">
                Idea
            </span>
        </a>

        <div class="flex gap-x-5 items-center">
            @guest()
                <a href="/login">Sign in</a>
                <a href="/register" class="btn">Register</a>
            @endguest

            @auth()
                <form action="/logout" method="POST">
                    @csrf
                    
                    <button>Log out</button>
                </form>
            @endauth
        </div>
    </div>
</nav>
