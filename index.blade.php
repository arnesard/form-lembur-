@extends('layouts.app')

@section('title', 'Lembur')

@push('styles')
    <style>
        :root {
            --sky-500: #0ea5e9;
            --sky-600: #0284c7;
            --sky-light: #f0f9ff;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-900: #0f172a;
            --primary-gradient: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
            --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --info-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        }

        .max-w-7xl {
            max-width: 80rem;
        }

        .card-vibrant {
            border: none !important;
            color: white !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease !important;
        }

        .card-vibrant .h2 {
            color: white !important;
        }

        .card-vibrant .text-xs {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .bg-gradient-sky {
            background: var(--primary-gradient);
        }

        .bg-gradient-success {
            background: var(--success-gradient);
        }

        .bg-gradient-info {
            background: var(--info-gradient);
        }

        .icon-box-white {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(4px);
            color: white;
        }

        .form-control-custom {
            background-color: var(--slate-50);
            border: 1px solid var(--slate-200);
            padding: 0.6rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.2s;
        }

        .form-control-custom:focus {
            background-color: #fff;
            border-color: var(--sky-500);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        .overtime-record {
            border: 1px solid var(--slate-100);
            border-radius: 1rem;
            transition: all 0.2s;
        }

        .overtime-record:hover {
            background-color: var(--slate-50);
            border-color: var(--slate-200);
        }

        .badge-status-pending {
            background-color: #fef3c7;
            color: #d97706;
        }

        .badge-status-approved {
            background-color: #dcfce7;
            color: #16a34a;
        }

        .badge-status-rejected {
            background-color: #fee2e2;
            color: #dc2626;
        }

        /* Hidden on screen, shown only when printing */
        .print-only {
            display: none;
        }

        @media print {
            @page {
                size: portrait;
                margin: 1.5cm 1cm;
            }

            body {
                padding: 0 !important;
                margin: 0 !important;
                background: white !important;
                color: #000 !important;
            }

            .no-print {
                display: none !important;
            }

            .print-only {
                display: block !important;
                margin-bottom: 8px !important;
            }

            /* ── Strip ALL wrappers that add width/margin/padding ── */
            .max-w-7xl {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .mx-auto {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .p-3,
            .p-md-4,
            .p-4 {
                padding: 0 !important;
            }

            .mt-4,
            .mt-2 {
                margin-top: 0 !important;
            }

            /* ── KEY FIX: Bootstrap g-4 row has negative margins; col has padding ── */
            .row {
                --bs-gutter-x: 0 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .col-12,
            [class*="col-"] {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            /* ── Card cleanup ── */
            #print-table-section .card,
            #print-table-section .card-body,
            #print-table-section .card-header,
            #print-table-section .table-responsive {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            /* ── Table ── */
            #print-table-section .table {
                width: 100% !important;
                border-collapse: collapse !important;
                table-layout: fixed !important;
                margin: 0 !important;
            }

            /* Column widths: Karyawan 38%, Tanggal 14%, Waktu 14%, Pekerjaan 34% */
            #print-table-section .table th:nth-child(1),
            #print-table-section .table td:nth-child(1) {
                width: 38% !important;
            }

            #print-table-section .table th:nth-child(2),
            #print-table-section .table td:nth-child(2) {
                width: 14% !important;
            }

            #print-table-section .table th:nth-child(3),
            #print-table-section .table td:nth-child(3) {
                width: 14% !important;
            }

            #print-table-section .table th:nth-child(4),
            #print-table-section .table td:nth-child(4) {
                width: 34% !important;
            }

            #print-table-section .table th,
            #print-table-section .table td {
                padding: 2px 5px !important;
                border: 1px solid #64748b !important;
                font-size: 9px !important;
                word-break: break-word !important;
                overflow: hidden !important;
                line-height: 1.3 !important;
            }

            #print-table-section .table th {
                background-color: #e2e8f0 !important;
                font-weight: bold !important;
                color: #000 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            /* Remove Bootstrap's py-3 tall row padding when printing */
            #print-table-section .table td.py-3,
            #print-table-section .table td[class*="py-"] {
                padding-top: 2px !important;
                padding-bottom: 2px !important;
            }

            tr.overtime-row {
                break-inside: avoid;
            }
        }
    </style>
@endpush

