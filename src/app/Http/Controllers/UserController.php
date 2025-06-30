<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\User;
use App\Models\Reservation;
use App\Models\VisitCode;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\ReviewRequest;



class UserController extends Controller
{
    public function makeReservation(ReservationRequest $request)
    {
        $shopId = $request->input('shop_id');
        $reservedDate = $request->input('date');
        $reservedTime = $request->input('time');
        $numberOfPeople = $request->input('number');
        $userId = Auth::id();

        Reservation::create([
            'user_id' => $userId,
            'shop_id' => $shopId,
            'reserved_date' => $reservedDate,
            'reserved_time' => $reservedTime,
            'number_of_people' => $numberOfPeople,
        ]);

        return view('shops.done', compact('shopId'));
    }

    public function showMypage()
    {
        $loginUser = Auth::user();
        $userName = $loginUser->name;
        $reservations = $loginUser->reservations()
            ->with('shop')
            ->where('visited', false)
            ->orderBy('reserved_date', 'asc')
            ->get();

        $hasUnreviewed = $loginUser->reservations()
            ->where('visited', true)
            ->whereDoesntHave('review')
            ->exists();

        $favorites = $loginUser->favorites;

        return view('user.mypage', compact('userName', 'reservations', 'favorites', 'hasUnreviewed'));
    }

    public function cancelReservation($reservationId)
    {
        $reservation = Reservation::where('user_id', Auth::id())->findOrFail($reservationId);
        $reservation->delete();

        return redirect()->route('mypage');
    }

    public function updateReservation(ReservationRequest $request, $reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        $reservation->reserved_date = $request->reserved_date;
        $reservation->reserved_time = $request->reserved_time;
        $reservation->number_of_people = $request->number_of_people;
        $reservation->save();

        return back()->with(['success' => '予約を変更しました。']);
    }

    public function showQrCode($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        $visitCode = $reservation->VisitCode ?? VisitCode::create([
            'reservation_id' => $reservation->id,
            'token' => Str::uuid(),
        ]);

        $datetimeString = $reservation->reserved_date . ' ' . $reservation->reserved_time;
        $reservation->reservationDayTime = date('Y-m-d H:i', strtotime($datetimeString));

        $qrUrl = route('visit.verify', ['token' => $visitCode->token]);
        $qrCode = QrCode::size(250)->generate($qrUrl);

        return view('user.qr', [
            'qrCode' => $qrCode,
            'reservation' => $reservation,
        ]);
    }

    public function showReviewForm()
    {
        $loginUser = Auth::user();

        $unreviewedReservations = $loginUser->reservations()
            ->with(['shop', 'review'])
            ->where('visited', true)
            ->whereDoesntHave('review')
            ->orderBy('reserved_date', 'desc')
            ->get();

        return view('user.reviews.list', compact('unreviewedReservations'));
    }

    public function showCreateReviewForm(Reservation $reservation)
    {
        return view('user.reviews.create', compact('reservation'));
    }

    public function submitReview(ReviewRequest $request)
    {
        $reservation = Reservation::findOrFail($request->reservation_id);

        Review::create([
            'user_id' => Auth::id(),
            'reservation_id' => $reservation->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('reviewed')->with('success', 'レビューを投稿しました。');
    }
}