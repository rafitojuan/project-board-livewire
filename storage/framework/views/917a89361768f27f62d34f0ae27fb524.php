<?php foreach ((['component', 'tableName','isBootstrap','isBootstrap4','isBootstrap5']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>
<?php if($this->isBootstrap): ?>
    <ul
        x-cloak
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'dropdown-menu w-100 mt-md-5' => $this->isBootstrap4,
            'dropdown-menu w-100' => $this->isBootstrap5,
        ]); ?>"
        x-bind:class="{ 'show': filterPopoverOpen }"
        role="menu"
    >
        <?php $__currentLoopData = $this->getVisibleFilters(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div
                wire:key="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?>-toolbar"
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'p-2' => $this->isBootstrap,
                ]); ?>"
                id="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?>-wrapper"
            >
                <?php echo e($filter->setGenericDisplayData($this->getFilterGenericData)->render()); ?>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($this->hasAppliedVisibleFiltersWithValuesThatCanBeCleared()): ?>
            <div
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'dropdown-divider' => $this->isBootstrap,
                ]); ?>"
            >
            </div>

            <button
                wire:click.prevent="setFilterDefaults" x-on:click="filterPopoverOpen = false"
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'dropdown-item btn text-center' => $this->isBootstrap4,
                    'dropdown-item text-center' => $this->isBootstrap5,
                ]); ?>"
            >
                <?php echo app('translator')->get('livewire-tables::Clear'); ?>
            </button>
        <?php endif; ?>
    </ul>
<?php else: ?>
    <div
        x-cloak x-show="filterPopoverOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="origin-top-left absolute left-0 mt-2 w-full md:w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50 dark:bg-gray-700 dark:text-white dark:divide-gray-600"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="filters-menu"
    >
        <?php $__currentLoopData = $this->getVisibleFilters(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="py-1" role="none">
                <div
                    class="block px-4 py-2 text-sm text-gray-700 space-y-1"
                    role="menuitem"
                    id="<?php echo e($tableName); ?>-filter-<?php echo e($filter->getKey()); ?>-wrapper"
                >
                    <?php echo e($filter->setGenericDisplayData($this->getFilterGenericData)->render()); ?>

                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($this->hasAppliedVisibleFiltersWithValuesThatCanBeCleared()): ?>
            <div class="block px-4 py-3 text-sm text-gray-700 dark:text-white" role="menuitem">
                <button
                    x-on:click="filterPopoverOpen = false"
                    wire:click.prevent="setFilterDefaults"
                    type="button"
                    class="w-full inline-flex items-center justify-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-600 dark:text-white dark:hover:border-gray-500 dark:hover:bg-gray-600"
                >
                    <?php echo app('translator')->get('livewire-tables::Clear'); ?>
                </button>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?><?php /**PATH C:\laragon\www\epi-dasbor\vendor\rappasoft\laravel-livewire-tables\resources\views\components\tools\toolbar\items\filter-popover.blade.php ENDPATH**/ ?>