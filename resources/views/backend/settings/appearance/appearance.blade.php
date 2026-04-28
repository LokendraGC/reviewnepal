@extends('layouts.vertical', ['page_title' => 'Appearance Settings', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('content')
    <style>
        .code-box {
            font-family: "Courier New", Courier, monospace;
            background-color: #f4f4f4;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 8px;
            white-space: pre-wrap;
            tab-size: 4;
            color: #333;
            width: 100%;
            resize: both;
        }

        .code-box:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    </style>
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Appearance Settings</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <form action="{{ route('backend.appearance.setting.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-2 row">
                                <label for="site_title" class="col-sm-3 col-form-label col-form-label-sm">Additional
                                    CSS</label>
                                <div class="col-sm-5">
                                    <textarea name="additional_CSS" class="form-control code-box" id="example-textarea" cols="30" rows="10">{{ $settings['additional_CSS'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <button type="submit" class="mt-2 btn btn-primary btn-sm">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
