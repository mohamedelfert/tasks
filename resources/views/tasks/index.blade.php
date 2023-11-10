@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@push('css')
@endpush
@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <div>
                    <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{ $title }}</h2>
                </div>
            </div>
            <div class="main-dashboard-header-right">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item">
                        <a href="#" class="default-color">@lang('main.dashboard')</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>

        <div class="row row-sm">

        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="col-xl-12">
                    <div class="card">

                        <div class="card-header pb-0">
                            <div class="box-header with-border">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <span style="display: block;margin-bottom:10px">@lang('main.task_list') : <small>( {{ $tasks->total() }} )</small></span>
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="modal-effect btn btn-sm btn-primary" data-effect="effect-scale"
                                           data-toggle="modal" href="#add" title="@lang('main.create')">
                                            <i class="las la-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr style="margin:10px 30px">

                        <div class="card-body">

                            @if($tasks->count() > 0)
                                <div class="row">
                                    @foreach($tasks as $task)
                                        <div class="col-md-4 mt-2">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{$task->title}}</h5>
                                                    <p class="card text-center">{{$task->date}}</p>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="{{ route('tasks.show',$task->id) }}"
                                                       class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                                    <a class="modal-effect btn btn-sm btn-danger"
                                                       data-effect="effect-scale" data-toggle="modal"
                                                       href="#delete{{$task->id}}" title="@lang('main.delete')">
                                                        <i class="las la-trash"></i></a>
                                                    @if($task->finished == 0)
                                                        <a href="{{ route('finish',$task->id) }}">
                                                            <span
                                                                class="badge badge-pill badge-warning">Click To Finish</span>
                                                        </a>
                                                    @elseif($task->finished == 1)
                                                        <span class="badge badge-pill badge-success">Finished</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- delete -->
                                        <div class="modal" id="delete{{$task->id}}">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content modal-content-demo">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">@lang('main.delete')</h6>
                                                        <button aria-label="Close" class="close" data-dismiss="modal"
                                                                type="button"><span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('tasks.destroy', $task->id) }}"
                                                          method="post">
                                                        {{ method_field('delete') }}
                                                        {{ csrf_field() }}
                                                        <div class="modal-body">
                                                            <p>@lang('main.delete_msg')</p><br>
                                                            <input type="hidden" name="id" id="id"
                                                                   value="{{$task->id}}">
                                                            <input class="form-control" name="title" id="title"
                                                                   value="{{$task->title}}" type="text" readonly>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">@lang('main.cancel')
                                                            </button>
                                                            <button type="submit"
                                                                    class="btn btn-danger">@lang('main.confirm')</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-12 mt-2">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h5 class="card-title text-center text-danger">No Data Found</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endif

                        <!-- add -->
                            <div class="modal" id="add">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content modal-content-demo">
                                        <div class="modal-header">
                                            <h6 class="modal-title">@lang('main.add')</h6>
                                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('tasks.store') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="title" class="form-label">@lang('main.title')</label>
                                                    <input type="text" name="title" id="title" class="form-control"
                                                           placeholder="Enter a Title" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="date" class="form-label">@lang('main.date')</label>
                                                    <input type="date" name="date" id="date" class="form-control"
                                                           required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description"
                                                           class="form-label">@lang('main.description')</label>
                                                    <textarea rows="5" name="description" id="description" type="text"
                                                              class="form-control" placeholder="Add a Description"
                                                              required></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" name="category_id" required>
                                                        <option value="">Select Category</option>

                                                        @foreach ($categories as $category)
                                                            <option
                                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">@lang('main.cancel')
                                                </button>
                                                <button type="submit"
                                                        class="btn btn-danger">@lang('main.confirm')</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <!--/div-->
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="pb-2">Search By Category</h3>
                    </div>

                    <div class="card-body">
                        <form class="form-horizontal" method="post" action="{{ route('tasks.index') }}">
                            @csrf

                            <div class="form-group">
                                <select class="form-control" name="category" required>
                                    <option value="">Select Category</option>

                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" name="search" class="btn btn-primary"><i class="fa fa-search"
                                                                                               aria-hidden="true"></i>
                                </button>
                                <a href="{{ route('tasks.index') }}" class="btn btn-danger"><i
                                        class="fa fa-solid fa-broom"></i></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <ul class="d-flex justify-content-center">
            {{ $tasks->appends(request()->input())->links() }}
        </ul>


    </div>

@endsection
@push('js')
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('dashboard/js/modal.js') }}"></script>
@endpush
