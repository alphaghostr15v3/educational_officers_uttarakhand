@extends('layouts.school')

@section('page_title', 'Infrastructure Details')

@section('school_content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">School Infrastructure</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('school.infrastructure.update') }}" method="POST">
                    @csrf
                    
                    <h6 class="text-primary fw-bold mb-3">Basic Facilities</h6>
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Total Classrooms</label>
                            <input type="number" name="classrooms" class="form-control" value="{{ $infra->classrooms }}" min="0" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Boys Toilets</label>
                            <input type="number" name="toilets_boys" class="form-control" value="{{ $infra->toilets_boys }}" min="0" required>
                        </div>
                        <div class="col-md-4 mb-3">
                             <label class="form-label">Girls Toilets</label>
                            <input type="number" name="toilets_girls" class="form-control" value="{{ $infra->toilets_girls }}" min="0" required>
                        </div>
                         <div class="col-md-4 mb-3">
                             <label class="form-label">Computers</label>
                            <input type="number" name="computers" class="form-control" value="{{ $infra->computers }}" min="0" required>
                        </div>
                    </div>

                    <h6 class="text-primary fw-bold mb-3">Amenities Availability</h6>
                    <div class="row mb-4">
                        <div class="col-md-4 mb-2">
                             <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="drinking_water" id="drinking_water" {{ $infra->drinking_water ? 'checked' : '' }}>
                                <label class="form-check-label" for="drinking_water">Drinking Water</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                             <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="electricity" id="electricity" {{ $infra->electricity ? 'checked' : '' }}>
                                <label class="form-check-label" for="electricity">Electricity Connection</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                             <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="library" id="library" {{ $infra->library ? 'checked' : '' }}>
                                <label class="form-check-label" for="library">Library / Reading Room</label>
                            </div>
                        </div>
                         <div class="col-md-4 mb-2">
                             <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="playground" id="playground" {{ $infra->playground ? 'checked' : '' }}>
                                <label class="form-check-label" for="playground">Playground</label>
                            </div>
                        </div>
                         <div class="col-md-4 mb-2">
                             <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="smart_class" id="smart_class" {{ $infra->smart_class ? 'checked' : '' }}>
                                <label class="form-check-label" for="smart_class">Smart Class</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">Update Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
