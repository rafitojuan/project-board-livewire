<?php foreach ((['component', 'tableName','isTailwind','isBootstrap','isBootstrap4','isBootstrap5']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>
<!--[if BLOCK]><![endif]--><?php if($isTailwind): ?>
<div class="<?php if($component->getColumnSelectIsHiddenOnMobile()): ?> hidden sm:block <?php elseif($component->getColumnSelectIsHiddenOnTablet()): ?> hidden md:block <?php endif; ?> mb-4 w-full md:w-auto md:mb-0 md:ml-2">
    <div
        x-data="{ open: false, childElementOpen: false }"
        @keydown.window.escape="if (!childElementOpen) { open = false }"
        x-on:click.away="if (!childElementOpen) { open = false }"
        class="inline-block relative w-full text-left md:w-auto"
        wire:key="<?php echo e($tableName); ?>-column-select-button"
    >
        <div>
            <span class="rounded-md shadow-sm">
                <button
                    x-on:click="open = !open"
                    type="button"
                    class="inline-flex justify-center px-4 py-2 w-full text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600"
                    aria-haspopup="true"
                    x-bind:aria-expanded="open"
                    aria-expanded="true"
                >
                    <?php echo app('translator')->get('livewire-tables::Columns'); ?>

                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-chevron-down'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => '-mr-1 ml-2 h-5 w-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                </button>
            </span>
        </div>

        <div
            x-cloak x-show="open"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute right-0 z-50 mt-2 w-full rounded-md divide-y divide-gray-100 ring-1 ring-black ring-opacity-5 shadow-lg origin-top-right md:w-48 focus:outline-none"
        >
            <div class="bg-white rounded-md shadow-xs dark:bg-gray-700 dark:text-white">
                <div class="p-2" role="menu" aria-orientation="vertical"
                        aria-labelledby="column-select-menu"
                >
                    <div wire:key="<?php echo e($tableName); ?>-columnSelect-selectAll-<?php echo e(rand(0,1000)); ?>">
                        <label
                            wire:loading.attr="disabled"
                            class="inline-flex items-center px-2 py-1 disabled:opacity-50 disabled:cursor-wait"
                        >
                            <input
                                class="text-indigo-600 transition duration-150 ease-in-out border-gray-300 rounded shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 dark:focus:bg-gray-600 disabled:opacity-50 disabled:cursor-wait"
                                wire:loading.attr="disabled" 
                                type="checkbox"
                                <?php if($component->getSelectableSelectedColumns()->count() == $component->getSelectableColumns()->count()): echo 'checked'; endif; ?>
                                <?php if($component->getSelectableSelectedColumns()->count() == $component->getSelectableColumns()->count()): ?>  wire:click="deselectAllColumns" <?php else: ?> wire:click="selectAllColumns" <?php endif; ?>
                            >
                            <span class="ml-2"><?php echo app('translator')->get('livewire-tables::All Columns'); ?></span>
                        </label>
                    </div>

                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $component->getColumnsForColumnSelect(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $columnSlug => $columnTitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div
                            wire:key="<?php echo e($tableName); ?>-columnSelect-<?php echo e($loop->index); ?>"
                        >
                            <label
                                wire:loading.attr="disabled"
                                wire:target="selectedColumns"
                                class="inline-flex items-center px-2 py-1 disabled:opacity-50 disabled:cursor-wait"
                            >
                                <input
                                    class="text-indigo-600 rounded border-gray-300 shadow-sm transition duration-150 ease-in-out focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 dark:focus:bg-gray-600 disabled:opacity-50 disabled:cursor-wait"
                                    wire:model.live="selectedColumns" wire:target="selectedColumns"
                                    wire:loading.attr="disabled" type="checkbox"
                                    value="<?php echo e($columnSlug); ?>" />
                                <span class="ml-2"><?php echo e($columnTitle); ?></span>
                            </label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
    </div>
</div>
<?php elseif($isBootstrap): ?>
<div
    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'd-none d-sm mb-3 mb-md-0 pl-0 pl-md-2' => $component->getColumnSelectIsHiddenOnMobile() && $isBootstrap4,
        'd-none d-md-block mb-3 mb-md-0 pl-0 pl-md-2' => $component->getColumnSelectIsHiddenOnTablet() && $isBootstrap4,
        'd-none d-sm-block mb-3 mb-md-0 md-0 ms-md-2' => $component->getColumnSelectIsHiddenOnMobile() && $isBootstrap5,
        'd-none d-md-block mb-3 mb-md-0 md-0 ms-md-2' => $component->getColumnSelectIsHiddenOnTablet() && $isBootstrap5,
    ]); ?>"
>
    <div
        x-data="{ open: false, childElementOpen: false }"
        x-on:keydown.escape.stop="if (!childElementOpen) { open = false }"
        x-on:mousedown.away="if (!childElementOpen) { open = false }"
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'dropdown d-block d-md-inline' => $isBootstrap,
        ]); ?>"
        wire:key="<?php echo e($tableName); ?>-column-select-button"
    >
        <button
            x-on:click="open = !open"
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'btn dropdown-toggle d-block w-100 d-md-inline' => $isBootstrap,
            ]); ?>"
            type="button" id="<?php echo e($tableName); ?>-columnSelect" aria-haspopup="true"
            x-bind:aria-expanded="open"
        >
            <?php echo app('translator')->get('livewire-tables::Columns'); ?>
        </button>

        <div
            x-bind:class="{ 'show': open }"
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'dropdown-menu dropdown-menu-right w-100 mt-0 mt-md-3' => $isBootstrap4,
                'dropdown-menu dropdown-menu-end w-100' => $isBootstrap5,
            ]); ?>"
            aria-labelledby="columnSelect-<?php echo e($tableName); ?>"
        >
            <!--[if BLOCK]><![endif]--><?php if($isBootstrap4): ?>
                <div wire:key="<?php echo e($tableName); ?>-columnSelect-selectAll-<?php echo e(rand(0,1000)); ?>">
                    <label wire:loading.attr="disabled" class="px-2 mb-1">
                        <input
                            wire:loading.attr="disabled"
                            type="checkbox"
                            <?php if($component->getSelectableSelectedColumns()->count() == $component->getSelectableColumns()->count()): ?> checked wire:click="deselectAllColumns" <?php else: ?> unchecked wire:click="selectAllColumns" <?php endif; ?>
                        />

                        <span class="ml-2"><?php echo app('translator')->get('livewire-tables::All Columns'); ?></span>
                        

                    </label>
                </div>
            <?php elseif($isBootstrap5): ?>
                <div class="form-check ms-2" wire:key="<?php echo e($tableName); ?>-columnSelect-selectAll-<?php echo e(rand(0,1000)); ?>">
                    <input
                        wire:loading.attr="disabled"
                        type="checkbox"
                        class="form-check-input"
                        <?php if($component->getSelectableSelectedColumns()->count() == $component->getSelectableColumns()->count()): ?> checked wire:click="deselectAllColumns" <?php else: ?> unchecked wire:click="selectAllColumns" <?php endif; ?>
                    />

                    <label wire:loading.attr="disabled" class="form-check-label">
                        <?php echo app('translator')->get('livewire-tables::All Columns'); ?>
                    </label>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $component->getColumnsForColumnSelect(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $columnSlug => $columnTitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div
                    wire:key="<?php echo e($tableName); ?>-columnSelect-<?php echo e($loop->index); ?>"
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'form-check ms-2' => $isBootstrap5,
                    ]); ?>"
                >
                    <!--[if BLOCK]><![endif]--><?php if($isBootstrap4): ?>
                        <label
                            wire:loading.attr="disabled"
                            wire:target="selectedColumns"
                            class="px-2 <?php echo e($loop->last ? 'mb-0' : 'mb-1'); ?>"
                        >
                            <input
                                wire:model.live="selectedColumns"
                                wire:target="selectedColumns"
                                wire:loading.attr="disabled" type="checkbox"
                                value="<?php echo e($columnSlug); ?>"
                            />
                            <span class="ml-2">
                                <?php echo e($columnTitle); ?>

                            </span>
                        </label>
                    <?php elseif($isBootstrap5): ?>
                        <input
                            wire:model.live="selectedColumns"
                            wire:target="selectedColumns"
                            wire:loading.attr="disabled"
                            type="checkbox"
                            class="form-check-input"
                            value="<?php echo e($columnSlug); ?>"
                        />
                        <label
                            wire:loading.attr="disabled"
                            wire:target="selectedColumns"
                            class="<?php echo e($loop->last ? 'mb-0' : 'mb-1'); ?> form-check-label"
                        >
                            <?php echo e($columnTitle); ?>

                        </label>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div>

<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH C:\laragon\www\epi-dasbor\vendor\rappasoft\laravel-livewire-tables\src/../resources/views/components/tools/toolbar/items/column-select.blade.php ENDPATH**/ ?>