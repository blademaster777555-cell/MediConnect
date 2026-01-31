@extends('layouts.modern')

@section('title', __('Doctor Profile') . ' - MediConnect')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Sidebar -->
        <!-- Sidebar -->
        @include('partials.doctor-sidebar')

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card card-shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person-lines-fill me-2"></i>{{ __('Update Profile') }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(Auth::user()->doctorProfile->rejection_reason && !Auth::user()->doctorProfile->is_approved)
                        <div class="alert alert-danger mb-4">
                            <h5><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ __('Profile Rejected') }}</h5>
                            <p class="mb-0">{{ Auth::user()->doctorProfile->rejection_reason }}</p>
                            <small class="text-muted">{{ __('Please update your information or certificates for re-approval.') }}</small>
                        </div>
                    @endif

                    <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">{{ __('Full Name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name', Auth::user()->name) }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label fw-bold">{{ __('Avatar') }}</label>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" 
                                         alt="Avatar" class="rounded-circle shadow-sm" width="50" height="50" style="object-fit: cover;">
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-bold">{{ __('Phone Number') }}</label>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       value="{{ old('phone', $doctor->phone) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="specialization_id" class="form-label fw-bold">{{ __('Specialization') }}</label>
                                <select class="form-select" id="specialization_id" name="specialization_id" required>
                                    <option value="">{{ __('-- Select Specialization --') }}</option>
                                    @foreach($specializations as $spec)
                                        <option value="{{ $spec->id }}" 
                                            {{ (old('specialization_id', $doctor->specialization_id) == $spec->id) ? 'selected' : '' }}>
                                            {{ $spec->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city_id" class="form-label fw-bold">{{ __('City / Province') }}</label>
                                <select class="form-select" id="city_id" name="city_id" required>
                                    <option value="">{{ __('-- Select City --') }}</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" 
                                            {{ (old('city_id', $doctor->city_id) == $city->id) ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="license_number" class="form-label fw-bold">{{ __('Medical License Number') }}</label>
                                <input type="text" class="form-control" id="license_number" name="license_number" 
                                       value="{{ old('license_number', $doctor->license_number) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="consultation_fee" class="form-label fw-bold">{{ __('Consultation Fee (USD)') }}</label>
                                <input type="number" class="form-control" id="consultation_fee" name="consultation_fee" 
                                       value="{{ old('consultation_fee', $doctor->consultation_fee) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="certificate" class="form-label fw-bold">{{ __('Degrees/Certificates') }}</label>
                            <input type="file" class="form-control" id="certificate" name="certificate[]" accept="image/*" multiple>
                            <small class="text-muted fst-italic">{{ __('You can select multiple images.') }}</small>
                            
                            @if(!empty($doctor->certificate))
                                <div class="mt-2 row g-2">
                                    <p class="mb-1 text-muted small w-100">{{ __('Uploaded (Click trash icon to delete):') }}</p>
                                    @php
                                        $certs = $doctor->certificate ?? [];
                                        if (is_string($certs)) {
                                            $decoded = json_decode($certs, true);
                                            $certs = is_array($decoded) ? $decoded : [$certs];
                                        } 
                                        if (!is_array($certs)) {
                                            $certs = [$certs];
                                        }

                                        // Normalize
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
                                        @if(empty($cert['path'])) @continue @endif
                                        <div class="col-auto position-relative">
                                            <a href="{{ asset('storage/' . $cert['path']) }}" target="_blank" class="d-inline-block border rounded p-1 {{ ($cert['status'] ?? '') == 'approved' ? 'border-success' : (($cert['status'] ?? '') == 'rejected' ? 'border-danger' : '') }}">
                                                <img src="{{ asset('storage/' . $cert['path']) }}" alt="Certificate" height="80" class="d-block" onerror="this.style.display='none'">
                                            </a>
                                            
                                            {{-- Status Badge --}}
                                            @if(($cert['status'] ?? '') == 'approved')
                                                <span class="badge bg-success position-absolute top-0 start-0 m-1" style="font-size: 0.6rem;">{{ __('Approved') }}</span>
                                            @elseif(($cert['status'] ?? '') == 'rejected')
                                                <span class="badge bg-danger position-absolute top-0 start-0 m-1" style="font-size: 0.6rem;">{{ __('Rejected') }}</span>
                                            @else
                                                <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-1" style="font-size: 0.6rem;">{{ __('Pending') }}</span>
                                            @endif

                                            <button type="button" class="btn btn-sm btn-danger rounded-circle p-0 d-flex justify-content-center align-items-center shadow-sm position-absolute top-0 end-0"
                                                    style="width: 24px; height: 24px; transform: translate(30%, -30%); z-index: 10;"
                                                    data-image="{{ $cert['path'] }}"
                                                    onclick="deleteCertificate(this.getAttribute('data-image'))">
                                                <i class="bi bi-trash-fill" style="font-size: 12px;"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label fw-bold">{{ __('Bio') }}</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4">{{ old('bio', $doctor->bio) }}</textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="bi bi-save me-2"></i>{{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function deleteCertificate(imagePath) {
        Swal.fire({
            title: '{{ __("Are you sure you want to delete this certificate?") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{ __("Delete") }}',
            cancelButtonText: '{{ __("Cancel") }}'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("doctor.profile.certificate.delete") }}';
                
                let csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                let imageInput = document.createElement('input');
                imageInput.type = 'hidden';
                imageInput.name = 'image';
                imageInput.value = imagePath;
                form.appendChild(imageInput);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endpush
