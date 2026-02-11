<x-layout>
    <x-form title="Log in" description="Glad to have your back">
        <form action="/login" method="POST" class="mt-10 space-y-4">
            @csrf

            <x-form.field name="email" type="email" label="Email" />
            <x-form.field name="password" type="password" label="Password" />

            <div class="flex justify-end">
                <button class="btn h-10">Sign in</button>
            </div>
        </form>
    </x-form>
</x-layout>
