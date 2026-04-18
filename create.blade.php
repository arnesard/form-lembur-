@extends('layouts.app')

@section('title', 'Ajukan Lembur')

@push('styles')
    <style>
        :root {
            --sky-500: #0ea5e9;
            --sky-600: #0284c7;
            --slate-50: #f8fafc;
            --slate-200: #e2e8f0;
            --slate-900: #0f172a;
        }

        .max-w-3xl {
            max-width: 48rem;
        }

        .form-control-custom {
            background-color: var(--slate-50);
            border: 1px solid var(--slate-200);
            padding: 0.75rem 1rem;
            border-radius: 0.85rem;
        }
    </style>
@endpush

@section('content')
    <div class="p-3 p-md-4 max-w-3xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('overtime.index') }}"
                class="btn btn-link text-decoration-none text-slate-500 p-0 mb-2 small d-inline-flex align-items-center gap-1">
                <i data-lucide="arrow-left" size="14"></i> Kembali
            </a>
            <h1 class="h3 fw-bold text-slate-900">Ajukan Lembur Baru</h1>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('overtime.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Nama Karyawan *</label>
                            <input type="text" name="employee_name" list="employeeList"
                                class="form-control form-control-custom" placeholder="Ketik atau pilih nama..." required
                                autocomplete="off">
                            <datalist id="employeeList">
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->name }}">{{ $employee->employee_id }} -
                                        {{ $employee->plant }}</option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Tanggal Lembur *</label>
                            <input type="date" name="overtime_date" class="form-control form-control-custom" required
                                value="{{ old('overtime_date', now()->format('Y-m-d')) }}"
                                max="{{ now()->format('Y-m-d') }}">
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="form-label fw-semibold">Jam Mulai *</label>
                            <input type="time" name="start_time" id="start_time" class="form-control form-control-custom"
                                required value="{{ old('start_time') }}">
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="form-label fw-semibold">Jam Selesai *</label>
                            <input type="time" name="end_time" id="end_time" class="form-control form-control-custom"
                                required value="{{ old('end_time') }}">
                        </div>

                        <div id="durationPreview" class="col-12 d-none">
                            <div class="alert alert-info border-0 rounded-3 py-2 px-3 mb-0 d-flex align-items-center justify-content-between"
                                style="background-color: #f0f9ff; color: #0284c7;">
                                <div class="d-flex align-items-center gap-2">
                                    <i data-lucide="info" size="14"></i>
                                    <span class="small fw-semibold">Total Lembur Dihitung: <span id="durationText">0</span>
                                        Jam</span>
                                </div>
                                <span id="capWarning" class="text-xs d-none" style="color: #0369a1;">(Dipotong istirahat /
                                    Max 7 jam)</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Alasan Lembur *</label>
                            <textarea name="reason" class="form-control form-control-custom" rows="4" required
                                placeholder="Jelaskan alasan pengajuan lembur...">{{ old('reason') }}</textarea>
                        </div>

                        <div class="col-12 pt-2">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm"
                                style="background-color: var(--sky-500); border: none;">
                                Ajukan Lembur
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function calculateDuration() {
            const start = document.getElementById('start_time').value;
            const end = document.getElementById('end_time').value;
            const preview = document.getElementById('durationPreview');
            const text = document.getElementById('durationText');
            const warning = document.getElementById('capWarning');

            if (start && end) {
                const startDate = new Date(`2000-01-01T${start}`);
                const endDate = new Date(`2000-01-01T${end}`);

                if (endDate > startDate) {
                    let diff = (endDate - startDate) / (1000 * 60 * 60);
                    let capped = Math.min(7, diff);

                    text.textContent = capped;
                    preview.classList.remove('d-none');

                    if (diff > 7) {
                        warning.classList.remove('d-none');
                    } else {
                        warning.classList.add('d-none');
                    }
                } else if (start && end) {
                    // Overnight logic: end time is technically next day
                    let diff = ((endDate - startDate) / (1000 * 60 * 60)) + 24;
                    let capped = Math.min(7, diff);

                    text.textContent = capped;
                    preview.classList.remove('d-none');
                    warning.classList.add('d-none');
                    if (diff > 7) warning.classList.remove('d-none');
                } else {
                    preview.classList.add('d-none');
                }
            } else {
                preview.classList.add('d-none');
            }
        }

        document.getElementById('start_time').addEventListener('change', calculateDuration);
        document.getElementById('end_time').addEventListener('change', calculateDuration);

        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
@endpush
