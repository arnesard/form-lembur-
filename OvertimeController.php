<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OvertimeData;
use App\Models\Employee;
use Carbon\Carbon;

class OvertimeController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::today()->format('Y-m-d'));

        $query = OvertimeData::select('id', 'employee_name', 'overtime_date', 'start_time', 'end_time', 'reason', 'created_at', 'updated_at');

        if ($startDate) {
            $query->whereDate('overtime_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('overtime_date', '<=', $endDate);
        }

        $overtimes = $query->orderBy('overtime_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $employees = Employee::orderBy('name')->get();
        $employeeMap = $employees->mapWithKeys(function ($emp) {
            return [trim(strtoupper($emp->name)) => $emp->employee_id];
        });

        if ($request->ajax() && $request->has('filter_request')) {
            return view('overtime._table_body', compact('overtimes', 'employeeMap'))->render();
        }

        return view('overtime.index', compact('overtimes', 'employees', 'startDate', 'endDate', 'employeeMap'));
    }

    public function create()
    {
        $employees = Employee::orderBy('name')->get();
        return view('overtime.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'overtime_date' => 'required|date|before_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'reason' => 'required|string|max:1000',

            'employee_name' => 'nullable|string|max:255',
            'employee_name_manual' => 'nullable|string|max:255',
            'employee_id_manual' => 'nullable|string|max:50',
        ]);

        if ($request->employee_name_manual) {
            $employeeName = $request->employee_name_manual;
        } else {
            $employeeName = $request->employee_name;
        }

        OvertimeData::create([
            'employee_name' => $employeeName,
            'overtime_date' => $request->overtime_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);
        return redirect()->route('overtime.index')
            ->with('success', 'Pengajuan lembur berhasil dikirim!');
    }

    public function update(Request $request, OvertimeData $overtime)
    {
        $request->validate([
            'employee_name' => 'required|string|max:255',
            'overtime_date' => 'required|date',
            'start_time' => 'required|date_format:H:i:s,H:i',
            'end_time' => 'required|date_format:H:i:s,H:i',
            'reason' => 'required|string|max:1000',
        ]);

        $overtime->update([
            'employee_name' => $request->employee_name,
            'overtime_date' => $request->overtime_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'reason' => $request->reason,
        ]);

        if ($request->wantsJson()) return response()->json(['success' => true, 'message' => 'Data lembur berhasil diperbarui!']);
        return redirect()->route('overtime.index')->with('success', 'Data lembur berhasil diperbarui!');
    }

    public function destroy(Request $request, OvertimeData $overtime)
    {

        $overtime->delete();

        if ($request->wantsJson()) return response()->json(['success' => true, 'message' => 'Dihapus.']);
        return redirect()->route('overtime.index')->with('success', 'Pengajuan lembur dihapus!');
    }
}
