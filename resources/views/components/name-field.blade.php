<div class="container">
    <span class="fw-semibold">{{ $row->name }}</span>
    @if ($row->url)
        <a href="{{ $row->url ?? '' }}"><i class="bi bi-link-45deg" title="URL"></i> </a><br>
    @else
        <br>
    @endif
    <span>PIC: {{ $row->pelaksana }}</span> <br>
    <small class="text-muted">Cttn: {{ $row->keterangan ? $row->keterangan : '-' }}</small>
</div>
