<x-filament-panels::page>
    <div class="mb-2 p-4 bg-gradient-to-r from-indigo-900/10 via-indigo-800/5 to-transparent border border-indigo-500/20 rounded-xl">
        <div class="flex items-center gap-2 mb-1.5">
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-indigo-500 animate-pulse"></span>
            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100">Good Corporate Governance Page Structure</h3>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
            The components below map to the public Governance page (<a href="http://localhost:3000/en/governance" target="_blank" class="text-primary-600 underline font-semibold">/governance</a>).
        </p>
        <div class="flex flex-wrap items-center gap-1.5 text-xs">
            <span class="px-2.5 py-1 bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 rounded-md font-semibold border border-indigo-200 dark:border-indigo-800/60">1. Hero Banner</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 rounded-md font-semibold border border-indigo-200 dark:border-indigo-800/60">2. Corporate Secretary</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 rounded-md font-semibold border border-indigo-200 dark:border-indigo-800/60">3. Internal Audit Unit</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 rounded-md font-semibold border border-indigo-200 dark:border-indigo-800/60">4. Committees</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 rounded-md font-semibold border border-indigo-200 dark:border-indigo-800/60">5. Risk & Regulations</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 rounded-md font-semibold border border-indigo-200 dark:border-indigo-800/60">6. Whistleblowing</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-md font-medium border border-gray-200 dark:border-gray-700">7. Governance Charters</span>
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
