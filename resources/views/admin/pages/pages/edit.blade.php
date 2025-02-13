@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        {{ __('Overview') }}
                    </div>
                    <h2 class="mb-3 page-title">
                        {{ __('Edit Page') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-sm-12 col-lg-12">
                    <form action="{{ route('admin.update.page', Request::segment(3)) }}" method="post"
                        enctype="multipart/form-data" class="card">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                @for ($i = 0; $i < count($sections); $i++) <div class="col-xl-4">
                                    <div id="section{{ $i }}" class="row">
                                        <div class="col-md-12 col-xl-12">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __($sections[$i]->title) }}</label>
                                                <textarea rows="6" cols="10" class="form-control" name="section{{ $i }}"
                                                    placeholder="{{ __($sections[$i]->title) }}" required>{{ $sections[$i]->body }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            @endfor

                            {{-- Check SEO --}}
                            @if (Request::segment(3) != 'footer' && Request::segment(3) != 'footer support email')
                            <h2 class="mt-5 mb-3 page-title">
                                {{ __('SEO Configuration') }}
                            </h2>

                            {{-- Title --}}
                            <div class="col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Title')
                                        }}</label>
                                    <textarea class="form-control" name="meta_title" rows="3" placeholder="{{ __('Title') }}"
                                        required>{{ $sections[0]->meta_title }}</textarea>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Description')
                                        }}</label>
                                    <textarea class="form-control" name="meta_description" rows="3"
                                        placeholder="{{ __('Description') }}"
                                        required>{{ $sections[0]->meta_description }}</textarea>
                                </div>
                            </div>

                            {{-- Keywords --}}
                            <div class="col-md-12 col-xl-12">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Keywords') }}</label>
                                    <textarea class="form-control required" name="meta_keywords" rows="3"
                                        placeholder="{{ __('Keywords (Keyword 1, Keyword 2)') }}"
                                        required>{{ $sections[0]->meta_keywords }}</textarea>
                                </div>
                            </div>
                            @endif

                            <div class="text-end">
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary btn-md ms-auto">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('admin.includes.footer')
</div>
@endsection