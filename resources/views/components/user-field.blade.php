<div class="container d-flex float-start">
    <div class="">
        <img src="{{ asset($row->avatar) }}" alt="Profile Photo" class="rounded-circle" style="width: 40px; height: 40px;">
    </div>
    <div class="ms-2">
        <p class="mb-0 fw-bold">{{ $row->name }}</p>
        <small class="text-muted">{{ $row->{'role.name'} }}</small>
    </div>
</div>
