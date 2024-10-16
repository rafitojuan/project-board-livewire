<div class="kanban-column">
    <h2>{{ $column->name }}</h2>

    @foreach ($column->tasklists as $tasklist)
        <livewire:kanban-tasklist :tasklist="$tasklist" :key="$tasklist->id" />
    @endforeach
</div>
