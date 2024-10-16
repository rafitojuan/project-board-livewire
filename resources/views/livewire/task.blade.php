<div>
    <div class="task" draggable="true" x-data=""
        @dragstart="$dispatch('dragstart', { id: {{ $task->id }} })"
        @dragstart.window="if ($event.detail.id === {{ $task->id }}) dragging = $event.detail.id"
        @dragend.window="if ($event.detail.id === {{ $task->id }}) dragging = null"
        @click="$wire.toggleNestedBoard()">
        {{ $task->name }}
    </div>
    @if ($showNestedBoard && $task->taskList)
        <livewire:task-list :taskList="$task->taskList" :wire:key="'nested-'.$task->id" />
    @endif
</div>
