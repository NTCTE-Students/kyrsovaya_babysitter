@extends('layouts.app')

@section('title', 'Поиск воспитателей')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h1>Поиск воспитателей</h1>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('nannies.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="location" class="form-label">Местоположение</label>
                        <input type="text" class="form-control" id="location" name="location" 
                               value="{{ request('location') }}" placeholder="Город или район">
                    </div>
                    <div class="col-md-2">
                        <label for="min_experience" class="form-label">Опыт (лет)</label>
                        <input type="number" class="form-control" id="min_experience" name="min_experience" 
                               value="{{ request('min_experience') }}" placeholder="Минимум">
                    </div>
                    <div class="col-md-2">
                        <label for="max_rate" class="form-label">Ставка ($/час)</label>
                        <input type="number" class="form-control" id="max_rate" name="max_rate" 
                               value="{{ request('max_rate') }}" placeholder="Максимум">
                    </div>
                    <div class="col-md-3">
                        <label for="services" class="form-label">Услуги</label>
                        <select class="form-select" id="services" name="services[]" multiple>
                            @foreach($services as $service)
                                <option value="{{ $service->service_id }}" 
                                    {{ in_array($service->service_id, request('services', [])) ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Найти</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($nannies as $nanny)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ $nanny->photo ? asset('storage/' . $nanny->photo) : 'https://via.placeholder.com/300' }}" 
                         class="card-img-top" alt="{{ $nanny->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $nanny->name }}</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">{{ $nanny->location }}</span>
                            <span class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($nanny->reviews_avg_rating))
                                        <i class="bi bi-star-fill"></i>
                                    @elseif($i - 0.5 <= $nanny->reviews_avg_rating)
                                        <i class="bi bi-star-half"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                                ({{ $nanny->reviews_count ?? 0 }})
                            </span>
                        </div>
                        <p class="card-text">{{ Str::limit($nanny->bio, 100) }}</p>
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item"><strong>Опыт:</strong> {{ $nanny->experience_years }} лет</li>
                            <li class="list-group-item"><strong>Ставка:</strong> ${{ $nanny->hourly_rate }}/час</li>
                        </ul>
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            @foreach($nanny->services->take(3) as $service)
                                <span class="badge bg-primary">{{ $service->name }}</span>
                            @endforeach
                            @if($nanny->services->count() > 3)
                                <span class="badge bg-secondary">+{{ $nanny->services->count() - 3 }}</span>
                            @endif
                        </div>
                        <a href="{{ route('nannies.show', $nanny->nanny_profiles_id) }}" class="btn btn-primary w-100">Подробнее</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">По вашему запросу воспитателей не найдено</div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $nannies->appends(request()->query())->links() }}
    </div>
@endsection

@section('scripts')
    <script>
        // Инициализация мультиселекта для услуг
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect('#services', {
                plugins: ['remove_button'],
                create: false,
                maxItems: null,
            });
        });
    </script>
@endsection