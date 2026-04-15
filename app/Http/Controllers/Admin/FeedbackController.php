<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function index(): View
    {
        return view('admin.feedbacks.index');
    }

    public function datatable(): mixed
    {
        return datatables()
            ->of(Feedback::select('*'))
            ->addColumn('actions', fn($f) => view('admin.partials.datatable.feedback-actions', [
                'id'     => $f->id,
                'is_read' => $f->is_read,
            ])->render())
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function markRead(Feedback $feedback): \Illuminate\Http\JsonResponse
    {
        $feedback->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }
}
