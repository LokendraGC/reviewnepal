@extends('layouts.vertical', ['page_title' => 'Add New Menu', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Add New Menu</h4>
                    <form action="{{ route('backend.menu.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label" for="title">Title <span
                                                    class="text-danger">*</span></label>
                                            <input name="name" type="text" id="title" placeholder="Add title"
                                                class="form-control" value="{{ old('name') }}" />
                                            @error('name')
                                                <div class="valid-feedback d-block ">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="type" value="{{ $type }}" />
                            <div class="col-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="publish_status">
                                            <div class="text-start">
                                                <p class="">
                                                    <input class="btn btn-primary" type="submit" value="Submit" />
                                                </p>
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
@endsection
