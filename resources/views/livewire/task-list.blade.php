<div class="kanban-tasklist">
    <h3>{{ $tasklist->name }}</h3>
    <ul>
        @if ($tasklist->tasks && $tasklist->tasks->count())
            @foreach ($tasklist->tasks as $task)
                <li>{{ $task->name }}</li>
            @endforeach
        @else
            <li>Tidak ada tugas.</li> <!-- Pesan jika tidak ada tugas -->
        @endif
    </ul>
</div>
