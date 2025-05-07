<?php

namespace App\Helpers;

use Carbon\Carbon;

class LeaveCalculator 
{
    const WORKING_DAYS_PER_MONTH = 20;
    const MAX_ANNUAL_LEAVE = 12;

    public static function calculateWorkingDays($hireDate)
    {
        $hireDate = Carbon::parse($hireDate);
        $yearEnd = Carbon::parse($hireDate)->endOfYear();
        
        // Calculate remaining months including current month
        $remainingMonths = $hireDate->diffInMonths($yearEnd) + 1;
        
        return $remainingMonths * self::WORKING_DAYS_PER_MONTH;
    }

    public static function calculateAnnualLeave($hireDate)
    {
        // If hire date is in current year, give full 12 days
        $hireDate = Carbon::parse($hireDate);
        if ($hireDate->year === Carbon::now()->year) {
            return self::MAX_ANNUAL_LEAVE;
        }
        
        return self::MAX_ANNUAL_LEAVE;
    }
}