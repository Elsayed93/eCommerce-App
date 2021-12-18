@extends('admin::layouts.master')

@section('content')
    @php
    $link_array = explode('/', $_SERVER['PHP_SELF']);
    $modelName = end($link_array);
    @endphp


    <section class="content-header">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@lang('admin::site.'.$modelName)</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.welcome') }}">
                                    @lang('admin::site.Dashboard')
                                </a>
                            </li>

                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.categories.index') }}">
                                    @lang('admin::site.categories')
                                </a>
                            </li>

                            <li class="breadcrumb-item">@lang('admin::site.'.$modelName)</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="container">
                <div class="card card-primary">

                    <div class="card-body">
                        <form method="POST" action="{{ route('dashboard.categories.store') }}"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- category english name --}}
                            <div class="form-group">
                                <label for="inputName">@lang('admin::site.en_name')</label>
                                <input type="text" name="en_name" id="inputName" class="form-control"
                                    placeholder="@lang('admin::site.please english enter name')"
                                    value="{{ old('en_name') }}">
                            </div>

                            {{-- category arabic name --}}
                            <div class="form-group">
                                <label for="inputName">@lang('admin::site.ar_name')</label>
                                <input type="text" name="ar_name" id="inputName" class="form-control"
                                    placeholder="@lang('admin::site.please enter arabic name')"
                                    value="{{ old('ar_name')}}">
                            </div>

                            {{-- category english description --}}
                            <div class="form-group">
                                <label for="inputDescription">@lang('admin::site.en_description')</label>
                                <textarea id="inputDescription" name="en_description" class="form-control" rows="4" placeholder="@lang('admin::site.please enter english description')">{{ old('en_description')}}</textarea>
                            </div>

                            {{-- category arabic description --}}
                            <div class="form-group">
                                <label for="inputDescription">@lang('admin::site.ar_description')</label>
                                <textarea id="inputDescription" name="ar_description" class="form-control" rows="4"
                                    placeholder="@lang('admin::site.please enter arabic description')">{{ old('ar_description')}}</textarea>
                            </div>


                            <div class="form-group">
                                <label for="inputImage">@lang('admin::site.image')</label>
                                <input type="file" name="image" id="inputImage" class="form-control">
                            </div>

                            <div class="form-group">
                                <input type="submit" value="{{ __('admin::site.add') }}" class="btn btn-success">
                                <a href="#" class="btn btn-secondary">@lang('admin::site.cancel')</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
    <!-- /.content -->


@endsection
