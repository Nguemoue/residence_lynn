<?php

declare(strict_types=1);

namespace App\Actions;

use App\Http\Requests\CheckoutRequest;
use App\Models\Booking;
use App\Notifications\BookingNotification;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CreateBookingAction
{
    /**
     * Execute the booking creation and send notifications.
     *
     * @param CheckoutRequest $request
     * @return Booking
     * @throws Exception
     */
    public function execute(CheckoutRequest $request): Booking
    {
        try {
            DB::beginTransaction();

            $booking = Booking::create([
                'user_id' => auth()->id(),
                'accommodation_id' => $request->accommodation_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'guest_number' => $request->guest_number,
                'status' => 'pending',
                'email' => $request->email,
                'phone' => $request->phone,
                'name' => $request->name,
                //'address_line1' => $request->address_line1,
                //'city' => $request->city,
                //'postal_code' => $request->postal_code,
                //'country' => $request->country,
            ]);

            // Send notification to authenticated user
            Notification::send(auth()->user(), new BookingNotification($booking));

            DB::commit();

            return $booking;
        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Booking creation failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
