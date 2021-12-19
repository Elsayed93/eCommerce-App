@extends('admin::layouts.master')

@push('head')
    <style>
        #nocategories {
            text-align: center;
            font-size: 1.5rem;
        }

    </style>
@endpush

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

                            <li class="breadcrumb-item">@lang('admin::site.'.$modelName)</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        {{-- search and create --}}
        <div class="box-header with-border">

            <form action="{{ route('dashboard.' . $modelName . '.index') }}" method="GET" style="margin-top:20px;">
                <div class="row mt-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="search" value="{{ request()->search }}"
                            placeholder="@lang('admin::site.search')">

                    </div>

                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i>
                            @lang('admin::site.search')
                        </button>

                        {{-- Create category --}}
                        <a href="{{ route('dashboard.' . $modelName . '.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i>
                            @lang('admin::site.create')
                        </a>

                    </div>
                </div>
            </form>

        </div>
    </section>





    <!-- Main content -->
    <section class="content">
        {{-- {{dd($categories[0]->image)}} --}}

        <!-- Default box -->
        <div class="card">

            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th style="width: 1%">
                                #
                            </th>
                            <th>@lang('admin::site.name')</th>
                            <th>@lang('admin::site.description')</th>
                            <th>@lang('admin::site.image')</th>
                            <th>@lang('admin::site.action')</th>

                        </tr>
                    </thead>
                    <tbody>

                        @if ($categories->count() > 0)
                            @foreach ($categories as $index => $category)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{!! $category->description !!}</td>
                                    <td>
                                        <img class="img-thumbnail"
                                            src="{{ asset('uploads/categories/' . $category->image) }}"
                                            alt="{{ __('admin::site.category image') }}" width="100">
                                    </td>

                                    <td>
                                        <a href="{{ route('dashboard.' . $modelName . '.edit', $category->id) }}"
                                            class="btn btn-warning btn-sm" title="@lang('admin::site.edit')">
                                            @lang('admin::site.edit')
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <form action="{{ route('dashboard.' . $modelName . '.destroy', $category->id) }}"
                                            method="post" id="deleteForm" style="display: inline-block;">
                                            @method('DELETE')
                                            @csrf

                                            <button type="submit" class="btn btn-danger btn-sm delete"
                                                title="@lang('admin::site.delete')">
                                                @lang('admin::site.delete')
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <td colspan="4" id="nocategories">@lang('admin::site.There is no '.$modelName.'.')</td>
                        @endif

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
