<x-filament-panels::page>
    <div class="mb-2 p-4 bg-gradient-to-r from-emerald-900/10 via-emerald-800/5 to-transparent border border-emerald-500/20 rounded-xl">
        <div class="flex items-center gap-2 mb-1.5">
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100">Sustainability Page Structure</h3>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
            The components below map to the public Sustainability pages (<a href="http://localhost:3000/en/sustainability" target="_blank" class="text-primary-600 underline font-semibold">/sustainability</a>, <a href="http://localhost:3000/en/sustainability/environment" target="_blank" class="text-primary-600 underline font-semibold">/environment</a>, <a href="http://localhost:3000/en/sustainability/social" target="_blank" class="text-primary-600 underline font-semibold">/social</a>, <a href="http://localhost:3000/en/sustainability/governance" target="_blank" class="text-primary-600 underline font-semibold">/governance</a>, <a href="http://localhost:3000/en/sustainability/report" target="_blank" class="text-primary-600 underline font-semibold">/report</a>, <a href="http://localhost:3000/en/sustainability/action" target="_blank" class="text-primary-600 underline font-semibold">/action</a>).
        </p>
        <div class="flex flex-wrap items-center gap-1.5 text-xs">
            <span class="px-2.5 py-1 bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 rounded-md font-semibold border border-emerald-200 dark:border-emerald-800/60">1. Sustainability Overview</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 rounded-md font-semibold border border-emerald-200 dark:border-emerald-800/60">2. ESG Environment</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 rounded-md font-semibold border border-emerald-200 dark:border-emerald-800/60">3. ESG Social</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 rounded-md font-semibold border border-emerald-200 dark:border-emerald-800/60">4. ESG Governance</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 rounded-md font-semibold border border-emerald-200 dark:border-emerald-800/60">5. PDF Reports & In Action</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-md font-medium border border-gray-200 dark:border-gray-700">6. Initiatives Feed</span>
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
