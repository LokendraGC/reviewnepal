@extends('layouts.vertical', ['page_title' => 'All Pages', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('content')
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="fs-5">All Pages</h4>
                            <div>
                                <a href="{{ route('backend.page.create') }}" class="btn btn-sm btn-dark">
                                    <i class="ri-add-circle-line fs-5"></i>
                                    Add New Page
                                </a>
                            </div>
                        </div>
                        <hr class="my-2">
                        <livewire:data-table.page-data-table :status="$status" :postType="$postType" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
