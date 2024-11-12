<?php foreach ((['component', 'tableName','isTailwind','isBootstrap','isBootstrap4','isBootstrap5']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>
<div x-data x-cloak x-show="reorderStatus"
    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'mr-0 mr-md-2 mb-3 mb-md-0' => $this->isBootstrap4,
        'me-0 me-md-2 mb-3 mb-md-0' => $this->isBootstrap5
    ]); ?>"
>
    <button
        x-on:click="reorderToggle"
        type="button"
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'btn btn-default d-block d-md-inline' => $this->isBootstrap,
            'inline-flex justify-center items-center w-full md:w-auto px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600' => $this->isTailwind
        ]); ?>"
    >
        <span x-cloak x-show="currentlyReorderingStatus">
            <?php echo app('translator')->get('livewire-tables::Cancel'); ?>
        </span>

        <span x-cloak x-show="!currentlyReorderingStatus">
            <?php echo app('translator')->get('livewire-tables::Reorder'); ?>
        </span>

    </button>
    
    <div :class="{ 'inline d-inline' : currentlyReorderingStatus }" x-cloak x-show="currentlyReorderingStatus" >
        <button
            type="button"
            x-on:click="updateOrderedItems"
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'btn btn-default d-block d-md-inline' => $this->isBootstrap && $this->currentlyReorderingStatus,
                'inline-flex justify-center items-center w-full md:w-auto px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600' => $this->isTailwind
            ]); ?>"
        >
            <span>
                <?php echo app('translator')->get('livewire-tables::Save'); ?>
            </span>
        </button>
    </div>


</div>
<?php /**PATH C:\laragon\www\epi-dasbor\vendor\rappasoft\laravel-livewire-tables\resources\views\components\tools\toolbar\items\reorder-buttons.blade.php ENDPATH**/ ?>