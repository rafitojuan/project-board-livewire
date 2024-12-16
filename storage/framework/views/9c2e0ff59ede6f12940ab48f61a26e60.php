<div>
    <div class="container">
        <div class="row" style="margin-top: 3vh">
            <div class="col-md-4">
                <div class="card text-center rounded-5 " style="transition: all 0.3s ease; cursor:pointer;">
                    <div class="card-body"
                        onmouseover="this.parentElement.style.transform='translate(-5px, -5px)';this.parentElement.style.boxShadow='8px 8px 15px rgba(0,0,0,0.3)'"
                        onmouseout="this.parentElement.style.transform='translate(0)';this.parentElement.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)'">
                        <img src="<?php echo e(URL::asset('build/images/teams/chat.svg')); ?>" class="w-75" alt="logo chat">
                        <h4 class="card-text">Chat</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center rounded-5 " style="transition: all 0.3s ease; cursor:pointer;">
                    <div class="card-body"
                        onmouseover="this.parentElement.style.transform='translate(-5px, -5px)';this.parentElement.style.boxShadow='8px 8px 15px rgba(0,0,0,0.3)'"
                        onmouseout="this.parentElement.style.transform='translate(0)';this.parentElement.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)'">
                        <img src="<?php echo e(URL::asset('build/images/teams/pengumuman.svg')); ?>" class="w-75"
                            alt="logo pengumuman">
                        <h4 class="card-text">Pengumuman</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center rounded-5 " style="transition: all 0.3s ease; cursor:pointer;">
                    <div class="card-body" onclick="window.location.href='<?php echo e(route('kalendar.index')); ?>'"
                        onmouseover="this.parentElement.style.transform='translate(-5px, -5px)';this.parentElement.style.boxShadow='8px 8px 15px rgba(0,0,0,0.3)'"
                        onmouseout="this.parentElement.style.transform='translate(0)';this.parentElement.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)'">
                        <img src="<?php echo e(URL::asset('build/images/teams/kalendar.svg')); ?>" class="w-75"
                            alt="logo kalendar">
                        <h4 class="card-text">Kalendar</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card text-center rounded-5 " style="transition: all 0.3s ease; cursor:pointer;">
                    <div class="card-body"
                        onclick="window.location.href='<?php echo e(route('kanban.index', Crypt::encryptString($team['id']))); ?>'"
                        onmouseover="this.parentElement.style.transform='translate(-5px, -5px)';this.parentElement.style.boxShadow='8px 8px 15px rgba(0,0,0,0.3)'"
                        onmouseout="this.parentElement.style.transform='translate(0)';this.parentElement.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)'">
                        <img src="<?php echo e(URL::asset('build/images/teams/tugas.svg')); ?>" class="w-75" alt="logo tugas">
                        <h4 class="card-text">Projek</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center rounded-5 " style="transition: all 0.3s ease; cursor:pointer;">
                    <div class="card-body"
                        onmouseover="this.parentElement.style.transform='translate(-5px, -5px)';this.parentElement.style.boxShadow='8px 8px 15px rgba(0,0,0,0.3)'"
                        onmouseout="this.parentElement.style.transform='translate(0)';this.parentElement.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)'">
                        <img src="<?php echo e(URL::asset('build/images/teams/pertanyaan.svg')); ?>" class="w-75"
                            alt="logo pertanyaan">
                        <h4 class="card-text">Pertanyaan</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/tim-detail.blade.php ENDPATH**/ ?>