<?php foreach ((['component', 'tableName','isTailwind', 'isBootstrap']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<div 
    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'mb-3 mb-md-0 input-group' => $this->isBootstrap,
        'flex rounded-md shadow-sm' => $this->isTailwind,
    ]); ?>">
        <input
            wire:model<?php echo e($this->getSearchOptions()); ?>="search"
            placeholder="<?php echo e($this->getSearchPlaceholder()); ?>"
            type="text"
            <?php echo e($attributes->merge($this->getSearchFieldAttributes())
                ->class([
                    'block w-full rounded-md shadow-sm transition duration-150 ease-in-out sm:text-sm sm:leading-5 rounded-none rounded-l-md focus:ring-0 focus:border-gray-300' => $this->isTailwind && $this->hasSearch() && ($this->getSearchFieldAttributes()['default'] ?? true || $this->getSearchFieldAttributes()['default-styling'] ?? true),
                    'block w-full rounded-md shadow-sm transition duration-150 ease-in-out sm:text-sm sm:leading-5 rounded-md focus:ring focus:ring-opacity-50' => $this->isTailwind && !$this->hasSearch()  && ($this->getSearchFieldAttributes()['default'] ?? true || $this->getSearchFieldAttributes()['default-styling'] ?? true),
                    'border-gray-300 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:border-gray-300' => $this->isTailwind && $this->hasSearch()  && ($this->getSearchFieldAttributes()['default'] ?? true || $this->getSearchFieldAttributes()['default-colors'] ?? true),
                    'border-gray-300 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:border-indigo-300 focus:ring-indigo-200' => $this->isTailwind && !$this->hasSearch()  && ($this->getSearchFieldAttributes()['default'] ?? true || $this->getSearchFieldAttributes()['default-colors'] ?? true),

                    'form-control' => $this->isBootstrap && $this->getSearchFieldAttributes()['default'] ?? true,
                ])
                ->except(['default','default-styling','default-colors'])); ?>


        />

        <!--[if BLOCK]><![endif]--><?php if($this->hasSearch()): ?>
        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'd-inline-flex h-100 align-items-center ' => $this->isBootstrap,
                ]); ?>">
                <div
                    wire:click="clearSearch"

                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'btn btn-outline-secondary d-inline-flex h-100 align-items-center' => $this->isBootstrap,
                            'inline-flex h-full items-center px-3 text-gray-500 bg-gray-50 rounded-r-md border border-l-0 border-gray-300 cursor-pointer sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600' => $this->isTailwind,
                        ]); ?>"
                >
                <!--[if BLOCK]><![endif]--><?php if($this->isTailwind): ?>
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-x-mark'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
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
                <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-x-mark'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'laravel-livewire-tables-btn-smaller']); ?>
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
                    </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


</div>
<?php /**PATH C:\laragon\www\epi-dasbor\vendor\rappasoft\laravel-livewire-tables\src/../resources/views/components/tools/toolbar/items/search-field.blade.php ENDPATH**/ ?>