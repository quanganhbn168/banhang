<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function publicStore(Request $request)
{
    // Validate dữ liệu, thêm start_time
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'customer_phone' => 'required|string|max:15',
        'service_id' => 'required|exists:services,id',
        'title' => 'required|string|max:255',
        // Thêm rule cho start_time: bắt buộc, đúng định dạng và phải sau thời điểm hiện tại
        'start_time' => 'required|date|after:now',
    ]);

    // Tạo booking mới với đầy đủ thông tin thời gian
    Booking::create([
        'title' => $validated['title'],
        'status' => 'pending', // Trạng thái chờ admin xếp lịch
        
        // --- PHẦN SỬA ĐỔI ---
        'start_time' => $validated['start_time'],
        // Tự động gán end_time là 1 tiếng sau start_time để hiển thị trên lịch
        'end_time' => Carbon::parse($validated['start_time'])->addHour(),
    ]);

    return back()->with('success', 'Đặt lịch thành công! Chúng tôi sẽ liên hệ với bạn để xác nhận thời gian sớm nhất.');
}

    public function index()
    {
        return view('admin.bookings.calendar');
    }

    public function getEvents(Request $request)
    {
        // Bắt đầu với query builder
        $query = Booking::query();

        // Lọc theo status nếu có
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $bookings = $query->get();

        $events = $bookings->map(function ($booking) {
            $color = '#3788d8'; // Mặc định màu xanh
            if ($booking->status == 'pending') {
                $color = '#f0ad4e'; // Màu vàng cho pending
            } elseif ($booking->status == 'cancelled') {
                $color = '#d9534f'; // Màu đỏ cho cancelled
            }
            
            return [
                'id' => $booking->id,
                'title' => $booking->title,
                'start' => $booking->start_time,
                'end' => $booking->end_time,
                'status' => $booking->status, // Thêm status vào data
                'color' => $color, // Thêm thuộc tính color
            ];
        });

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $booking = Booking::create($request->all());

        return response()->json($booking);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'start_time' => 'sometimes|required|date',
            'end_time' => 'sometimes|required|date|after_or_equal:start_time',
            'status' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $booking->update($request->all());

        return response()->json($booking);
    }

    public function destroy($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }
}