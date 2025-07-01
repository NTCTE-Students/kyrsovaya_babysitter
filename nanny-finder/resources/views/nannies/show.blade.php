@extends('layouts.app')

@section('title', $nanny->name)

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="{{ $nanny->photo ? asset('storage/' . $nanny->photo) : 'https://via.placeholder.com/300' }}" 
                         class="profile-img mb-3" alt="{{ $nanny->name }}">
                    <h2>{{ $nanny->name }}</h2>
                    <p class="text-muted">{{ $nanny->location }}</p>
                    <div class="rating mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($nanny->reviews_avg_rating))
                                <i class="bi bi-star-fill"></i>
                            @elseif($i - 0.5 <= $nanny->reviews_avg_rating)
                                <i class="bi bi-star-half"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                        <span>({{ $nanny->reviews_count ?? 0 }} отзывов)</span>
                    </div>
                    <button class="btn btn-primary w-100 mb-3">Связаться</button>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h3 class="h5 mb-0">Информация</h3>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Опыт работы:</strong> {{ $nanny->experience_years }} лет</li>
                    <li class="list-group-item"><strong>Возраст:</strong> {{ $nanny->age }} лет</li>
                    <li class="list-group-item"><strong>Ставка:</strong> ${{ $nanny->hourly_rate }}/час</li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="h5 mb-0">Услуги</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($nanny->services as $service)
                            <span class="badge bg-primary">{{ $service->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h2 class="h4 mb-0">О себе</h2>
                </div>
                <div class="card-body">
                    <p>{{ $nanny->bio }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0">Отзывы</h2>
                    @auth
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                            Оставить отзыв
                        </button>
                    @endauth
                </div>
                <div class="card-body">
                    @forelse($nanny->reviews as $review)
                        <div class="review mb-4 pb-3 border-bottom">
                            <div class="d-flex justify-content-between mb-2">
                                <h3 class="h5 mb-0">{{ $review->user->name }}</h3>
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p class="text-muted small">{{ $review->created_at->format('d.m.Y H:i') }}</p>
                            <p>{{ $review->comment }}</p>
                        </div>
                    @empty
                        <div class="alert alert-info">Пока нет отзывов</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно для отзыва -->
    @auth
    <div class="modal fade" id="reviewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Оставить отзыв</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('reviews.store', $nanny->nanny_profiles_id) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rating" class="form-label">Оценка</label>
                            <select class="form-select" id="rating" name="rating" required>
                                <option value="5">Отлично</option>
                                <option value="4">Хорошо</option>
                                <option value="3">Удовлетворительно</option>
                                <option value="2">Плохо</option>
                                <option value="1">Очень плохо</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Комментарий</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endauth
@endsection

@section('scripts')
    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));
                reviewModal.show();
            });
        </script>
    @endif
@endsection