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
                @error('judul')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="border-bottom border border-secondary mt-0 mb-3"></div>
                <div wire:ignore>
                    <textarea id="content" cols="30" rows="10" wire:model='content'></textarea>
                </div>
                @error('content')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label for="">Tentukan tenggat waktu pengumuman,</label> <br>
                        <input type="date" id="end_date" wire:model="end_at" class="form-control">
                        @error('end_at')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="">Buat perihal atau kategori dari pengumuman</label> <br>
                        <input type="text" id="category" wire:model="category" class="form-control"
                            placeholder="Performa musiman">
                        @error('category')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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

@push('script')
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
                    @this.set('content', contents);
                    document.querySelector('[data-error="content"]')?.remove();
                }
            }
        });
    </script>
@endpush
