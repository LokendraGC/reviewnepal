@extends('layouts.vertical', ['page_title' => 'Add New Role', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box py-3 d-flex justify-content-start align-content-center  gap-2">
                    <div class="align-self-center">
                        <h4 class="page-title" style="line-height: unset;">Add/Edit Permission to Role</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Role: {{ $role->name }}</h4>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="{{ route('givePermissionToRole', $role->id) }}" method="POST">
                                    @csrf
                                    @error('permission')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="mt-3 mb-3">
                                        <div
                                            class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                                            {{-- <h5 class="mb-0">Permissions</h5> --}}
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    id="selectAllBtn">
                                                    <i class="ri-checkbox-line me-1"></i>Select All
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    id="unselectAllBtn">
                                                    <i class="ri-checkbox-blank-line me-1"></i>Unselect All
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        @php
                                            // Group permissions by resource type
                                            $groupedPermissions = [];
                                            foreach ($permissions as $permission) {
                                                $parts = explode('_', $permission->name);
                                                if (count($parts) >= 2) {
                                                    $action = $parts[0];
                                                    $resource = implode('_', array_slice($parts, 1));
                                                    if (!isset($groupedPermissions[$resource])) {
                                                        $groupedPermissions[$resource] = [];
                                                    }
                                                    $groupedPermissions[$resource][] = [
                                                        'permission' => $permission,
                                                        'action' => $action,
                                                    ];
                                                } else {
                                                    if (!isset($groupedPermissions['other'])) {
                                                        $groupedPermissions['other'] = [];
                                                    }
                                                    $groupedPermissions['other'][] = [
                                                        'permission' => $permission,
                                                        'action' => 'other',
                                                    ];
                                                }
                                            }
                                            ksort($groupedPermissions);
                                        @endphp

                                        @foreach ($groupedPermissions as $resource => $perms)
                                            <div class="permission-group mb-4" data-resource="{{ $resource }}">
                                                <div
                                                    class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3 pb-2 border-bottom gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mb-0 fw-semibold text-capitalize">
                                                            <i class="ri-folder-2-line me-2 text-primary"></i>
                                                            {{ str_replace('_', ' ', $resource) }}
                                                        </h6>
                                                        <span
                                                            class="badge bg-light text-dark ms-2">{{ count($perms) }}</span>
                                                    </div>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <button type="button"
                                                            class="btn btn-outline-primary select-group-btn"
                                                            data-resource="{{ $resource }}">
                                                            <i class="ri-checkbox-line me-1"></i>Select All
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-outline-secondary unselect-group-btn"
                                                            data-resource="{{ $resource }}">
                                                            <i class="ri-checkbox-blank-line me-1"></i>Unselect All
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    @foreach ($perms as $perm)
                                                        @php
                                                            $permission = $perm['permission'];
                                                            $isChecked = in_array($permission->id, $rolePermissions);
                                                            $actionColors = [
                                                                'create' => 'primary',
                                                                'read' => 'primary',
                                                                'update' => 'primary',
                                                                'delete' => 'primary',
                                                                'updated' => 'primary',
                                                            ];
                                                            $actionColor =
                                                                $actionColors[$perm['action']] ?? 'secondary';
                                                            $actionIcons = [
                                                                'create' => 'ri-add-circle-line',
                                                                'read' => 'ri-eye-line',
                                                                'update' => 'ri-edit-line',
                                                                'updated' => 'ri-edit-line',
                                                                'delete' => 'ri-delete-bin-line',
                                                            ];
                                                            $actionIcon =
                                                                $actionIcons[$perm['action']] ?? 'ri-checkbox-line';
                                                        @endphp
                                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                                            <div
                                                                class="permission-item-card {{ $isChecked ? 'active' : '' }}">
                                                                <div class="form-check mb-0">
                                                                    <input type="checkbox"
                                                                        class="form-check-input permission-checkbox"
                                                                        id="permission_{{ $permission->id }}"
                                                                        name="permission[]" value="{{ $permission->name }}"
                                                                        {{ $isChecked ? 'checked' : '' }}>
                                                                    <label class="form-check-label w-100 permission-label"
                                                                        for="permission_{{ $permission->id }}">
                                                                        <div class="d-flex align-items-center">
                                                                            {{-- <div class="permission-icon-wrapper bg-{{ $actionColor }} bg-opacity-10">
                                                                                <i class="{{ $actionIcon }} text-{{ $actionColor }}"></i>
                                                                            </div> --}}
                                                                            <div class="flex-grow-1 ms-2">
                                                                                <span
                                                                                    class="permission-action-text text-{{ $actionColor }} fw-semibold text-capitalize d-block">
                                                                                    {{ $perm['action'] }}
                                                                                </span>
                                                                                <span
                                                                                    class="permission-resource-text text-muted small text-capitalize d-block">
                                                                                    {{ str_replace('_', ' ', $resource) }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div> <!-- end col -->

                        </div>
                        <!-- end row-->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div><!-- end col -->
        </div>
    </div>

    <style>
        .permission-group {
            padding: 1.25rem;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            border: 1px solid #e9ecef;
            margin-bottom: 1.5rem;
        }

        .permission-item-card {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 0.5rem;
            padding: 0.875rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .permission-item-card:hover {
            border-color: var(--bs-primary);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .permission-item-card.active {
            border-color: var(--bs-primary);
            background-color: rgba(var(--bs-primary-rgb), 0.05);
        }

        .permission-item-card .form-check-input {
            cursor: pointer;
            width: 1.25rem;
            height: 1.25rem;
            margin-top: 0.25rem;
        }

        .permission-item-card .form-check-label {
            cursor: pointer;
            margin: 0;
            pointer-events: none;
        }

        .permission-item-card .form-check-input {
            pointer-events: auto;
        }

        .permission-icon-wrapper {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            flex-shrink: 0;
        }

        .permission-action-text {
            font-size: 0.875rem;
            line-height: 1.2;
        }

        .permission-resource-text {
            font-size: 0.75rem;
            line-height: 1.2;
        }

        @media (max-width: 767.98px) {
            .permission-group {
                padding: 1rem;
            }

            .btn-group {
                width: 100%;
            }

            .btn-group .btn {
                flex: 1;
            }

            .permission-group .btn-group {
                width: 100%;
                margin-top: 0.5rem;
            }

            .permission-group .btn-group .btn {
                flex: 1;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');

            // Update card active state on checkbox change
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const card = this.closest('.permission-item-card');
                    if (card) {
                        if (this.checked) {
                            card.classList.add('active');
                        } else {
                            card.classList.remove('active');
                        }
                    }
                });
            });

            // Initialize active states
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const card = checkbox.closest('.permission-item-card');
                    if (card) {
                        card.classList.add('active');
                    }
                }
            });

            // Function to update card active state
            function updateCardState(checkbox) {
                const card = checkbox.closest('.permission-item-card');
                if (card) {
                    if (checkbox.checked) {
                        card.classList.add('active');
                    } else {
                        card.classList.remove('active');
                    }
                }
            }

            // Card click to toggle checkbox
            document.querySelectorAll('.permission-item-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    const checkbox = this.querySelector('.permission-checkbox');
                    if (!checkbox) return;

                    // If clicking directly on checkbox, let it handle naturally and update state
                    if (e.target === checkbox || e.target.type === 'checkbox') {
                        setTimeout(() => updateCardState(checkbox), 10);
                        return;
                    }

                    // If clicking on label, prevent default and toggle manually
                    if (e.target.tagName === 'LABEL' || e.target.closest('.permission-label')) {
                        e.preventDefault();
                        e.stopPropagation();
                        checkbox.checked = !checkbox.checked;
                        updateCardState(checkbox);
                        return;
                    }

                    // Otherwise, toggle the checkbox when clicking anywhere on card
                    e.preventDefault();
                    e.stopPropagation();
                    checkbox.checked = !checkbox.checked;
                    updateCardState(checkbox);
                });
            });

            // Select All button functionality
            document.getElementById('selectAllBtn').addEventListener('click', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = true;
                    updateCardState(checkbox);
                });
            });

            // Unselect All button functionality
            document.getElementById('unselectAllBtn').addEventListener('click', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                    updateCardState(checkbox);
                });
            });

            // Select All for specific group
            document.querySelectorAll('.select-group-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const resource = this.getAttribute('data-resource');
                    const group = document.querySelector(
                        `.permission-group[data-resource="${resource}"]`);
                    if (group) {
                        const groupCheckboxes = group.querySelectorAll('.permission-checkbox');
                        groupCheckboxes.forEach(checkbox => {
                            checkbox.checked = true;
                            updateCardState(checkbox);
                        });
                    }
                });
            });

            // Unselect All for specific group
            document.querySelectorAll('.unselect-group-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const resource = this.getAttribute('data-resource');
                    const group = document.querySelector(
                        `.permission-group[data-resource="${resource}"]`);
                    if (group) {
                        const groupCheckboxes = group.querySelectorAll('.permission-checkbox');
                        groupCheckboxes.forEach(checkbox => {
                            checkbox.checked = false;
                            updateCardState(checkbox);
                        });
                    }
                });
            });

        });
    </script>
@endsection
