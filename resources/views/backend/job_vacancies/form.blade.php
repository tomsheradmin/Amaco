<div class="form-group">
    <label>{{ __('Job Title') }}</label>
    <input
        type="text"
        name="title"
        class="form-control"
        value="{{ old('title', $vacancy->title) }}"
        required
    >
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label>{{ __('Company / Subsidiary') }}</label>
        <input
            type="text"
            name="company_name"
            class="form-control"
            value="{{ old('company_name', $vacancy->company_name) }}"
        >
    </div>

    <div class="form-group col-md-6">
        <label>{{ __('Location') }}</label>
        <input
            type="text"
            name="location"
            class="form-control"
            value="{{ old('location', $vacancy->location) }}"
        >
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label>{{ __('Employment Type') }}</label>
        <select name="employment_type" class="form-control" required>
            @foreach ([
                'full_time' => 'Full Time',
                'part_time' => 'Part Time',
                'contract' => 'Contract',
                'temporary' => 'Temporary',
                'internship' => 'Internship',
            ] as $value => $label)
                <option
                    value="{{ $value }}"
                    @selected(old('employment_type', $vacancy->employment_type ?: 'full_time') === $value)
                >
                    {{ __($label) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-6">
        <label>{{ __('Workplace Type') }}</label>
        <select name="workplace_type" class="form-control" required>
            @foreach ([
                'onsite' => 'On-site',
                'remote' => 'Remote',
                'hybrid' => 'Hybrid',
            ] as $value => $label)
                <option
                    value="{{ $value }}"
                    @selected(old('workplace_type', $vacancy->workplace_type ?: 'onsite') === $value)
                >
                    {{ __($label) }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label>{{ __('Job Description') }}</label>
    <textarea
        name="description"
        class="aiz-text-editor"
        rows="6"
        required
    >{{ old('description', $vacancy->description) }}</textarea>
</div>

<div class="form-group">
    <label>{{ __('Responsibilities') }}</label>
    <textarea
        name="responsibilities"
        class="aiz-text-editor"
        rows="5"
    >{{ old('responsibilities', $vacancy->responsibilities) }}</textarea>
</div>

<div class="form-group">
    <label>{{ __('Requirements') }}</label>
    <textarea
        name="requirements"
        class="aiz-text-editor"
        rows="5"
    >{{ old('requirements', $vacancy->requirements) }}</textarea>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label>{{ __('Salary Range') }}</label>
        <input
            type="text"
            name="salary_range"
            class="form-control"
            value="{{ old('salary_range', $vacancy->salary_range) }}"
            placeholder="{{ __('Optional') }}"
        >
    </div>

    <div class="form-group col-md-6">
        <label>{{ __('Application Deadline') }}</label>
        <input
            type="date"
            name="application_deadline"
            class="form-control"
            value="{{ old('application_deadline', $vacancy->application_deadline?->format('Y-m-d')) }}"
        >
    </div>
</div>

<div class="form-group">
    <label>{{ __('Status') }}</label>
    <select name="status" class="form-control" required>
        @foreach (['draft' => 'Draft', 'published' => 'Published', 'closed' => 'Closed'] as $value => $label)
            <option
                value="{{ $value }}"
                @selected(old('status', $vacancy->status ?: 'draft') === $value)
            >
                {{ __($label) }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>
        <input
            type="checkbox"
            name="is_featured"
            value="1"
            @checked(old('is_featured', $vacancy->is_featured))
        >
        {{ __('Feature this vacancy') }}
    </label>
</div>
