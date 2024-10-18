<!-- JAVASCRIPT -->
<script src="<?php echo e(URL::asset('build/libs/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/metismenu/metisMenu.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/simplebar/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/node-waves/waves.min.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script>
    window.addEventListener('open-modal', event => {
        $('.bs-example-modal-lg').modal('show');
    })

    window.addEventListener('close-modal', event => {
        $('.bs-example-modal-lg').modal('hide');
    })

    window.addEventListener('column-modal', event => {
        $('.modalColumn').modal('show');
    })

    window.addEventListener('close-columnModal', event => {
        $('.modalColumn').modal('hide');
    })

    window.addEventListener('close-updateModal', event => {
        $('.updateModal').modal('hide');
    })

    window.addEventListener('close-updateColumnModal', event => {
        $('.updateColumnModal').modal('hide');
    })

    window.addEventListener('open-taskModal', event => {
        $('.addTaskModal').modal('show');
    })

    window.addEventListener('open-subtaskModal', event => {
        $('#subTaskModal').modal('show');
    })

    window.addEventListener('close-taskModal', event => {
        $('.addTaskModal').modal('hide');
        $('.updateTaskModal').modal('hide');
        $('.updateTasklistColumnModal').modal('hide');
        $('.addColumnModal').modal('hide');
        $('#editSubtaskModal').modal('hide');
    })

    $('#change-password').on('submit', function(event) {
        event.preventDefault();
        var Id = $('#data_id').val();
        var current_password = $('#current-password').val();
        var password = $('#password').val();
        var password_confirm = $('#password-confirm').val();
        $('#current_passwordError').text('');
        $('#passwordError').text('');
        $('#password_confirmError').text('');
        $.ajax({
            url: "<?php echo e(url('update-password')); ?>" + "/" + Id,
            type: "POST",
            data: {
                "current_password": current_password,
                "password": password,
                "password_confirmation": password_confirm,
                "_token": "<?php echo e(csrf_token()); ?>",
            },
            success: function(response) {
                $('#current_passwordError').text('');
                $('#passwordError').text('');
                $('#password_confirmError').text('');
                if (response.isSuccess == false) {
                    $('#current_passwordError').text(response.Message);
                } else if (response.isSuccess == true) {
                    setTimeout(function() {
                        window.location.href = "<?php echo e(route('root')); ?>";
                    }, 1000);
                }
            },
            error: function(response) {
                $('#current_passwordError').text(response.responseJSON.errors.current_password);
                $('#passwordError').text(response.responseJSON.errors.password);
                $('#password_confirmError').text(response.responseJSON.errors
                    .password_confirmation);
            }
        });
    });
</script>

<?php echo $__env->yieldContent('script'); ?>

<!-- App js -->
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>

<?php echo $__env->yieldContent('script-bottom'); ?>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/layouts/vendor-scripts.blade.php ENDPATH**/ ?>