<div>
    <div class="mt-5">
        <h5 class="font-size-15"><i class="bx bx-message-dots text-muted align-middle me-1"></i> Komentar :
        </h5>

        <div>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $comment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $com): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex py-3">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-xs">
                            <img src="<?php echo e(URL::asset($com->user->avatar)); ?>" alt=""
                                class="img-fluid d-block rounded-circle">
                        </div>
                    </div>

                    <div class="flex-grow-1">
                        <h5 class="font-size-14 mb-1"><?php echo e($com->user->name); ?>

                            
                        </h5>
                        <p class="text-muted"><?php echo e($com->body); ?></p>
                        <div>
                            <a href="javascript: void(0);" class="text-success"
                                wire:click='selectReply(<?php echo e($com->id); ?>)'><i class="mdi mdi-reply"></i> Balas
                                Pesan</a>
                        </div>

                        <!--[if BLOCK]><![endif]--><?php if(isset($parentId) and $parentId == $com->id): ?>
                            <form wire:submit.prevent='reply' class="mt-2">
                                <div class="mb-3">
                                    <label for="commentmessage-input" class="form-label">Balas Komentar
                                        <?php echo e($com->user->name); ?></label>
                                    <textarea class="form-control <?php $__errorArgs = ['body2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="commentmessage-input" wire:model.defer='body2'
                                        placeholder="Sampaikan balasanmu..." rows="3"></textarea>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['body2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div class="text-end">
                                    <button type="button" wire:click='closeComment'
                                        class="btn btn-secondary w-sm">Batal
                                    </button>
                                    <button type="submit" class="btn btn-success w-sm">Kirim <i
                                            class="bx bx-paper-plane"></i></button>
                                </div>
                            </form>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($com->children): ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $com->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="d-flex pt-3">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-xs">
                                            <img src="<?php echo e(URL::asset($com->user->avatar)); ?>" alt=""
                                                class="img-fluid d-block rounded-circle">
                                        </div>
                                    </div>

                                    <div class="flex-grow-1">
                                        <h5 class="font-size-14 mb-1"><?php echo e($child->user->name); ?>

                                            
                                        </h5>
                                        <p class="text-muted"><?php echo e($child->body); ?></p>
                                        <div>
                                            <a href="javascript: void(0);" class="text-success"
                                                wire:click='selectReply(<?php echo e($child->id); ?>)'><i
                                                    class="mdi mdi-reply"></i> Balas
                                                Pesan</a>
                                        </div>

                                        <?php if(isset($parentId) and $parentId == $child->id): ?>
                                            <form wire:submit.prevent='reply' class="mt-2">
                                                <div class="mb-3">
                                                    <label for="commentmessage-input" class="form-label">Balas Komentar
                                                        <?php echo e($child->user->name); ?></label>
                                                    <textarea class="form-control <?php $__errorArgs = ['body2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="commentmessage-input" wire:model.defer='body2'
                                                        placeholder="Sampaikan balasanmu..." rows="3"></textarea>
                                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['body2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>

                                                <div class="text-end">
                                                    <button type="button" wire:click='closeComment'
                                                        class="btn btn-secondary w-sm">Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-success w-sm">Kirim <i
                                                            class="bx bx-paper-plane"></i></button>
                                                </div>
                                            </form>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

        </div>
    </div>

    <div class="mt-4">
        <h5 class="font-size-16 mb-3">Tinggalkan pesan disini!</h5>

        <form wire:submit='postComment'>
            <div class="mb-3">
                <label for="commentmessage-input" class="form-label">Komentar</label>
                <textarea class="form-control <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="commentmessage-input" wire:model.defer='body'
                    placeholder="Sampaikan insightmu..." rows="3"></textarea>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success w-sm">Kirim <i class="bx bx-paper-plane"></i></button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/komentar.blade.php ENDPATH**/ ?>