<x-filament-panels::page>
    <div class="mb-2 p-4 bg-gradient-to-r from-violet-900/10 via-violet-800/5 to-transparent border border-violet-500/20 rounded-xl">
        <div class="flex items-center gap-2 mb-1.5">
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-violet-500 animate-pulse"></span>
            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100">Search Engine Optimization (SEO) & Social Sharing Meta Tags</h3>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
            Configure OpenGraph titles, meta descriptions, and thumbnail images for search crawlers (Google, Bing) and social preview cards (LinkedIn, Twitter, WhatsApp).
        </p>
        <div class="flex flex-wrap items-center gap-1.5 text-xs">
            <span class="px-2.5 py-1 bg-violet-100 dark:bg-violet-950/60 text-violet-700 dark:text-violet-300 rounded-md font-semibold border border-violet-200 dark:border-violet-800/60">Main Pages</span>
            <span class="text-gray-400">&bull;</span>
            <span class="px-2.5 py-1 bg-violet-100 dark:bg-violet-950/60 text-violet-700 dark:text-violet-300 rounded-md font-semibold border border-violet-200 dark:border-violet-800/60">About Us</span>
            <span class="text-gray-400">&bull;</span>
            <span class="px-2.5 py-1 bg-violet-100 dark:bg-violet-950/60 text-violet-700 dark:text-violet-300 rounded-md font-semibold border border-violet-200 dark:border-violet-800/60">Our Business (4 Pillars)</span>
            <span class="text-gray-400">&bull;</span>
            <span class="px-2.5 py-1 bg-violet-100 dark:bg-violet-950/60 text-violet-700 dark:text-violet-300 rounded-md font-semibold border border-violet-200 dark:border-violet-800/60">Governance</span>
            <span class="text-gray-400">&bull;</span>
            <span class="px-2.5 py-1 bg-violet-100 dark:bg-violet-950/60 text-violet-700 dark:text-violet-300 rounded-md font-semibold border border-violet-200 dark:border-violet-800/60">Sustainability (3 Pillars)</span>
            <span class="text-gray-400">&bull;</span>
            <span class="px-2.5 py-1 bg-violet-100 dark:bg-violet-950/60 text-violet-700 dark:text-violet-300 rounded-md font-semibold border border-violet-200 dark:border-violet-800/60">Investor Relations</span>
            <span class="text-gray-400">&bull;</span>
            <span class="px-2.5 py-1 bg-violet-100 dark:bg-violet-950/60 text-violet-700 dark:text-violet-300 rounded-md font-semibold border border-violet-200 dark:border-violet-800/60">Legal</span>
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
