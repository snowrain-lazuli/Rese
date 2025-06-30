<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\User;
use App\Models\Reservation;
use App\Models\VisitCode;
use Illuminate\Support\Facades\Auth;
use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\OwnerRequest;

class OwnerController extends Controller
{
    public function showDashboard()
    {
        $ownedShops = Shop::with('reservations.user')
            ->where('user_id', Auth::id())
            ->get();

        return view('owner.index', compact('ownedShops'));
    }

    public function storeShop(OwnerRequest $request)
    {
        $imagePath = $request->file('image') ? $request->file('image')->store('image', 'public') : null;
        $imageFileName = $imagePath ? basename($imagePath) : null;

        Shop::create([
            'name' => $request->name,
            'area' => $request->area,
            'genre' => $request->genre,
            'description' => $request->description,
            'image_path' => $imageFileName,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('owner')->with('success', '店舗を作成しました');
    }

    public function updateShop(Request $request, Shop $shop)
    {
        if ($request->hasFile('image')) {
            if ($shop->image_path) {
                Storage::disk('public')->delete('image/' . $shop->image_path);
            }

            $newImagePath = $request->file('image')->store('image', 'public');
            $shop->image_path = basename($newImagePath);
        }

        $shop->update([
            'name' => $request->name,
            'area' => $request->area,
            'genre' => $request->genre,
            'description' => $request->description,
        ]);

        return redirect()->route('owner')->with('success', '店舗情報を更新しました');
    }

    public function showNotifyForm()
    {
        return view('owner.notify.form');
    }

    public function confirmNotify(Request $request)
    {
        $notifyData = $request->only(['subject', 'body']);
        return view('owner.notify.confirm', compact('notifyData'));
    }

    public function sendNotify(Request $request)
    {
        $notifyData = $request->only(['subject', 'body']);
        $targetUsers = User::where('role', 1)->get();

        foreach ($targetUsers as $user) {
            Mail::to($user->email)->send(new NotifyMail($notifyData['subject'], $notifyData['body']));
        }

        if (Auth::check()) {
            Mail::to(Auth::user()->email)->send(new NotifyMail($notifyData['subject'], $notifyData['body']));
        }

        return view('owner.notify.complete');
    }

    public function verifyVisit($token)
    {
        $visitCode = VisitCode::where('token', $token)
            ->with('reservation.user')
            ->first();

        if (!$visitCode) {
            return view('visit.result', ['status' => 'invalid']);
        }

        $reservation = $visitCode->reservation;
        return view('visit.confirm', compact('reservation'));
    }

    public function markVisited(Reservation $reservation)
    {
        if (!$reservation->visited) {
            $reservation->visited = true;
            $reservation->save();
        }

        return back()->with('success', '来店済みにしました');
    }
}