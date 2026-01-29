@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">{{ __('User Details') }}</h5>
    </div>
    <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Full Name') }}</label>
                    <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Avatar') }}</label>
                    <div class="d-flex align-items-center gap-2">
                         <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" width="40" height="40" class="rounded-circle" style="object-fit: cover;">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Login Email') }}</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Phone Number') }}</label>
                    <input type="text" class="form-control" value="{{ $user->phone ?? $user->doctorProfile->phone ?? '---' }}" disabled>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('City') }}</label>
                    <input type="text" class="form-control" value="{{ $user->city->name ?? $user->doctorProfile->city->name ?? '---' }}" disabled>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">{{ __('Role') }}</label>
                    <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                </div>

                @if($user->role === \App\Models\User::ROLE_DOCTOR)
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Approval Status') }}</label>
                    <div class="d-flex align-items-center gap-3">
                        @if($user->doctorProfile->is_approved)
                            <span class="badge bg-success py-2 px-3"><i class="bi bi-check-circle me-1"></i> {{ __('Approved') }}</span>
                        @else
                            <span class="badge bg-warning text-dark py-2 px-3"><i class="bi bi-hourglass-split me-1"></i> {{ __('Pending') }}</span>
                        @endif
                            
                        <!-- Action Buttons (Always Visible) -->
                        <div class="ms-3 d-flex gap-2">
                            <!-- Reject Profile Button -->
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="bi bi-x-circle me-1"></i> {{ __('Reject Profile') }}
                            </button>

                            <!-- Approve Button -->
                            <button type="button" class="btn btn-sm btn-success" onclick="handleMainApprove()">
                                <i class="bi bi-check-lg me-1"></i> {{ __('Approve / Update') }}
                            </button>
                        </div>
                    </div>
                        @if($user->doctorProfile->rejection_reason && !$user->doctorProfile->is_approved)
                            <div class="alert alert-danger mt-2 mb-0 py-2">
                                <small><strong>{{ __('Rejection Reason:') }}</strong> {{ $user->doctorProfile->rejection_reason }}</small>
                            </div>
                        @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Specialization') }}</label>
                    <input type="text" class="form-control" value="{{ $user->doctorProfile->specialization->name ?? '---' }}" disabled>
                </div>
                
                <div class="col-12 mb-3">
                    <label class="form-label">{{ __('Degrees / Certificates') }}</label>
                    <div class="border rounded p-3 bg-light">
                        @if(!empty($user->doctorProfile->certificate))
                            <form id="reject-certs-form" action="{{ route('admin.doctors.certificates.reject', $user->id) }}" method="POST">
                                @csrf
                                <div class="row g-2 mb-3">
                                    @php
                                        $certs = $user->doctorProfile->certificate;
                                        if (is_string($certs)) {
                                             $decoded = json_decode($certs, true);
                                             $certs = is_array($decoded) ? $decoded : [$certs];
                                        } elseif (!is_array($certs)) {
                                             $certs = [$certs];
                                        }

                                        // Normalize for view
                                        $displayCerts = [];
                                        foreach ($certs as $cert) {
                                            if (is_string($cert)) {
                                                $displayCerts[] = ['path' => $cert, 'status' => 'pending'];
                                            } else {
                                                $displayCerts[] = $cert;
                                            }
                                        }
                                    @endphp

                                    @foreach($displayCerts as $cert)
                                        <div class="col-auto">
                                            <div class="card h-100 shadow-sm {{ ($cert['status'] ?? '') == 'approved' ? 'border-success' : (($cert['status'] ?? '') == 'rejected' ? 'border-danger' : '') }}" style="width: 150px;">
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/' . $cert['path']) }}" class="card-img-top" alt="Certificate" style="height: 100px; object-fit: cover; cursor: pointer;" onclick="showImageModal('{{ asset('storage/' . $cert['path']) }}')">
                                                    
                                                    <!-- Status Badge -->
                                                    <span class="position-absolute top-0 end-0 badge {{ ($cert['status'] ?? '') == 'approved' ? 'bg-success' : (($cert['status'] ?? '') == 'rejected' ? 'bg-danger' : 'bg-warning') }} m-1">
                                                        @if(($cert['status'] ?? '') == 'approved') <i class="bi bi-check"></i>
                                                        @elseif(($cert['status'] ?? '') == 'rejected') <i class="bi bi-x"></i>
                                                        @else <i class="bi bi-hourglass"></i>
                                                        @endif
                                                    </span>

                                                    <!-- Checkbox for actions (Hide if approved) -->
                                                    @if(($cert['status'] ?? '') != 'approved')
                                                    <div class="position-absolute top-0 start-0 p-1">
                                                        <input class="form-check-input border-dark" type="checkbox" name="selected_certificates[]" value="{{ $cert['path'] }}" style="transform: scale(1.3);">
                                                    </div>
                                                    

                                                    @endif
                                                </div>
                                                <div class="card-footer p-1 text-center bg-transparent border-top-0">
                                                    <small class="fw-bold {{ ($cert['status'] ?? '') == 'approved' ? 'text-success' : (($cert['status'] ?? '') == 'rejected' ? 'text-danger' : 'text-warning') }}">
                                                        {{ ucfirst($cert['status'] ?? 'pending') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </form>
                        @else
                            <span class="text-muted fst-italic">{{ __('Certificates not updated') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">{{ __('Bio') }}</label>
                    <textarea class="form-control" rows="4" disabled>{{ $user->doctorProfile->bio ?? '' }}</textarea>
                </div>
                @endif
            </div>

            <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> {{ __('Back') }}
            </a>
    </div>
</div>



<!-- Approval Confirmation Modal -->
<!-- Selective Approval Modal -->
<div class="modal fade" id="confirmSelectiveApproveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-check-all me-2"></i>{{ __('Confirm Approval') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="fw-bold">{{ __('Do you want to approve the selected images?') }}</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary fw-bold" onclick="submitSelectiveApprove()">{{ __('Confirm Approval') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmApproveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-shield-check me-2"></i>{{ __('Confirm Doctor Approval') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Are you sure you want to approve the entire profile of doctor') }} <strong>{{ $user->name }}</strong>?</p>
                <p class="mb-0 text-muted small">{{ __('The profile will be publicly visible.') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <form action="{{ route('admin.doctors.approve', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success fw-bold">{{ __('Confirm Approval') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ __('Reject Doctor Profile') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.doctors.reject', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>{{ __('Please enter the reason for rejecting the profile of doctor') }} <strong>{{ $user->name }}</strong>.</p>
                    <div class="mb-3">
                        <label for="reason" class="form-label fw-bold">{{ __('Rejection Reason') }} <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required placeholder="{{ __('E.g., Blurred certificates, mismatching information...') }}"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-danger fw-bold">{{ __('Confirm Rejection') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body p-0 text-center position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="background-color: rgba(0,0,0,0.5);"></button>
                <img id="previewImage" src="" class="img-fluid rounded shadow-lg" style="max-height: 90vh;">
            </div>
        </div>
    </div>
</div>

<!-- Reject Certificates Modal -->
<div class="modal fade" id="rejectCertsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-images me-2"></i>{{ __('Reject Selected Images') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('You are rejecting these certificates. Please provide a reason:') }}</p>
                <div class="mb-3">
                    <label for="cert_reject_reason" class="form-label fw-bold">{{ __('Rejection Reason') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="cert_reject_reason" rows="3" required placeholder="{{ __('E.g., Blurred image, unclear information...') }}"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-danger fw-bold" onclick="submitRejectCertsForm()">{{ __('Confirm Rejection') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showImageModal(src) {
        document.getElementById('previewImage').src = src;
        var myModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        myModal.show();
    }

    function confirmRejectSelected() {
        const checkboxes = document.querySelectorAll('input[name="selected_certificates[]"]:checked');
        if (checkboxes.length === 0) {
            alert('{{ __("Please select at least one image to reject.") }}');
            return;
        }
        var myModal = new bootstrap.Modal(document.getElementById('rejectCertsModal'));
        myModal.show();
    }

    function submitRejectCertsForm() {
        const reason = document.getElementById('cert_reject_reason').value;
        if (!reason.trim()) {
            alert('{{ __("Please enter a rejection reason.") }}');
            return;
        }
        
        const form = document.getElementById('reject-certs-form');
        const reasonInput = document.createElement('input');
        reasonInput.type = 'hidden';
        reasonInput.name = 'reason';
        reasonInput.value = reason;
        form.appendChild(reasonInput);
        
        form.submit();
    }

    function handleMainApprove() {
        const checkboxes = document.querySelectorAll('input[name="selected_certificates[]"]:checked');
        
        if (checkboxes.length > 0) {
            // Show Selective Approval Modal
            var myModal = new bootstrap.Modal(document.getElementById('confirmSelectiveApproveModal'));
            myModal.show();
        } else {
            // Global Approval (No selection = Approve All)
            var myModal = new bootstrap.Modal(document.getElementById('confirmApproveModal'));
            myModal.show();
        }
    }

    function submitSelectiveApprove() {
        const form = document.getElementById('reject-certs-form');
        form.action = '{{ route("admin.doctors.certificates.approve", $user->id) }}';
        form.submit();
    }
    function quickApprove(path) {
        // Uncheck all first
        document.querySelectorAll('input[name="selected_certificates[]"]').forEach(el => el.checked = false);
        // Check only this one
        const checkbox = document.querySelector(`input[value="${path}"]`);
        if (checkbox) {
            checkbox.checked = true;
            // Trigger approval flow
            handleMainApprove();
        }
    }

    function quickReject(path) {
        // Uncheck all first
        document.querySelectorAll('input[name="selected_certificates[]"]').forEach(el => el.checked = false);
        // Check only this one
        const checkbox = document.querySelector(`input[value="${path}"]`);
        if (checkbox) {
            checkbox.checked = true;
            // Trigger reject flow
            confirmRejectSelected();
        }
    }
</script>

@endsection
