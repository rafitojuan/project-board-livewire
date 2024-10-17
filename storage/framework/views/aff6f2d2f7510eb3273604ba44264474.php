<?php foreach ((['component', 'tableName','isTailwind','isBootstrap','isBootstrap4','isBootstrap5']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>
<div
    x-data="{ open: false, childElementOpen: false, isTailwind: <?php echo \Illuminate\Support\Js::from($isTailwind)->toHtml() ?>, isBootstrap: <?php echo \Illuminate\Support\Js::from($isBootstrap)->toHtml() ?> }"
    x-cloak x-show="(selectedItems.length > 0 || hideBulkActionsWhenEmpty == false)"
    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'mb-3 mb-md-0' => $this->isBootstrap,
        'w-full md:w-auto mb-4 md:mb-0' => $this->isTailwind,
    ]); ?>"
>
    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'dropdown d-block d-md-inline' => $this->isBootstrap,
            'relative inline-block text-left z-10 w-full md:w-auto' => $this->isTailwind,
        ]); ?>"
    >
        <button
            <?php echo e($attributes->merge($this->getBulkActionsButtonAttributes)
                ->class([
                    'btn dropdown-toggle d-block d-md-inline' => $this->isBootstrap && $this->getBulkActionsButtonAttributes['default-styling'] ?? true,
                    'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus:border-indigo-300 focus:ring-indigo-200 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600' => $this->isTailwind  && $this->getBulkActionsButtonAttributes['default-colors'] ?? true,
                    'inline-flex justify-center w-full rounded-md border shadow-sm px-4 py-2 text-sm font-medium focus:ring focus:ring-opacity-50' => $this->isTailwind  && $this->getBulkActionsButtonAttributes['default-styling'] ?? true,

                ])
                ->except(['default','default-styling','default-colors'])); ?>

            type="button"
            id="<?php echo e($tableName); ?>-bulkActionsDropdown" 
            
                        
            <?php if($this->isTailwind): ?>
                        x-on:click="open = !open"
                        <?php else: ?>
                        data-toggle="dropdown" data-bs-toggle="dropdown"
                        <?php endif; ?>
            aria-haspopup="true" aria-expanded="false">

            <?php echo app('translator')->get('livewire-tables::Bulk Actions'); ?>
            <!--[if BLOCK]><![endif]--><?php if($this->isTailwind): ?>
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
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </button>
        
        <!--[if BLOCK]><![endif]--><?php if($this->isTailwind): ?>
            <div
                x-on:click.away="if (!childElementOpen) { open = false }"
                @keydown.window.escape="if (!childElementOpen) { open = false }"
                x-cloak x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="origin-top-right absolute right-0 mt-2 w-full md:w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50"
            >
                <div
                    <?php echo e($attributes->merge($this->getBulkActionsMenuAttributes)
                        ->class([
                            'bg-white dark:bg-gray-700 dark:text-white' => $this->isTailwind && $this->getBulkActionsMenuAttributes['default-colors'] ?? true,
                            'rounded-md shadow-xs' => $this->isTailwind && $this->getBulkActionsMenuAttributes['default-styling'] ?? true,
                        ])
                        ->except(['default','default-styling','default-colors'])); ?>

                >
                    <div class="py-1" role="menu" aria-orientation="vertical">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->getBulkActions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button
                                wire:click="<?php echo e($action); ?>"
                                <?php if($this->hasConfirmationMessage($action)): ?>
                                    wire:confirm="<?php echo e($this->getBulkActionConfirmMessage($action)); ?>"
                                <?php endif; ?>
                                wire:key="<?php echo e($tableName); ?>-bulk-action-<?php echo e($action); ?>"
                                type="button"
                                role="menuitem"
                                <?php echo e($attributes->merge($this->getBulkActionsMenuItemAttributes)
                                    ->class([
                                        'text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100 focus:text-gray-900 dark:text-white dark:hover:bg-gray-600' => $this->isTailwind && $this->getBulkActionsMenuItemAttributes['default-colors'] ?? true,
                                        'block w-full px-4 py-2 text-sm leading-5 focus:outline-none flex items-center space-x-2' => $this->isTailwind && $this->getBulkActionsMenuItemAttributes['default-styling'] ?? true,
                                    ])
                                    ->except(['default','default-styling','default-colors'])); ?>

                            >
                                <span><?php echo e($title); ?></span>
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div
                <?php echo e($attributes->merge($this->getBulkActionsMenuAttributes)
                    ->class([
                        'dropdown-menu dropdown-menu-right w-100' => $this->isBootstrap4 && $this->getBulkActionsMenuAttributes['default-styling'] ?? true,
                        'dropdown-menu dropdown-menu-end w-100' => $this->isBootstrap5 && $this->getBulkActionsMenuAttributes['default-styling'] ?? true,
                    ])
                    ->except(['default','default-styling','default-colors'])); ?>

                aria-labelledby="<?php echo e($tableName); ?>-bulkActionsDropdown"
            >
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->getBulkActions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a
                        href="#"
                        <?php if($this->hasConfirmationMessage($action)): ?>
                            wire:confirm="<?php echo e($this->getBulkActionConfirmMessage($action)); ?>"
                        <?php endif; ?>
                        wire:click="<?php echo e($action); ?>"
                        wire:key="<?php echo e($tableName); ?>-bulk-action-<?php echo e($action); ?>"
                        <?php echo e($attributes->merge($this->getBulkActionsMenuItemAttributes)
                                ->class([
                                    'dropdown-item' => $this->isBootstrap && $this->getBulkActionsMenuItemAttributes['default-styling'] ?? true,
                                ])
                                ->except(['default','default-styling','default-colors'])); ?>

                    >
                        <?php echo e($title); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    </div>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\vendor\rappasoft\laravel-livewire-tables\src/../resources/views/components/tools/toolbar/items/bulk-actions.blade.php ENDPATH**/ ?>