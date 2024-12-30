<div>
    <style>
        .form-control-lg:focus {
            outline: none;
            border-bottom: 100px;
        }
    </style>
    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <form wire:submit.prevent="createPengumuman">
                <input type="text" class="form-control-lg border-0 border-bottom mb-0 w-100" placeholder="Ketik Judulnya..."
                    wire:model="judul">
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                <div class="border-bottom border border-secondary mt-0 mb-3"></div>
                <div wire:ignore>
                    <textarea id="content" cols="30" rows="10" wire:model='content'></textarea>
                </div>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label for="">Tentukan tenggat waktu pengumuman,</label> <br>
                        <input type="date" id="end_date" wire:model="end_at" class="form-control">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['end_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <div class="col-md-6">
                        <label for="">Buat perihal atau kategori dari pengumuman</label> <br>
                        <input type="text" id="category" wire:model="category" class="form-control"
                            placeholder="Performa musiman">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                <div class="card-footer rounded-bottom-4">
                    <div class="float-end">
                        <button type="button" class="btn btn-outline-danger rounded-4 btn-sm me-2"><i
                                class="bx bx-x"></i> Batal</button>
                        <button type="button" wire:click='draft' class="btn btn-outline-primary rounded-4 btn-sm me-2">
                            <i class="bx bx-save"></i> Draft</button>
                        <button type="submit" class="btn btn-outline-success rounded-4 btn-sm"><i
                                class="bx bx-upload"></i>
                            Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>
    <script>
        $('#content').summernote({
            placeholder: 'Isi konten disini...',
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onChange: function(contents, $editable) {
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('content', contents);
                    document.querySelector('[data-error="content"]')?.remove();
                }
            }
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/pengumuman-create.blade.php ENDPATH**/ ?>