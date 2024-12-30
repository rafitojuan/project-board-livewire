<div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 btn btn-outline-secondary btn-sm"
                    onclick="window.location.href='<?php echo e(route('pengumuman.index', ['id' => $idTim])); ?>'">
                    <i class="bx bx-chevron-left" style="transition: transform 0.3s ease; cursor: pointer;"
                        onmouseover="this.style.transform='translateX(-5px)'"
                        onmouseout="this.style.transform='translateX(0)'">
                    </i>
                    <span>kembali</span>
                </div>
                <div class="pt-3">
                    <div class="row justify-content-center">
                        <div class="col-xl-8">
                            <div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <a href="#" class="badge bg-primary font-size-12">
                                            <i class="bx bx-purchase-tag-alt align-middle text-light me-1"></i>
                                            <?php echo e($announcement['category']); ?>

                                        </a>
                                    </div>
                                    <h4><?php echo e($announcement['title']); ?></h4>
                                    <p class="text-muted mb-4"><i class="mdi mdi-calendar me-1"></i>
                                        <?php echo e(\Carbon\Carbon::parse($announcement['created_at'])->format('d M, Y')); ?></p>
                                </div>

                                <hr>
                                <div class="text-center">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div>
                                                <p class="text-muted mb-2">Kategori</p>
                                                <h5 class="font-size-15"><?php echo e($announcement['category']); ?></h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mt-4 mt-sm-0">
                                                <p class="text-muted mb-2">Tanggal</p>
                                                <h5 class="font-size-15"><?php echo e(\Carbon\Carbon::parse($announcement['created_at'])->format('d M, Y')); ?></h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mt-4 mt-sm-0">
                                                <p class="text-muted mb-2">Di publish oleh</p>
                                                <h5 class="font-size-15"><?php echo e($announcement['user']['name']); ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                

                                

                                <div class="mt-4">
                                    <div class="text-muted font-size-14">
                                        <?php echo $announcement['content']; ?>


                                    </div>

                                    <hr>

                                    <div class="mt-5">
                                        <h5 class="font-size-15"><i
                                                class="bx bx-message-dots text-muted align-middle me-1"></i> Comments :
                                        </h5>

                                        <div>
                                            <div class="d-flex py-3">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-xs">
                                                        <div class="avatar-title rounded-circle bg-light text-primary">
                                                            <i class="bx bxs-user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="font-size-14 mb-1">Delores Williams <small
                                                            class="text-muted float-end">1 hr Ago</small></h5>
                                                    <p class="text-muted">If several languages coalesce, the grammar of
                                                        the resulting language is more simple and regular than that of
                                                        the individual</p>
                                                    <div>
                                                        <a href="javascript: void(0);" class="text-success"><i
                                                                class="mdi mdi-reply"></i> Reply</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex py-3 border-top">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-xs">
                                                        <img src="<?php echo e(URL::asset('build/images/users/avatar-2.jpg')); ?>"
                                                            alt="" class="img-fluid d-block rounded-circle">
                                                    </div>
                                                </div>

                                                <div class="flex-grow-1">
                                                    <h5 class="font-size-14 mb-1">Clarence Smith <small
                                                            class="text-muted float-end">2 hrs Ago</small></h5>
                                                    <p class="text-muted">Neque porro quisquam est, qui dolorem ipsum
                                                        quia dolor sit amet</p>
                                                    <div>
                                                        <a href="javascript: void(0);" class="text-success"><i
                                                                class="mdi mdi-reply"></i> Reply</a>
                                                    </div>

                                                    <div class="d-flex pt-3">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar-xs">
                                                                <div
                                                                    class="avatar-title rounded-circle bg-light text-primary">
                                                                    <i class="bx bxs-user"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex-grow-1">
                                                            <h5 class="font-size-14 mb-1">Silvia Martinez <small
                                                                    class="text-muted float-end">2 hrs Ago</small></h5>
                                                            <p class="text-muted">To take a trivial example, which of us
                                                                ever undertakes laborious physical exercise</p>
                                                            <div>
                                                                <a href="javascript: void(0);" class="text-success"><i
                                                                        class="mdi mdi-reply"></i> Reply</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex py-3 border-top">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-xs">
                                                        <div class="avatar-title rounded-circle bg-light text-primary">
                                                            <i class="bx bxs-user"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex-grow-1">
                                                    <h5 class="font-size-14 mb-1">Keith McCoy <small
                                                            class="text-muted float-end">12 Aug</small></h5>
                                                    <p class="text-muted">Donec posuere vulputate arcu. phasellus
                                                        accumsan cursus velit</p>
                                                    <div>
                                                        <a href="javascript: void(0);" class="text-success"><i
                                                                class="mdi mdi-reply"></i> Reply</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h5 class="font-size-16 mb-3">Leave a Message</h5>

                                        <form>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="commentname-input" class="form-label">Name</label>
                                                        <input type="text" class="form-control"
                                                            id="commentname-input" placeholder="Enter name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="commentemail-input"
                                                            class="form-label">Email</label>
                                                        <input type="email" class="form-control"
                                                            id="commentemail-input" placeholder="Enter email">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="commentmessage-input" class="form-label">Message</label>
                                                <textarea class="form-control" id="commentmessage-input" placeholder="Your message..." rows="3"></textarea>
                                            </div>

                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success w-sm">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
</div>
<?php /**PATH C:\laragon\www\epi-dasbor\resources\views/livewire/detail-pengumuman.blade.php ENDPATH**/ ?>