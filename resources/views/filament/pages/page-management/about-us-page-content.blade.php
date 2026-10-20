<x-filament-panels::page>
    <div class="mb-2 p-4 bg-gradient-to-r from-sky-900/10 via-sky-800/5 to-transparent border border-sky-500/20 rounded-xl">
        <div class="flex items-center gap-2 mb-1.5">
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-sky-500 animate-pulse"></span>
            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100">About Us Page Structure</h3>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
            The components below map to the public About Us pages (<a href="http://localhost:3000/en/about-us" target="_blank" class="text-primary-600 underline font-semibold">/about-us</a>, <a href="http://localhost:3000/en/about-us/management" target="_blank" class="text-primary-600 underline font-semibold">/management</a>, <a href="http://localhost:3000/en/about-us/awards-and-accreditations" target="_blank" class="text-primary-600 underline font-semibold">/awards-and-accreditations</a>).
        </p>
        <div class="flex flex-wrap items-center gap-1.5 text-xs">
            <span class="px-2.5 py-1 bg-sky-100 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 rounded-md font-semibold border border-sky-200 dark:border-sky-800/60">1. Hero Banner</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-sky-100 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 rounded-md font-semibold border border-sky-200 dark:border-sky-800/60">2. Overview & Video</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-sky-100 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 rounded-md font-semibold border border-sky-200 dark:border-sky-800/60">3. Vision & Mission</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-sky-100 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 rounded-md font-semibold border border-sky-200 dark:border-sky-800/60">4. Milestones & Profile</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-sky-100 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 rounded-md font-semibold border border-sky-200 dark:border-sky-800/60">5. Board & Management</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-sky-100 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 rounded-md font-semibold border border-sky-200 dark:border-sky-800/60">6. Awards & Accreditations</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-md font-medium border border-gray-200 dark:border-gray-700">7. Historical Feeds</span>
        </div>
    </div>

    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        <div class="mt-6 flex justify-end">
            <x-filament-panels::form.actions 
                :actions="$this->getFormActions()"
            />
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>
