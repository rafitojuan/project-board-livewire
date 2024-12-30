<?php

namespace App\Http\Livewire;

use App\Models\Announcement;
use App\Models\comment;
use Illuminate\Support\Facades\Crypt;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Komentar extends Component
{
    use LivewireAlert;
    public $body, $announcement, $comment, $parentId, $body2;

    public function mount($announcementId)
    {
        $this->announcement = $this->fetchAnnouncementById($announcementId);
        $this->comment = $this->fetchCommentById();
    }

    public function fetchCommentById()
    {
        $comment = comment::with('children')
            ->where('announcement_id', $this->announcement->id)
            ->whereNull('parent_id')
            ->get();
        return $comment;
    }

    public function fetchAnnouncementById($id)
    {
        $announcement = Announcement::find($id);
        return $announcement;
    }

    public function postComment()
    {
        $this->validate([
            'body' => 'required',
        ], [
            'body.required' => 'Komentar tidak boleh kosong',
        ]);

        comment::create([
            'body' => $this->body,
            'user_id' => auth()->user()->id,
            'announcement_id' => $this->announcement->id,
        ]);

        $this->body = NULL;
        $this->comment = $this->fetchCommentById();

        $this->alert('success', 'Komentar berhasil ditambahkan');
    }

    public function selectReply($commentId)
    {
        $this->parentId = $commentId;
        $this->body = NULL;
    }

    public function reply()
    {
        $this->validate([
            'body2' => 'required',
        ], [
            'body2.required' => 'Komentar tidak boleh kosong',
        ]);

        $comment = comment::find($this->parentId);
        $comment = comment::create([
            'user_id' => auth()->user()->id,
            'announcement_id' => $this->announcement->id,
            'parent_id' => $comment->parent_id ?? $comment->id,
            'body' => $this->body2,
        ]);

        $this->body2 = NULL;
        $this->parentId = NULL;
        $this->comment = $this->fetchCommentById();

        $this->alert('success', 'Balasan berhasil dikirim');
    }

    public function closeComment()
    {
        $this->body = NULL;
        $this->body2 = NULL;
        $this->parentId = NULL;
    }

    public function render()
    {
        return view('livewire.komentar', [
            'comment' => $this->comment,
        ]);
    }
}
