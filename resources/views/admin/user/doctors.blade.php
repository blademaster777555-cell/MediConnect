@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>{{ __('Manage Doctors') }}</h2>
    <a href="{{ route('users.create') }}?role=doctor" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> {{ __('Add Doctor') }}
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Specialization') }}</th>
                    <th>{{ __('City') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Certificates') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
                            <div>
                                <div class="fw-bold">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->doctorProfile->phone ?? '---' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-info text-dark d-block p-2 fw-normal text-wrap" style="min-width: 100px;">
                            {{ $user->doctorProfile->specialization->name ?? '---' }}
                        </span>
                    </td>
                    <td>
                        {{ $user->doctorProfile->city->name ?? '---' }}
                    </td>
                    <td>
                        @if($user->doctorProfile && $user->doctorProfile->is_approved)
                            <span class="badge bg-success">{{ __('Approved') }}</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ __('Pending Approval') }}</span>
                        @endif
                    </td>
                    <td>
                        @if($user->doctorProfile && !empty($user->doctorProfile->certificate))
                            @php
                                $certs = $user->doctorProfile->certificate;
                                if (is_string($certs)) {
                                     $decoded = json_decode($certs, true);
                                     $certs = is_array($decoded) ? $decoded : [$certs];
                                } elseif (!is_array($certs)) {
                                     $certs = [$certs];
                                }
                                
                                $imageUrls = [];
                                foreach ($certs as $cert) {
                                    $path = is_array($cert) ? ($cert['path'] ?? '') : $cert;
                                    if ($path) {
                                        $imageUrls[] = asset('storage/' . $path);
                                    }
                                }
                                $certCount = count($imageUrls);
                            @endphp
                            
                            @if($certCount > 0)
                                <button type="button" class="btn btn-sm btn-outline-info" data-images='{{ json_encode($imageUrls) }}' onclick="showCertificates(this)">
                                    <i class="bi bi-images"></i> {{ $certCount }} {{ __('Images') }}
                                </button>
                            @else
                                <span class="text-muted small">{{ __('Image Error') }}</span>
                            @endif
                        @else
                            <span class="text-muted small">{{ __('None') }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            
                            <a href="{{ route('admin.doctors.schedule', $user->id) }}" class="btn btn-sm btn-info text-white shadow-sm" title="{{ __('Manage Schedule') }}" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; padding: 0;">
                                <i class="bi bi-calendar-week"></i>
                            </a>

                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-success shadow-sm" title="{{ __('View Details') }}" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; padding: 0;">
                                <i class="bi bi-eye"></i>
                            </a>

                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirmDelete(event, this);">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger shadow-sm" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; padding: 0;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection

@push('scripts')
<div class="modal fade" id="certPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body p-0 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3" data-bs-dismiss="modal" aria-label="Close" style="background-color: rgba(0,0,0,0.5);"></button>
                
                <div id="certCarousel" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner" id="certCarouselInner">
                        <!-- Images will be injected here -->
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#certCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.5); border-radius: 50%;"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#certCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.5); border-radius: 50%;"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showCertificates(btn) {
        try {
            // Use dataset which automatically handles parsing of data- attributes slightly differently (it returns string)
            // But we need to parse the JSON string.
            // data-images='["url"]' -> dataset.images = '["url"]'
            var images = JSON.parse(btn.getAttribute('data-images'));
            
            const carouselInner = document.getElementById('certCarouselInner');
            carouselInner.innerHTML = '';

            if (!images || images.length === 0) {
                alert('{{ __("No images to display") }}');
                return;
            }

            images.forEach((imgUrl, index) => {
                const activeClass = index === 0 ? 'active' : '';
                const item = `
                    <div class="carousel-item ${activeClass}">
                        <img src="${imgUrl}" class="d-block w-100 rounded shadow-lg" style="max-height: 85vh; object-fit: contain;">
                    </div>
                `;
                carouselInner.insertAdjacentHTML('beforeend', item);
            });

            // Show controls only if more than 1 image
            const prevBtn = document.querySelector('#certCarousel .carousel-control-prev');
            const nextBtn = document.querySelector('#certCarousel .carousel-control-next');
            if (images.length > 1) {
                prevBtn.classList.remove('d-none');
                nextBtn.classList.remove('d-none');
            } else {
                prevBtn.classList.add('d-none');
                nextBtn.classList.add('d-none');
            }

            var myModal = new bootstrap.Modal(document.getElementById('certPreviewModal'));
            myModal.show();
        } catch (e) {
            console.error(e);
            alert('{{ __("An error occurred while loading images") }}');
        }
    }
</script>
@endpush