@section('content')
    <div class="p-3 p-md-4 max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="mb-4 d-flex justify-content-between align-items-center no-print">
            <div>
                <h1 class="h3 fw-bold text-slate-900 mb-1">Pengajuan Lembur</h1>
                <p class="text-slate-600 mb-0">Catat dan monitor jam lembur karyawan</p>
            </div>
        </div>

        {{-- Print Only Header --}}
        <div class="print-only text-center">
            <h5 class="fw-bold mb-1" style="font-size: 15px; text-decoration: underline; letter-spacing: 0.5px;">LAPORAN
                PENGAJUAN LEMBUR</h5>
            <p style="font-size: 11px; color: #475569; margin-bottom: 6px;">Periode: {{ now()->translatedFormat('F Y') }}</p>
        </div>

        {{-- Stats Cards --}}
        <div class="row g-3 mb-4 no-print">
            <div class="col-12 col-md-4">
                <div class="card h-100 card-vibrant bg-gradient-sky rounded-4 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-xs font-bold text-uppercase tracking-wider mb-1">Total Pengajuan</p>
                                <p class="h2 fw-bold mb-0">{{ $overtimes->count() }}</p>
                            </div>
                            <div class="p-3 icon-box-white rounded-circle">
                                <i data-lucide="calendar" size="24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card h-100 card-vibrant bg-gradient-success rounded-4 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-xs font-bold text-uppercase tracking-wider mb-1">Total Jam</p>
                                @php
                                    $totalHours = $overtimes
                                        ->filter(fn($ot) => $ot->status == 'approved')
                                        ->sum(function ($ot) {
                                            $start = \Carbon\Carbon::parse($ot->start_time);
                                            $end = \Carbon\Carbon::parse($ot->end_time);
                                            if ($end->lt($start)) {
                                                $end->addDay();
                                            }
                                            $gross = $start->diffInHours($end);
                                            return min(7, $gross);
                                        });
                                @endphp
                                <p class="h2 fw-bold mb-0">{{ number_format($totalHours, 1) }}</p>
                            </div>
                            <div class="p-3 icon-box-white rounded-circle">
                                <i data-lucide="clock" size="24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card h-100 card-vibrant bg-gradient-info rounded-4 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-xs font-bold text-uppercase tracking-wider mb-1">Bulan Ini</p>
                                <p class="h2 fw-bold mb-0 text-capitalize">{{ now()->translatedFormat('F') }}</p>
                            </div>
                            <div class="p-3 icon-box-white rounded-circle">
                                <i data-lucide="calendar" size="24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2">
            {{-- Form Input --}}
            <div class="col-12 col-lg-8 mx-auto no-print">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-slate-900 mb-3">Form Pengajuan Lembur</h5>

                        @if (session('success'))
                            <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4 small">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger border-0 rounded-3 shadow-sm mb-4 small">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ route('overtime.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Karyawan *</label>
                                <input type="hidden" name="employee_name" id="ot-employee-name-hidden" required>
                                <div class="position-relative" id="ot-operator-search-wrapper">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i data-lucide="search"
                                                size="18"></i></span>
                                        <input type="text" id="ot-operator-search"
                                            class="form-control form-control-custom border-start-0 border-end-0 shadow-none"
                                            placeholder="Ketik nama atau ID karyawan..." autocomplete="off">
                                        <button type="button" class="btn btn-outline-secondary px-3" id="ot-btn-clear"
                                            title="Hapus" style="display:none;">
                                            <i data-lucide="x" size="18"></i>
                                        </button>
                                    </div>
                                    <div id="ot-operator-dropdown"
                                        class="position-absolute w-100 bg-white border rounded-3 shadow mt-1 overflow-auto"
                                        style="max-height: 220px; z-index: 100; display: none;">
                                        @foreach ($employees as $employee)
                                            <div class="operator-option px-3 py-2" style="cursor: pointer;"
                                                data-id="{{ $employee->employee_id }}" data-name="{{ $employee->name }}">
                                                <span class="fw-bold">{{ $employee->employee_id }}</span>
                                                <span class="text-muted mx-1">—</span>
                                                <span>{{ $employee->name }}</span>
                                            </div>
                                        @endforeach
                                        <div id="ot-no-result" class="px-3 py-2 text-muted small" style="display: none;">
                                            Tidak ditemukan</div>
                                    </div>
                                </div>
                            </div>
                            <div id="manualEmployeeBox" class="d-none mt-3">

                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">ID Karyawan (Manual)</label>
                                    <input type="text" name="employee_id_manual" class="form-control form-control-custom"
                                        placeholder="Contoh: EMP001">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Nama Karyawan (Manual)</label>
                                    <input type="text" name="employee_name_manual"
                                        class="form-control form-control-custom" placeholder="Nama lengkap">
                                </div>

                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Tanggal *</label>
                                <input type="date" name="overtime_date" class="form-control form-control-custom"
                                    value="{{ now()->format('Y-m-d') }}" required>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label class="form-label fw-semibold small">Jam Mulai *</label>
                                    <input type="time" name="start_time" id="start_time"
                                        class="form-control form-control-custom" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-semibold small">Jam Selesai *</label>
                                    <input type="time" name="end_time" id="end_time"
                                        class="form-control form-control-custom" required>
                                </div>
                            </div>

                            <div id="durationPreview" class="alert alert-info border-0 rounded-3 py-2 px-3 mb-3 d-none"
                                style="background-color: #f0f9ff; color: #0284c7;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <i data-lucide="info" size="14"></i>
                                        <span class="small fw-semibold">Estimasi: <span id="durationText">0</span>
                                            Jam</span>
                                    </div>
                                    <span id="capWarning" class="text-xs d-none" style="color: #0369a1;">(Maksimal 7
                                        jam)</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold small">Job *</label>
                                <textarea name="reason" class="form-control form-control-custom" rows="4"
                                    placeholder="Contoh: Bongkar muat barang tipe A..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm"
                                style="background-color: var(--sky-500); border: none;">
                                Ajukan Lembur
                            </button>
                            <button type="button" id="toggleManualBtn"
                                class="btn w-100 mt-2 rounded-pill py-2 fw-bold text-white shadow-sm"
                                style="background: linear-gradient(135deg, #10b981, #22c55e); border: none; box-shadow: 0 6px 18px rgba(16, 185, 129, 0.35); transition: 0.2s;">
                                Ajukan Lembur dari Bagian Lain
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Overtime List --}}
            <div class="col-12 print-full-width mt-4" id="print-table-section">
                <div class="card border-0 shadow-sm rounded-4 print-no-border">
                    <div class="card-header bg-white border-bottom-0 p-4 no-print">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                            <div>
                                <h5 class="fw-bold text-slate-900 mb-1">Laporan Pengajuan Lembur</h5>
                                <p class="text-xs text-muted mb-0">Antrean persetujuan dan riwayat lembur</p>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <button onclick="window.print()"
                                    class="btn btn-sm btn-outline-primary fw-bold px-3 shadow-sm"
                                    style="border-radius: 0.5rem;">
                                    <i data-lucide="printer" size="14" class="me-1"></i> Cetak
                                </button>
                            </div>
                        </div>

                        {{-- Filter Form & Search --}}
                        <div class="bg-light p-3 rounded-3 border">
                            <div class="row g-3 align-items-end">
                                {{-- JS Search --}}
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-slate-600 mb-1"
                                        style="font-size: 13px;">Pencarian Cepat</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control border-0 shadow-sm pe-4"
                                            id="searchOvertime" placeholder="Cari nama karyawan..."
                                            onkeyup="searchOvertimeTable()">
                                        <i data-lucide="search" class="position-absolute text-muted"
                                            style="right: 12px; top: 50%; transform: translateY(-50%); opacity: 0.5;"
                                            size="16"></i>
                                    </div>
                                </div>

                                {{-- AJAX Date Filter --}}
                                <div class="col-md-8">
                                    <form id="filterForm" action="{{ route('overtime.index') }}" method="GET"
                                        class="row g-2 align-items-end m-0">
                                        <div class="col-sm-4">
                                            <label class="form-label fw-bold text-slate-600 mb-1"
                                                style="font-size: 13px;">Dari Tanggal</label>
                                            <input type="date" name="start_date"
                                                class="form-control border-0 shadow-sm"
                                                value="{{ $startDate ?? now()->format('Y-m-d') }}">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label fw-bold text-slate-600 mb-1"
                                                style="font-size: 13px;">Sampai Tanggal</label>
                                            <input type="date" name="end_date" class="form-control border-0 shadow-sm"
                                                value="{{ $endDate ?? now()->format('Y-m-d') }}">
                                        </div>
                                        <div class="col-sm-4 d-flex gap-2">
                                            <button type="submit" class="btn btn-primary flex-grow-1 fw-bold shadow-sm"
                                                style="border-radius: 0.5rem;">
                                                Search
                                            </button>
                                            <button type="button" id="resetFilterBtn"
                                                class="btn btn-outline-secondary fw-bold shadow-sm" title="Reset"
                                                style="border-radius: 0.5rem;">
                                                <i data-lucide="rotate-ccw" size="16" class="me-1"></i> Reset
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @php
                            // Normalize names for better matching
                            $employeeMap = \App\Models\Employee::all()->mapWithKeys(function ($emp) {
                                return [trim(strtoupper($emp->name)) => $emp->employee_id];
                            });
                        @endphp
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="overtimeTable">
                                <thead style="background: var(--slate-50);">
                                    <tr>
                                        <th class="text-slate-600 font-semibold small border-bottom-0 py-3 rounded-start">
                                            Karyawan</th>
                                        <th class="text-slate-600 font-semibold small border-bottom-0 py-3">Tanggal</th>
                                        <th class="text-slate-600 font-semibold small border-bottom-0 py-3">Waktu</th>
                                        <th class="text-slate-600 font-semibold small border-bottom-0 py-3">Pekerjaan</th>
                                        <th
                                            class="text-slate-600 font-semibold small border-bottom-0 py-3 text-end no-print rounded-end">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="overtimeTableBody" style="transition: opacity 0.2s;">
                                    @include('overtime._table_body')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header border-bottom-0 p-4 pb-0">
                    <h5 class="fw-bold">Edit Lembur <span id="editEmployeeName" class="text-primary"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST" class="ajax-action-form" data-action-type="edit">
                    @csrf @method('PUT')
                    <div class="modal-body p-4">
                        <input type="hidden" name="employee_name" id="edit_employee_name">
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold text-slate-600 mb-1">Tanggal Lembur *</label>
                            <input type="date" name="overtime_date" id="edit_overtime_date"
                                class="form-control form-control-sm border-0 shadow-sm bg-light" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label text-xs fw-bold text-slate-600 mb-1">Mulai *</label>
                                <input type="time" name="start_time" id="edit_start_time"
                                    class="form-control form-control-sm border-0 shadow-sm bg-light" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-xs fw-bold text-slate-600 mb-1">Selesai *</label>
                                <input type="time" name="end_time" id="edit_end_time"
                                    class="form-control form-control-sm border-0 shadow-sm bg-light" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold text-slate-600 mb-1">Job *</label>
                            <textarea name="reason" id="edit_reason" class="form-control form-control-sm border-0 shadow-sm bg-light"
                                rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 p-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Simpan</button>
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
                    warning.classList.add('d-none'); // Usually capped at 7 anyway
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

        // === SEARCHABLE DROPDOWN KARYAWAN ===
        (function() {
            const searchInput = document.getElementById('ot-operator-search');
            const dropdown = document.getElementById('ot-operator-dropdown');
            const hiddenInput = document.getElementById('ot-employee-name-hidden');
            const options = document.querySelectorAll('#ot-operator-dropdown .operator-option');
            const noResult = document.getElementById('ot-no-result');
            const btnClear = document.getElementById('ot-btn-clear');

            if (!searchInput) return;

            searchInput.addEventListener('focus', function() {
                dropdown.style.display = 'block';
                filterOptions();
            });

            searchInput.addEventListener('input', function() {
                filterOptions();
                btnClear.style.display = searchInput.value ? 'block' : 'none';
            });

            function filterOptions() {
                const query = searchInput.value.toLowerCase();
                let found = 0;
                options.forEach(opt => {
                    const name = opt.dataset.name.toLowerCase();
                    const id = opt.dataset.id.toLowerCase();
                    if (name.includes(query) || id.includes(query)) {
                        opt.style.display = 'block';
                        found++;
                    } else {
                        opt.style.display = 'none';
                    }
                });
                noResult.style.display = found === 0 ? 'block' : 'none';
            }

            btnClear.addEventListener('mousedown', function(e) {
                e.preventDefault();
                searchInput.value = '';
                hiddenInput.value = '';
                searchInput.style.borderColor = '';
                btnClear.style.display = 'none';
                dropdown.style.display = 'block';
                filterOptions();
                searchInput.focus();
            });

            options.forEach(opt => {
                opt.addEventListener('mousedown', function(e) {
                    e.preventDefault();
                    searchInput.value = this.dataset.name;
                    hiddenInput.value = this.dataset.name;
                    dropdown.style.display = 'none';
                    searchInput.style.borderColor = '#198754';
                    btnClear.style.display = 'block';
                });
                opt.addEventListener('mouseenter', function() {
                    this.style.background = '#f0f9ff';
                });
                opt.addEventListener('mouseleave', function() {
                    this.style.background = '';
                });
            });

            document.addEventListener('click', function(e) {
                if (!document.getElementById('ot-operator-search-wrapper').contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
        })();

        function searchOvertimeTable() {
            var input = document.getElementById('searchOvertime').value.toLowerCase();
            var rows = document.querySelectorAll('#overtimeTable tbody tr.overtime-row');
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
            });
        }

        function openEditModal(id, name, date, start_time, end_time, reason) {
            document.getElementById('editEmployeeName').textContent = name;
            document.getElementById('editForm').action = `/overtime/${id}`;
            document.getElementById('editForm').dataset.rowId = id;

            document.getElementById('edit_employee_name').value = name;
            document.getElementById('edit_overtime_date').value = date;
            document.getElementById('edit_start_time').value = start_time.substring(0, 5);
            document.getElementById('edit_end_time').value = end_time.substring(0, 5);
            document.getElementById('edit_reason').value = reason;
            const modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
        }

        // === AJAX ACTIONS (Edit, Delete) ===
        document.addEventListener('submit', function(e) {
            if (e.target && e.target.classList.contains('ajax-action-form')) {
                e.preventDefault();
                const form = e.target;
                const actionUrl = form.action;
                const method = form.querySelector('input[name="_method"]')?.value || form.method;
                const formData = new FormData(form);
                const rowId = form.dataset.rowId;
                const actionType = form.dataset.actionType;
                const btn = form.querySelector('button[type="submit"]');

                if (btn) {
                    btn.disabled = true;
                    const originalHtml = btn.innerHTML;
                    btn.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
                }

                fetch(actionUrl, {
                        method: 'POST', // Always POST for Laravel, we use _method for PUT/PATCH/DELETE
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const row = document.getElementById(`row-${rowId}`);
                            if (actionType === 'delete') {
                                if (row) row.remove();
                            } else if (actionType === 'edit') {
                                // Close Modal and reload table data perfectly
                                loadFilteredData();
                                const modalEl = document.getElementById('editModal');
                                const modal = bootstrap.Modal.getInstance(modalEl);
                                if (modal) modal.hide();
                            }
                        } else {
                            alert('Gagal: ' + (data.message || 'Terjadi kesalahan.'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan jaringan.');
                    })
                    .finally(() => {
                        if (btn) {
                            btn.disabled = false;
                            if (actionType === 'edit') {
                                btn.innerHTML = 'Simpan';
                            }
                        }
                    });
            }
        });

        function openDeleteModal(id, name) {
            document.getElementById('deleteName').textContent = name;

            const form = document.getElementById('deleteForm');
            form.action = `/overtime/delete/${id}`; // SESUAI ROUTE KAMU

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
        // === AJAX FILTER ===
        const filterForm = document.getElementById('filterForm');
        const tableBody = document.getElementById('overtimeTableBody');
        const resetBtn = document.getElementById('resetFilterBtn');

        if (filterForm) {
            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                loadFilteredData();
            });

            if (resetBtn) {
                resetBtn.addEventListener('click', function() {
                    filterForm.querySelector('input[name="start_date"]').value = '{{ now()->format('Y-m-d') }}';
                    filterForm.querySelector('input[name="end_date"]').value = '{{ now()->format('Y-m-d') }}';
                    loadFilteredData();
                });
            }

            function loadFilteredData() {
                const formData = new FormData(filterForm);
                const queryParams = new URLSearchParams(formData).toString();
                const fetchUrl = filterForm.action + '?' + queryParams + '&filter_request=1';

                tableBody.style.opacity = '0.5';

                fetch(fetchUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(res => res.text())
                    .then(html => {
                        tableBody.innerHTML = html;
                        tableBody.style.opacity = '1';
                        if (window.lucide) {
                            lucide.createIcons();
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        tableBody.style.opacity = '1';
                        alert('Gagal memuat data!');
                    });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
        const toggleBtn = document.getElementById('toggleManualBtn');
        const manualBox = document.getElementById('manualEmployeeBox');
        const searchBox = document.getElementById('ot-operator-search-wrapper');
        const hiddenInput = document.getElementById('ot-employee-name-hidden');

        let isManual = false;

        toggleBtn.addEventListener('click', function() {
            isManual = !isManual;

            if (isManual) {
                manualBox.classList.remove('d-none');
                searchBox.style.display = 'none';
                hiddenInput.value = '';

                toggleBtn.textContent = 'Pakai Input Karyawan Normal';
            } else {
                manualBox.classList.add('d-none');
                searchBox.style.display = 'block';

                toggleBtn.textContent = 'Ajukan Lembur dari Bagian Lain';
            }
        });
        const btn = document.getElementById('toggleManualBtn');

        if (btn) {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 10px 25px rgba(34, 197, 94, 0.5)';
                this.style.filter = 'brightness(1.1)';
            });

            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 6px 18px rgba(16, 185, 129, 0.35)';
                this.style.filter = 'brightness(1)';
            });
        }
    </script>
@endpush
