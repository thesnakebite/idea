<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">

        <a href="/" class="flex items-center gap-2 text-foreground">
            <img src="{{ asset('images/idea.png') }}" alt="Idea" width="30" />
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
                <a href="{{ route('profile.edit') }}" class="text-sm">Profile Edit</a>

                <form action="/logout" method="POST">
                    @csrf

                    <button>Log out</button>
                </form>
            @endauth
        </div>
    </div>
</nav>
