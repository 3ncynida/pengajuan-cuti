<?php

namespace App\Helpers;

use Carbon\Carbon;

class WorkingDaysCalculator
{
    const TOTAL_WORKING_DAYS = 240;
    
    public static function calculateRemainingDays($hireDate, $usedLeaveDays = 0)
    {
        $hireDate = Carbon::parse($hireDate);
        $yearEnd = Carbon::parse($hireDate)->endOfYear();
        
        // Calculate remaining months including current month
        $remainingMonths = $hireDate->diffInMonths($yearEnd) + 1;
        
        // Calculate total working days for this year
        $totalDays = ($remainingMonths * 20); // 20 working days per month
        
        // Subtract used leave days
        return $totalDays - $usedLeaveDays;
    }
}