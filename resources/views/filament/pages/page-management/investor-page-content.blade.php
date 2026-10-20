<x-filament-panels::page>
    <div class="mb-2 p-4 bg-gradient-to-r from-amber-900/10 via-amber-800/5 to-transparent border border-amber-500/20 rounded-xl">
        <div class="flex items-center gap-2 mb-1.5">
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100">Investor Relations Page Structure</h3>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
            The components below map to the public Investor Relations pages (<a href="http://localhost:3000/en/investor/report" target="_blank" class="text-primary-600 underline font-semibold">/report</a>, <a href="http://localhost:3000/en/investor/financial-information" target="_blank" class="text-primary-600 underline font-semibold">/financial-information</a>, <a href="http://localhost:3000/en/investor/shares-information" target="_blank" class="text-primary-600 underline font-semibold">/shares-information</a>, <a href="http://localhost:3000/en/investor/publications-for-investors" target="_blank" class="text-primary-600 underline font-semibold">/publications-for-investors</a>).
        </p>
        <div class="flex flex-wrap items-center gap-1.5 text-xs">
            <span class="px-2.5 py-1 bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 rounded-md font-semibold border border-amber-200 dark:border-amber-800/60">1. Reports & Highlights</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 rounded-md font-semibold border border-amber-200 dark:border-amber-800/60">2. Financial Info Banner</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 rounded-md font-semibold border border-amber-200 dark:border-amber-800/60">3. Shares & Dividends</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 rounded-md font-semibold border border-amber-200 dark:border-amber-800/60">4. Publications Banner</span>
            <span class="text-gray-400">&rarr;</span>
            <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-md font-medium border border-gray-200 dark:border-gray-700">5. Reports & Presentations Feed</span>
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
