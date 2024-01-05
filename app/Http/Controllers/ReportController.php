<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Thread;
use App\Models\Post;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\ActivityNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class ReportController extends Controller
{
    //
    public function report(Request $request, $type, $id)
    {
        $reportable = null;

        switch ($type) {
            case 'thread':
                $reportable = Thread::find($id);
                break;
            case 'post':
                $reportable = Post::find($id);
                break;
            case 'reply':
                $reportable = Reply::find($id);
                break;
                // Add more cases for other reportable types if needed
        }

        if ($reportable) {

            $request->validate([
                'reason' => 'required'
            ]);
            // Create a new report
         
            $report = new Report([
                'reason' => $request->input('reason'),
                'reporter_id' => auth()->id(),
                'content_id' => $id,
                'content_type' => $type,
                // 'status' => 'open',
                'creator_id' => $request->input('creator_id'),
              
            ]);

            $report->save();

            // Notify admin/mods
            // $message = "New Report submitted by " . auth()->user()->role . " " . auth()->user()->name . " for a $type.";

            $message = "<a href='" . url('/admin/manage-reports') . "/#report-{$report->id}'>New Report submitted by " . auth()->user()->role . " " . auth()->user()->name . " for a $type.</a>";

            $adminModUsers = User::whereIn('role', ['admin', 'mod'])->get();
            Notification::send($adminModUsers, new ActivityNotification('new_report', [
                'message' => $message,
                'user' => auth()->user(),
            ]));
            // Handle the report as needed
            // ...

            return back()->with('success', 'Report submitted successfully.');
        }

        return back()->with('error', 'Reportable content not found.');
    }

    public function index()
    {

        $reports = Report::where('status', 'open')->get();

        $reports = $reports->map(function ($report) {
            $contentId = $report->content_id;
            $contentType = $report->content_type;
            $creatorId = $report->creator_id;
            $reporterId = $report->reporter_id;

            switch ($contentType) {
                case 'thread':
                    $thread = Thread::find($contentId);
                    if ($thread) {
                        $report->title = $thread->title;
                        $report->content = $thread->content;
                        $report->files = $thread->files ?? null;
                    }
                    break;
                case 'post':
                    $post = Post::find($contentId);
                    if ($post) {
                        $report->content = $post->content;
                        $report->files = $post->files ?? null;
                    }
                    break;

                case 'reply':
                    $reply = Reply::find($contentId);
                    if ($reply) {
                        $report->content = $reply->content;
                        $report->files = $reply->files ?? null;
                    }
                    break;

                    // Add more cases for other content types if needed
            }
            // setting reported content creator name
            $report->creator = User::find($creatorId)->name;
            // setting reported content creator email
            $report->creator_email = User::find($creatorId)->email;
            // setting reported content creator profile image
            $report->creator_image = User::find($creatorId)->profile_image;
            // setting reporter name
            $report->reporter_name = User::find($reporterId)->name;
            // setting reporter email
            $report->reporter_email = User::find($reporterId)->email;
            // setting reporter profile image
            $report->reporter_image = User::find($reporterId)->profile_image;
            return $report;
        });

        return view('admin.reports.index', compact('reports'));
    }



    public function delete($report_id, $id, $type)
    {
        $successMessage = "$type deleted by " . auth()->user()->role . " " . auth()->user()->name;
        $reporterMsg = "Your report was reviewed and reported $type has been deleted.";
        $creatorMsg = "Your $type has been deleted because it violated rules.";

        $reporter = Report::find($report_id)->reporter;
        // \Log::info("reporter: " . $reporter);
        $adminModUsers = User::whereIn('role', ['admin', 'mod'])->get();

        switch ($type) {
            case 'thread':
                $thread = Thread::find($id);
                if ($thread && $thread->delete()) {
                    $this->deleteFiles($thread->files);
                    Report::find($report_id)->delete();

                    // Send notification to admin and mod roles
                    // foreach ($adminModUsers as $user) {

                    //     $user->notify(new ActivityNotification('report', [
                    //         'blank' => "",
                    //         'message' => $successMessage,
                    //     ]));
                       
                    // }

                     Notification::send($adminModUsers, new ActivityNotification('report', [
                            'message' => $successMessage,
                            'blank' => "",
                        ]));

                        foreach ($adminModUsers as $user) {
                            $user->notifications()
                            ->where('created_at', '<', Carbon::now()->subDays(7))
                            ->delete();
                        }
                    $thread->user->notify(new ActivityNotification('report', [
                        'blank' => "",
                        'message' => $creatorMsg,
                    ]));

                    $thread->user->notifications()
                    ->where('created_at', '<', Carbon::now()->subDays(7))
                    ->delete();

                    $reporter->notify(new ActivityNotification('report', [
                        'blank' => "",
                        'message' => $reporterMsg,
                    ]));

                    $reporter->notifications()
                    ->where('created_at', '<', Carbon::now()->subDays(7))
                    ->delete();

                    return back();
                }
                break;

            case 'post':
                $post = Post::find($id);
                if ($post && $post->delete()) {
                    $this->deleteFiles($post->files);
                    Report::find($report_id)->delete();

                    // Send notification to admin and mod roles
                    // foreach ($adminModUsers as $user) {


                    //     $user->notify(new ActivityNotification('report', [
                    //         'blank' => "",
                    //         'message' => $successMessage,
                    //     ]));
                    // }

                    Notification::send($adminModUsers, new ActivityNotification('report', [
                        'message' => $successMessage,
                        'blank' => "",
                    ]));

                    foreach ($adminModUsers as $user) {
                        $user->notifications()
                        ->where('created_at', '<', Carbon::now()->subDays(7))
                        ->delete();
                    }

                    $post->user->notify(new ActivityNotification('report', [
                        'blank' => "",
                        'message' => $creatorMsg,
                    ]));

                    $post->user->notifications()
                        ->where('created_at', '<', Carbon::now()->subDays(7))
                        ->delete();
                    // \Log::info("reporter inside post: " . $reporter);
                    $reporter->notify(new ActivityNotification('report', [
                        'blank' => "",
                        'message' => $reporterMsg,
                    ]));

                    $reporter->notifications()
                        ->where('created_at', '<', Carbon::now()->subDays(7))
                        ->delete();
                    return back();
                }
                break;

            case 'reply':
                $reply = Reply::find($id);
                if ($reply && $reply->delete()) {
                    $this->deleteFiles($reply->files);
                    Report::find($report_id)->delete();

                    // Send notification to admin and mod roles
                    // foreach ($adminModUsers as $user) {

                    //     $user->notify(new ActivityNotification('report', [
                    //         'blank' => "",
                    //         'message' => $successMessage,
                    //     ]));
                    // }

                    Notification::send($adminModUsers, new ActivityNotification('report', [
                        'message' => $successMessage,
                        'blank' => "",
                    ]));
                    
                    foreach ($adminModUsers as $user) {
                        $user->notifications()
                        ->where('created_at', '<', Carbon::now()->subDays(7))
                        ->delete();
                    }

                    $reply->user->notify(new ActivityNotification('report', [
                        'blank' => "",
                        'message' => $creatorMsg,
                    ]));

                    $reply->user->notifications()
                    ->where('created_at', '<', Carbon::now()->subDays(7))
                    ->delete();

                    $reporter->notify(new ActivityNotification('report', [
                        'blank' => "",
                        'message' => $reporterMsg,
                    ]));

                    $reporter->notifications()
                    ->where('created_at', '<', Carbon::now()->subDays(7))
                    ->delete();
                    return back();
                }
                break;

                // Add more cases for other content types if needed
        }

        return back()->with('error', 'Failed to delete ' . $type . '.');
    }

    private function deleteFiles($filePaths)
    {
        if (!empty($filePaths)) {
            foreach ($filePaths as $filePath) {
                $fullPath = public_path('storage/' . $filePath);

                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
        }
    }




    public function updateStatus($id)
    {
        $report = Report::findOrFail($id);
        // Update report status to 'closed' or handle as needed
        $report->status = 'closed';
        $report->save();
        return back()->with('success', 'Report status updated successfully.');
    }
}
