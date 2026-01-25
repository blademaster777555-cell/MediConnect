@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-chat-square-quote-fill me-2"></i>{{ __('Quản lý Phản hồi') }}
            </h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Danh sách đánh giá từ bệnh nhân') }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('Bệnh nhân') }}</th>
                            <th>{{ __('Bác sĩ') }}</th>
                            <th>{{ __('Đánh giá') }}</th>
                            <th>{{ __('Nhận xét') }}</th>
                            <th>{{ __('Ngày tạo') }}</th>
                            <th>{{ __('Thao tác') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($feedbacks as $feedback)
                        <tr>
                            <td>{{ $feedback->id }}</td>
                            <td>
                                <div>{{ $feedback->appointment->patientProfile->user->name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $feedback->appointment->patientProfile->user->email ?? '' }}</small>
                            </td>
                            <td>
                                <div>{{ $feedback->appointment->doctorProfile->user->name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $feedback->appointment->doctorProfile->specialization->name ?? '' }}</small>
                            </td>
                            <td>
                                <div class="text-warning">
                                    @for($i=1; $i<=5; $i++)
                                        @if($i <= $feedback->rating)
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </td>
                            <td>{{ Str::limit($feedback->comment, 50) }}</td>
                            <td>{{ $feedback->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.feedbacks.show', $feedback->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Bạn có chắc muốn xóa phản hồi này?') }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $feedbacks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
