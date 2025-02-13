@extends('admin.layouts.app')

{{-- Custom CSS --}}
@section('custom-css')
<style>
.note-btn {
    border-radius: 8px !important;
    font-size: 12px !important;
    padding: 5px 10px !important;
}
</style>
<!-- include libraries(jQuery, bootstrap) -->
<link rel="stylesheet" href="{{ asset('css/editor.css') }}">
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<!-- include summernote css/js -->
<link href="{{ asset('css/summernote.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/summernote.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>

{{-- Title based slug --}}
<script>
function convertToSlug(Text) {
    var slug = Text.toLowerCase()
            .replace(/ /g, '-')
            .replace(/[^\w-]+/g, '');
    $('#slug').val(slug);
}
</script>
@endsection

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
                    <h2 class="page-title">
                        {{ __('Add Page') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            
            {{-- Error --}}
            <div class="alert alert-important alert-danger alert-dismissible d-none" role="alert" id="fillError">
                <div class="d-flex">
                    <div>
                        {{ __('Fill the all the required fields') }}
                    </div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>

            {{-- Failed --}}
            @if (Session::has("failed"))
            <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        {{Session::get('failed')}}
                    </div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            @endif

            {{-- Success --}}
            @if(Session::has("success"))
            <div class="alert alert-important alert-success alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        {{Session::get('success')}}
                    </div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            @endif

            <div class="row row-deck row-cards">
                {{-- Save page --}}
                <div class="col-sm-12 col-lg-12">
                    <form action="{{ route('admin.save.page') }}" method="post" enctype="multipart/form-data"
                        class="card" id="customPageForm">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="row">

                                        {{-- Name --}}
                                        <input type="hidden" class="form-control" name="name"
                                                    value="Custom Page" placeholder="{{ __('Name') }}..."
                                                    required />

                                        {{-- Title --}}
                                        <div class="col-md-4 col-xl-6">
                                            <div class="mb-3">
                                                <div class="form-label required">{{ __('Title') }}</div>
                                                <input type="text" class="form-control" name="title" onkeyup="convertToSlug(this.value)"
                                                    value="{{ old('title') }}" placeholder="{{ __('Title') }}..."
                                                    required />
                                            </div>
                                        </div>

                                        {{-- Slug --}}
                                        <div class="col-md-4 col-xl-6">
                                            <div class="mb-3">
                                                <div class="form-label required">{{ __('Slug') }}</div>
                                                <input type="text" class="form-control" name="slug" id="slug"
                                                    value="{{ old('slug') }}" placeholder="{{ __('Slug') }}..."
                                                    required />
                                            </div>
                                        </div>

                                        {{-- Body --}}
                                        <div class="col-md-12 col-xl-12">
                                            <div class="mb-3">
                                                <div class="form-label required">{{ __('Body') }}</div>
                                                <textarea name="body" id="body" cols="30" rows="5" class="form-control"
                                                    placeholder="{{ __('Body') }}">{{ old('body') }}</textarea>
                                            </div>
                                        </div>

                                        {{-- Check SEO --}}
                                        <h2 class="mt-5 mb-3 page-title">
                                            {{ __('SEO Configuration') }}
                                        </h2>

                                        {{-- Title --}}
                                        <div class="col-md-6 col-xl-6">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Title')
                                                    }}</label>
                                                <textarea class="form-control" name="meta_title" rows="3" placeholder="{{ __('Title') }}"
                                                    required>{{ old('meta_title') }}</textarea>
                                            </div>
                                        </div>

                                        {{-- Meta Description --}}
                                        <div class="col-md-6 col-xl-6">
                                            <div class="mb-3">
                                                <div class="form-label required">{{ __('Meta Description') }}</div>
                                                <textarea name="meta_description" id="meta_description"
                                                    rows="3" class="form-control"
                                                    placeholder="{{ __('Meta Description') }}"
                                                    required>{{ old('meta_description') }}</textarea>
                                            </div>
                                        </div>

                                        {{-- Meta Keywords --}}
                                        <div class="col-md-12 col-xl-12">
                                            <div class="mb-3">
                                                <div class="form-label required">{{ __('Meta Keywords') }}</div>
                                                <input type="text" class="form-control" name="meta_keywords"
                                                    value="{{ old('meta_keywords') }}"
                                                    placeholder="{{ __('Meta Keywords') }}..." required />
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <div class="d-flex">
                                                <button type="submit" class="btn btn-primary btn-md ms-auto">
                                                    {{ __('Save') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    @include('admin.includes.footer')
</div>

{{-- Custom JS --}}
@section('custom-js')
<script>
$(document).ready(function() {
  "use strict";
  $('#body').summernote({
    height: 300,
      dialogsInBody: true,
      dialogsFade: false,
      codeviewFilter: true,
      codeviewIframeFilter: true,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['height', ['height']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['picture', 'video']],
        ['view', ['codeview']],
      ],
});

$('.codeview').on('click', function() {
  "use strict";
  if ($('#body').summernote('codeview.isActivated')) {
    $('#body').summernote('codeview.deactivate');
    prevent();
  }
});
});

$('#customPageForm').on('submit', function(e) {
  "use strict";
  if($('#body').summernote('isEmpty')) {
    $('#fillError').attr("class", "alert alert-important alert-danger alert-dismissible");
    e.preventDefault();
  }
})
</script>
@endsection
@endsection