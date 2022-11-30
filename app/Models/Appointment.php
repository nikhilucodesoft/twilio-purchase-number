<?php

namespace App\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $dates = ['when', 'notificationTime'];

    public function scopeAppointmentsDue($query)
    {
        $now = Carbon::now();
        $inTenMinutes = Carbon::now()->addMinutes(10);
        return $query->where('notificationTime', '>=', $now)->where('notificationTime', '<=', $inTenMinutes);
    }
}
