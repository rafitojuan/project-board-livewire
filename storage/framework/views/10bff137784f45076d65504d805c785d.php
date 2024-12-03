<div
    <?php if($pollMillis !== null && $pollAction !== null): ?>
        wire:poll.<?php echo e($pollMillis); ?>ms="<?php echo e($pollAction); ?>"
    <?php elseif($pollMillis !== null): ?>
        wire:poll.<?php echo e($pollMillis); ?>ms
    <?php endif; ?>
>
    <div>
        <?php if ($__env->exists($beforeCalendarView)) echo $__env->make($beforeCalendarView, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <div class="flex">
        <div class="overflow-x-auto w-full">
            <div class="inline-block min-w-full overflow-hidden">

                <div class="w-full flex flex-row">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $monthGrid->first(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make($dayOfWeekView, ['day' => $day], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $monthGrid; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="w-full flex flex-row">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $week; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make($dayView, [
                                    'componentId' => $componentId,
                                    'day' => $day,
                                    'dayInMonth' => $day->isSameMonth($startsAt),
                                    'isToday' => $day->isToday(),
                                    'events' => $getEventsForDay($day, $events),
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>

    <div>
        <?php if ($__env->exists($afterCalendarView)) echo $__env->make($afterCalendarView, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\vendor\omnia-digital\livewire-calendar\src/../resources/views/calendar.blade.php ENDPATH**/ ?>