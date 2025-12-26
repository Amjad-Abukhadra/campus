{{-- Page Header Component with Glassmorphism and Breadcrumb/Action combo --}}
@props([
    'title',
    'subtitle' => null,
    'breadcrumb' => [], // Array of ['label' => 'Home', 'link' => '/']
    'icon' => null,
])

<div class="card border-0 shadow-sm mb-5 glass-header overflow-hidden rounded-4">
    <div class="card-body p-4 p-md-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                {{-- Breadcrumb --}}
                @if(count($breadcrumb) > 0)
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb mb-0">
                            @foreach($breadcrumb as $item)
                                @if(!$loop->last)
                                    <li class="breadcrumb-item">
                                        <a href="{{ $item['link'] }}" class="text-decoration-none text-primary opacity-75 small fw-medium">
                                            {{ $item['label'] }}
                                        </a>
                                    </li>
                                @else
                                    <li class="breadcrumb-item active small fw-medium text-muted" aria-current="page">
                                        {{ $item['label'] }}
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </nav>
                @endif

                {{-- Title & Subtitle --}}
                <div class="d-flex align-items-center">
                    @if($icon)
                        <div class="header-icon-wrapper me-3 d-none d-sm-flex">
                            <i class="{{ $icon }} fs-1 text-primary"></i>
                        </div>
                    @endif
                    <div>
                        <h1 class="fw-bold mb-1 text-dark tracking-tight">{{ $title }}</h1>
                        @if($subtitle)
                            <p class="text-muted mb-0 fs-6">{{ $subtitle }}</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Action Slot --}}
            @if(isset($action))
                <div class="col-lg-4 mt-4 mt-lg-0 text-lg-end">
                    <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                        {{ $action }}
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    {{-- Bottom Accent Bar --}}
    <div class="position-absolute bottom-0 start-0 w-100 bg-primary opacity-10" style="height: 4px;"></div>
</div>

<style>
    .glass-header {
        background: rgba(255, 255, 255, 0.7) !important;
        backdrop-filter: blur(15px) saturate(180%);
        -webkit-backdrop-filter: blur(15px) saturate(180%);
        border: 1px solid rgba(13, 110, 253, 0.1) !important;
        position: relative;
    }
    
    .header-icon-wrapper {
        width: 60px;
        height: 60px;
        background: rgba(13, 110, 253, 0.08);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .glass-header:hover .header-icon-wrapper {
        transform: rotate(-5deg) scale(1.05);
        background: rgba(13, 110, 253, 0.12);
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        font-size: 1.2rem;
        line-height: 1;
        vertical-align: middle;
        color: #cfd4da;
    }

    .tracking-tight {
        letter-spacing: -0.025em;
    }
</style>
