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


class ContentsController extends Controller
{
    public function index(Request $request)
    {
        // old() → $request->input() に置き換え（検索状態の保持はセッションでOK）
        $area = $request->old('area', '');
        $genre = $request->old('genre', '');
        $keyword = $request->old('keyword', '');

        $query = Shop::query();

        if ($area) {
            $query->where('area', $area);
        }

        if ($genre) {
            $query->where('genre', $genre);
        }

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('area', 'like', '%' . $keyword . '%')
                    ->orWhere('genre', 'like', '%' . $keyword . '%');
            });
        }

        $shops = $query->get();

        $user = auth()->user();
        $favorites = $user ? $user->favorites->pluck('id')->toArray() : [];

        $areas = Shop::select('area')->distinct()->pluck('area');
        $genres = Shop::select('genre')->distinct()->pluck('genre');

        return view('index', compact('shops', 'favorites', 'areas', 'genres'));
    }

    public function search(Request $request)
    {
        return redirect()->route('shop.index')->withInput();
    }


    public function favorite(Request $request)
    {
        $shopId = $request->input('shop_id');
        $user = Auth::user();
        $redirectTo = $request->input('redirect_to', '/');

        if ($user->favorites()->where('shop_id', $shopId)->exists()) {
            $user->favorites()->detach($shopId); // お気に入り解除
        } else {
            $user->favorites()->attach($shopId); // お気に入り登録
        }

        return redirect($redirectTo);
    }

    public function show($shop_id)
    {
        // shopsテーブルからshop_idでデータを取得
        $shop = Shop::findOrFail($shop_id);

        return view('show', compact('shop'));
    }

    public function reservation(Request $request)
    {
        $shop_id = $request->input('shop_id');
        $date = $request->input('date');
        $time = $request->input('time');
        $number = $request->input('number');
        $user_id = Auth::user()->id;

        Reservation::create([
            'user_id' => $user_id,
            'shop_id' => $shop_id,
            'reserved_date' => $date,
            'reserved_time' => $time,
            'number_of_people' => $number,
        ]);
        return view('done', compact('shop_id'));
    }

    public function mypage()
    {
        $user = Auth::user();
        $UserName = $user->name;

        $reservations = $user->reservations()->with('shop')->where('visited', false)->orderBy('reserved_date', 'asc')->get();

        $hasUnreviewed = $user->reservations()
            ->where('visited', true)
            ->whereDoesntHave('review')
            ->exists();

        $favorites = $user->favorites;

        return view('mypage', compact('UserName', 'reservations', 'favorites', 'hasUnreviewed'));
    }

    public function destroy($id)
    {
        $reservation = Reservation::where('user_id', Auth::id())->findOrFail($id);
        $reservation->delete();

        return redirect()->route('mypage');
    }


    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->reserved_date = $request->reserved_date;
        $reservation->reserved_time = $request->reserved_time;
        $reservation->number_of_people = $request->number_of_people;
        $reservation->save();

        return back()->with(['success' => '予約を変更しました。']);
    }

    public function owner() {
        $userId = Auth::id();
        $shops = Shop::with('reservations.user')
            ->where('user_id', Auth::id())
            ->get();
        return view('owner', compact('shops'));
    }

    public function storeShop(Request $request)
    {
        $path = $request->file('image') ? $request->file('image')->store('image', 'public') : null;
        $filename = $path ? basename($path) : null;
        
        Shop::create([
            'name' => $request->name,
            'area' => $request->area,
            'genre' => $request->genre,
            'description' => $request->description,
            'image_path' => $filename,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('owner')->with('success', '店舗を作成しました');
    }

    public function modifyShop(Request $request, Shop $shop)
    {
        if ($request->hasFile('image')) {
            if ($shop->image_path) {
                Storage::disk('public')->delete('image/' . $shop->image_path);
            }
            $newPath = $request->file('image')->store('image', 'public');
            $shop->image_path = basename($newPath); // ファイル名のみ保存
        }

        $shop->update([
            'name' => $request->name,
            'area' => $request->area,
            'genre' => $request->genre,
            'description' => $request->description,
        ]);

        return redirect()->route('owner')->with('success', '店舗情報を更新しました');
    }

    public function showForm()
    {
        return view('notify.form');
    }

    public function confirm(Request $request)
    {
        $data = $request->only(['subject', 'body']);
        return view('notify.confirm', compact('data'));
    }

    public function send(Request $request)
    {
        $data = $request->only(['subject', 'body']);

        // role=1 の全ユーザ取得
        $users = User::where('role', 1)->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new NotifyMail($data['subject'], $data['body']));
        }

        // 管理者にも送信（認証済み管理者を想定）
        if (auth()->user()) {
            Mail::to(auth()->user()->email)->send(new NotifyMail($data['subject'], $data['body']));
        }

        return view('notify.complete');
    }

    public function displayQr($id)
    {
        $reservation = Reservation::findOrFail($id);

        $token = $reservation->VisitCode ?? VisitCode::create([
            'reservation_id' => $reservation->id,
            'token' => Str::uuid()
        ]);

        $datetimeString = $reservation->reserved_date . ' ' . $reservation->reserved_time;

        $reservation_day_time = date('Y-m-d H:i', strtotime($datetimeString));

        $reservation->reservation_day_time = $reservation_day_time;

        $url = route('visit.verify', ['token' => $token->token]);
        $qr = QrCode::size(250)->generate($url);

        return view('qr.show', [
            'qrCode' => $qr,
            'reservation' => $reservation,
        ]);
    }

    public function verify($token)
    {
        $VisitCode = VisitCode::where('token', $token)->with('reservation.user')->first();

        if (!$VisitCode) {
            return view('visit.result', ['status' => 'invalid']);
        }

        $reservation = $VisitCode->reservation;

        return view('visit.confirm', [
            'reservation' => $reservation,
        ]);
    }

    public function mark(Reservation $reservation)
    {
        if (!$reservation->visited) {
            $reservation->visited = true;
            $reservation->save();
        }

        return back()->with('success', '来店済みにしました');
    }

    public function reviewed()
    {
        $user = Auth::user();

        $unreviewedReservations = $user->reservations()
            ->with(['shop', 'review'])
            ->where('visited', 1)
            ->whereDoesntHave('review')
            ->orderBy('reserved_date', 'desc')
            ->get();

        return view('reviews.list', compact('unreviewedReservations'));
    }

    public function create(Reservation $reservation)
    {

        return view('reviews.create', compact('reservation'));
    }

    // レビュー登録処理
    public function store(Request $request)
    {
        $reservation = Reservation::findOrFail($request->reservation_id);

        Review::create([
            'user_id' => auth()->id(),
            'reservation_id' => $reservation->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('reviewed')->with('success', 'レビューを投稿しました。');
    }
}