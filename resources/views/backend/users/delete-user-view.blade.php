@extends('layouts.vertical', ['page_title' => 'Delete User View', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box py-3 d-flex justify-content-start align-content-center  gap-2">
                    <div class="align-self-center">
                        <h4 class="page-title" style="line-height: unset;">Delete Users</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">You have specified this user for deletion:</h4>

                        <p>ID #{{ $user->id }}</p>
                        <p>username: {{ $user->username }}</p>
                        <p>email: {{ $user->email }}</p>

                        {{-- @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show"
                                role="alert">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                                <strong>Error - </strong> {{ $errors->first() }}
                            </div>
                        @endif --}}

                        <form action="{{ route('backend.user.delete', $user->id) }}" method="POST" class="mt-3">
                            @csrf
                            <h5>What should be done with content owned by this user?</h5>
                            <div class="mt-3">
                                <div class="form-check">
                                    <input type="radio" id="customRadio1" value="delete_all_content" name="delete_option"
                                        class="form-check-input">
                                    <label class="form-check-label" for="customRadio1">Delete all content.</label>
                                </div>
                                <br>
                                <div class="form-check">
                                    <input type="radio" value="attribute_all_content" id="customRadio2"
                                        name="delete_option" class="form-check-input">
                                    <label class="form-check-label" for="customRadio2">Attribute all content to: </label>
                                </div>
                            </div>
                            <div class="mt-2" id="reassignContent" style="display: none;">
                                <select class="form-select mb-3" style="width: max-content;" name="reassign_user"
                                    id="reassign_user">
                                    @foreach ($allUsers as $user)
                                        <option value="{{ $user->id }}">{{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button id="submitButton" disabled type="submit" class="mt-2 btn btn-outline-primary">Confirm
                                Delete</button>
                        </form>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
    </div>
@endsection

@push('backend-js')
    <script>
        // Get the radio buttons and the submit button
        const deleteRadio = document.getElementById('customRadio1');
        const attributeRadio = document.getElementById('customRadio2');
        const reassignContent = document.getElementById('reassignContent');
        const submitButton = document.getElementById('submitButton');

        // Function to enable the submit button
        function enableSubmitButton() {
            submitButton.disabled = false; // Enable the submit button
        }

        // Function to disable the submit button
        function disableSubmitButton() {
            submitButton.disabled = true; // Disable the submit button
        }

        // Add event listener for when the radio buttons are changed
        attributeRadio.addEventListener('change', () => {
            if (attributeRadio.checked) {
                reassignContent.style.display = 'block'; // Show the select box
                enableSubmitButton(); // Enable the submit button
            }
        });

        deleteRadio.addEventListener('change', () => {
            if (deleteRadio.checked) {
                reassignContent.style.display = 'none'; // Hide the select box
                enableSubmitButton(); // Enable the submit button
            }
        });

        // Disable the button initially
        disableSubmitButton();

        document.getElementById('submitButton').addEventListener('click', function(e) {
            // Ask for confirmation before submitting
            if (!confirm('Are you sure you want to delete this user and their content?')) {
                e.preventDefault(); // Prevent the form from submitting if the user cancels
            }
        });
    </script>
@endpush
