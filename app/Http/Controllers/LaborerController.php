<?php

namespace App\Http\Controllers;

use App\Models\Laborer;
use App\Models\ServiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\Caster\RedisCaster;

class LaborerController extends Controller
{
    public function laborerProfile($laborerId)
    {
        $user = auth()->user();
        if ($user->user_type !== 'employee' ||
            strtolower($user->employee->positionType->position_name ?? '') !== 'laborer' ||
            $user->user_id != $laborerId) {
            abort(403, 'Unauthorized access.');
        }

        $laborer = $user->employee;
        return view('pages.profile.employees.laborer.index', compact('laborer'));
    }

    public function laborerPanel()
    {
        $reservations = ServiceDetail::with([
            'serviceType',
            'service',
            'laborer.employee.user'
        ])
        ->whereNotNull('employee_id')
        ->get();

        return view('includes.employee.laborer.index', compact('reservations'));
    }
}
