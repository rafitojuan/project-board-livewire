
<div
    ondragenter="onLivewireCalendarEventDragEnter(event, '<?php echo e($componentId); ?>', '<?php echo e($day); ?>', '<?php echo e($dragAndDropClasses); ?>');"
    ondragleave="onLivewireCalendarEventDragLeave(event, '<?php echo e($componentId); ?>', '<?php echo e($day); ?>', '<?php echo e($dragAndDropClasses); ?>');"
    ondragover="onLivewireCalendarEventDragOver(event);"
    ondrop="onLivewireCalendarEventDrop(event, '<?php echo e($componentId); ?>', '<?php echo e($day); ?>', <?php echo e($day->year); ?>, <?php echo e($day->month); ?>, <?php echo e($day->day); ?>, '<?php echo e($dragAndDropClasses); ?>');"
    class="flex-1 h-40 lg:h-48 border border-gray-200 -mt-px -ml-px"
    style="min-width: 10rem;">

    
    <div
        class="w-full h-full"
        id="<?php echo e($componentId); ?>-<?php echo e($day); ?>">

        <div
            <?php if($dayClickEnabled): ?>
                wire:click="onDayClick(<?php echo e($day->year); ?>, <?php echo e($day->month); ?>, <?php echo e($day->day); ?>)"
            <?php endif; ?>
            class="w-full h-full p-2 <?php echo e($dayInMonth ? $isToday ? 'bg-yellow-100' : ' bg-white ' : 'bg-gray-100'); ?> flex flex-col">

            
            <div class="flex items-center">
                <p class="text-sm <?php echo e($dayInMonth ? ' font-medium ' : ''); ?>">
                    <?php echo e($day->format('j')); ?>

                </p>
                <p class="text-xs text-gray-600 ml-4">
                    <!--[if BLOCK]><![endif]--><?php if($events->isNotEmpty()): ?>
                        <?php echo e($events->count()); ?> <?php echo e(Str::plural('event', $events->count())); ?>

                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </p>
            </div>

            
            <div class="p-2 my-2 flex-1 overflow-y-auto">
                <div class="grid grid-cols-1 grid-flow-row gap-2">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div
                            <?php if($dragAndDropEnabled): ?>
                                draggable="true"
                            <?php endif; ?>
                            ondragstart="onLivewireCalendarEventDragStart(event, '<?php echo e($event['id']); ?>')">
                            <?php echo $__env->make($eventView, [
                                'event' => $event,
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>

        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\vendor\omnia-digital\livewire-calendar\src/../resources/views/day.blade.php ENDPATH**/ ?>