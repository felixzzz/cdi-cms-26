<x-filament-panels::page>
    <div class="mb-2 p-4 bg-gradient-to-r from-teal-900/10 via-teal-800/5 to-transparent border border-teal-500/20 rounded-xl">
        <div class="flex items-center gap-2 mb-1.5">
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-teal-500 animate-pulse"></span>
            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100">Global Website Settings & Legal Documents</h3>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
            Manage site-wide social links, whistleblowing email recipient, legal policy pages, and AI search engine files (llms.txt).
        </p>
        <div class="flex flex-wrap items-center gap-1.5 text-xs">
            <span class="px-2.5 py-1 bg-teal-100 dark:bg-teal-950/60 text-teal-700 dark:text-teal-300 rounded-md font-semibold border border-teal-200 dark:border-teal-800/60">Social Channels</span>
            <span class="text-gray-400">&bull;</span>
            <span class="px-2.5 py-1 bg-teal-100 dark:bg-teal-950/60 text-teal-700 dark:text-teal-300 rounded-md font-semibold border border-teal-200 dark:border-teal-800/60">Whistleblowing Dispatch</span>
            <span class="text-gray-400">&bull;</span>
            <span class="px-2.5 py-1 bg-teal-100 dark:bg-teal-950/60 text-teal-700 dark:text-teal-300 rounded-md font-semibold border border-teal-200 dark:border-teal-800/60">Privacy, Terms & Cookies</span>
            <span class="text-gray-400">&bull;</span>
            <span class="px-2.5 py-1 bg-teal-100 dark:bg-teal-950/60 text-teal-700 dark:text-teal-300 rounded-md font-semibold border border-teal-200 dark:border-teal-800/60">AI llms.txt</span>
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
