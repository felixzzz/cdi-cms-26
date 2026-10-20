<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center gap-2">
                <x-filament::icon
                    icon="heroicon-o-bolt"
                    class="h-5 w-5 text-amber-500"
                />
                <span class="text-base font-semibold">Quick Actions & Live Controls</span>
            </div>
        </x-slot>

        <x-slot name="description">
            Purge frontend cache, preview public pages, and quickly access critical page configuration tools.
        </x-slot>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 pt-2">
            <!-- Purge Cache Button -->
            <button
                type="button"
                wire:click="purgeCache"
                wire:loading.attr="disabled"
                class="flex items-center gap-3 p-3 text-left rounded-xl border border-gray-200 dark:border-gray-700 hover:border-primary-500 dark:hover:border-primary-500 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 transition group"
            >
                <div class="p-2.5 rounded-lg bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 group-hover:scale-105 transition-transform">
                    <x-filament::icon icon="heroicon-o-arrow-path" class="h-5 w-5" wire:loading.remove wire:target="purgeCache" />
                    <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="purgeCache" />
                </div>
                <div>
                    <div class="text-xs font-semibold text-gray-900 dark:text-gray-100">Purge Frontend Cache</div>
                    <div class="text-[11px] text-gray-500 dark:text-gray-400">Trigger instant ISR reload</div>
                </div>
            </button>

            <!-- Live Site Link -->
            <a
                href="{{ env('FRONTEND_URL', 'http://localhost:3000') }}/en"
                target="_blank"
                rel="noopener noreferrer"
                class="flex items-center gap-3 p-3 text-left rounded-xl border border-gray-200 dark:border-gray-700 hover:border-primary-500 dark:hover:border-primary-500 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 transition group"
            >
                <div class="p-2.5 rounded-lg bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 group-hover:scale-105 transition-transform">
                    <x-filament::icon icon="heroicon-o-arrow-top-right-on-square" class="h-5 w-5" />
                </div>
                <div>
                    <div class="text-xs font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-1">
                        View Live Website
                        <span class="text-[10px] text-gray-400">↗</span>
                    </div>
                    <div class="text-[11px] text-gray-500 dark:text-gray-400">Open localhost:3000</div>
                </div>
            </a>

            <!-- Homepage Editor -->
            <a
                href="/admin/page-management/home-page-content"
                class="flex items-center gap-3 p-3 text-left rounded-xl border border-gray-200 dark:border-gray-700 hover:border-primary-500 dark:hover:border-primary-500 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 transition group"
            >
                <div class="p-2.5 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 group-hover:scale-105 transition-transform">
                    <x-filament::icon icon="heroicon-o-home" class="h-5 w-5" />
                </div>
                <div>
                    <div class="text-xs font-semibold text-gray-900 dark:text-gray-100">Homepage Editor</div>
                    <div class="text-[11px] text-gray-500 dark:text-gray-400">Hero banners, stats & vision</div>
                </div>
            </a>

            <!-- Investor Tables Editor -->
            <a
                href="/admin/page-management/investor-page-content"
                class="flex items-center gap-3 p-3 text-left rounded-xl border border-gray-200 dark:border-gray-700 hover:border-primary-500 dark:hover:border-primary-500 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 transition group"
            >
                <div class="p-2.5 rounded-lg bg-purple-50 dark:bg-purple-950/40 text-purple-600 dark:text-purple-400 group-hover:scale-105 transition-transform">
                    <x-filament::icon icon="heroicon-o-table-cells" class="h-5 w-5" />
                </div>
                <div>
                    <div class="text-xs font-semibold text-gray-900 dark:text-gray-100">Investor Tables</div>
                    <div class="text-[11px] text-gray-500 dark:text-gray-400">Financials & shareholding</div>
                </div>
            </a>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
