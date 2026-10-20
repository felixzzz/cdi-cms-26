<x-filament-panels::page>
    <div class="mb-2 p-4 bg-gradient-to-r from-blue-900/10 via-blue-800/5 to-transparent border border-blue-500/20 rounded-xl">
        <div class="flex items-center gap-2 mb-1.5">
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-blue-500 animate-pulse"></span>
            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100">Front Page Component Sequence</h3>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
            The components below mirror the exact visual sequence of the live homepage (<a href="http://localhost:3000/en" target="_blank" class="text-primary-600 underline font-semibold">http://localhost:3000</a>) from top to bottom.
        </p>
        <div class="flex flex-wrap items-center gap-1.5 text-xs">
            <span class="px-2.5 py-1 bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 rounded-md font-semibold border border-blue-200 dark:border-blue-800/60">1. Hero Banner</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 rounded-md font-semibold border border-blue-200 dark:border-blue-800/60">2. About CDI</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 rounded-md font-semibold border border-blue-200 dark:border-blue-800/60">3. Infrastructure Solutions</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 rounded-md font-semibold border border-blue-200 dark:border-blue-800/60">4. Discover CDI</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 rounded-md font-semibold border border-blue-200 dark:border-blue-800/60">5. Journey & Metrics</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-md font-medium border border-gray-200 dark:border-gray-700">6. Reports</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-md font-medium border border-gray-200 dark:border-gray-700">7. News</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-md font-medium border border-gray-200 dark:border-gray-700">8. Quick Links</span>
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
