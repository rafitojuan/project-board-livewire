<div>
    <div class="mt-5">
        <h5 class="font-size-15"><i class="bx bx-message-dots text-muted align-middle me-1"></i> Komentar :
        </h5>

        <div>
            @foreach ($comment as $com)
                <div class="d-flex py-3">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-xs">
                            <img src="{{ URL::asset($com->user->avatar) }}" alt=""
                                class="img-fluid d-block rounded-circle">
                        </div>
                    </div>

                    <div class="flex-grow-1">
                        <h5 class="font-size-14 mb-1">{{ $com->user->name }}
                            {{-- <small class="text-muted float-end">2 hrs
                                Ago</small> --}}
                        </h5>
                        <p class="text-muted">{{ $com->body }}</p>
                        <div>
                            <a href="javascript: void(0);" class="text-success"
                                wire:click='selectReply({{ $com->id }})'><i class="mdi mdi-reply"></i> Balas
                                Pesan</a>
                        </div>

                        @if (isset($parentId) and $parentId == $com->id)
                            <form wire:submit.prevent='reply' class="mt-2">
                                <div class="mb-3">
                                    <label for="commentmessage-input" class="form-label">Balas Komentar
                                        {{ $com->user->name }}</label>
                                    <textarea class="form-control @error('body2') is-invalid @enderror" id="commentmessage-input" wire:model.defer='body2'
                                        placeholder="Sampaikan balasanmu..." rows="3"></textarea>
                                    @error('body2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-end">
                                    <button type="button" wire:click='closeComment'
                                        class="btn btn-secondary w-sm">Batal
                                    </button>
                                    <button type="submit" class="btn btn-success w-sm">Kirim <i
                                            class="bx bx-paper-plane"></i></button>
                                </div>
                            </form>
                        @endif
                        @if ($com->children)
                            @foreach ($com->children as $child)
                                <div class="d-flex pt-3">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-xs">
                                            <img src="{{ URL::asset($com->user->avatar) }}" alt=""
                                                class="img-fluid d-block rounded-circle">
                                        </div>
                                    </div>

                                    <div class="flex-grow-1">
                                        <h5 class="font-size-14 mb-1">{{ $child->user->name }}
                                            {{-- <small
                                                class="text-muted float-end">2
                                                hrs
                                                Ago</small> --}}
                                        </h5>
                                        <p class="text-muted">{{ $child->body }}</p>
                                        <div>
                                            <a href="javascript: void(0);" class="text-success"
                                                wire:click='selectReply({{ $child->id }})'><i
                                                    class="mdi mdi-reply"></i> Balas
                                                Pesan</a>
                                        </div>

                                        @if (isset($parentId) and $parentId == $child->id)
                                            <form wire:submit.prevent='reply' class="mt-2">
                                                <div class="mb-3">
                                                    <label for="commentmessage-input" class="form-label">Balas Komentar
                                                        {{ $child->user->name }}</label>
                                                    <textarea class="form-control @error('body2') is-invalid @enderror" id="commentmessage-input" wire:model.defer='body2'
                                                        placeholder="Sampaikan balasanmu..." rows="3"></textarea>
                                                    @error('body2')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="text-end">
                                                    <button type="button" wire:click='closeComment'
                                                        class="btn btn-secondary w-sm">Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-success w-sm">Kirim <i
                                                            class="bx bx-paper-plane"></i></button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <div class="mt-4">
        <h5 class="font-size-16 mb-3">Tinggalkan pesan disini!</h5>

        <form wire:submit='postComment'>
            <div class="mb-3">
                <label for="commentmessage-input" class="form-label">Komentar</label>
                <textarea class="form-control @error('body') is-invalid @enderror" id="commentmessage-input" wire:model.defer='body'
                    placeholder="Sampaikan insightmu..." rows="3"></textarea>
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success w-sm">Kirim <i class="bx bx-paper-plane"></i></button>
            </div>
        </form>
    </div>
</div>
