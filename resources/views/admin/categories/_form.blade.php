@csrf

<div class="mb-3">
    <label class="form-label" for="nameInput">{{ trans('messages.fields.name') }}</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name" value="{{ old('name', $category->name ?? '') }}" required>

    @error('name')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="descriptionInput">{{ trans('messages.fields.description') }}</label>
    <input type="text" class="form-control @error('description') is-invalid @enderror" id="descriptionInput" name="description" value="{{ old('description', $category->description ?? '') }}" required>

    @error('description')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<h3>{{ trans('support::admin.fields.title') }}</h3>

<p>{{ trans('support::admin.fields.info') }}</p>

<div v-scope="{ fields: supportFields }">
    <div class="card" v-for="(field, i) in fields">
        <div class="card-body">
            <div class="row gx-3">
                <div class="mb-3 col-md-6">
                    <label class="form-label" :for="'nameInput' + i">
                        {{ trans('messages.fields.name') }}
                    </label>

                    <input v-model.trim="field.name" type="text" class="form-control" :name="`fields[${i}][name]`" :id="'nameInput' + i" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label" for="'typeSelect' + i">{{ trans('messages.fields.type') }}</label>

                    <select v-model="field.type" class="form-select" :name="`fields[${i}][type]`" :id="'typeSelect' + i" required>
                        @foreach($fieldTypes as $type)
                            <option value="{{ $type }}">
                                {{ trans('support::admin.fields.'.$type) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" :for="'descriptionInput' + i">
                    {{ trans('messages.fields.description') }}
                </label>

                <input v-model.trim="field.description" type="text" class="form-control" :name="`fields[${i}][description]`" :id="'descriptionInput' + i" required>
            </div>

            <div class="mb-3" v-if="field.type === 'dropdown'">
                <label class="form-label" for="'optionsInputs' + i">
                    {{ trans('support::admin.fields.options') }}
                </label>

                <div class="row gx-3 gy-1">
                    <div v-for="(option, j) in field.options" class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" v-model.trim="field.options[j]" :name="`fields[${i}][options][]`" required>

                            <button type="button" v-if="field.options.length > 1" class="btn btn-danger" @click="field.options.splice(j, 1)" title="{{ trans('messages.actions.delete') }}">
                                <i class="bi bi-x-lg"></i>
                            </button>

                            <button type="button" class="btn btn-success" @click="field.options.splice(j + 1, 0, '')" title="{{ trans('messages.actions.add') }}">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-check form-switch mb-3">
                <input type="checkbox" class="form-check-input" :name="`fields[${i}][is_required]`" :id="'requiredSwitch' + i" v-model="field.is_required">
                <label class="form-check-label" for="'requiredSwitch' + i">{{ trans('support::admin.fields.required') }}</label>
            </div>

            <input v-if="field.id" type="hidden" :value="field.id" :name="`fields[${i}][id]`">

            <button type="button" class="btn btn-danger btn-sm" @click="fields.splice(i, 1)">
                <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
            </button>
        </div>
    </div>

    <button type="button" @click="fields.push({ name: '', description: '', type: 'text', options: [''] })" class="btn btn-sm btn-success mb-3">
        <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
    </button>
</div>

@push('scripts')
    <script>
        const supportFields = @json(old('fields', $category->fields ?? []));

        supportFields.forEach(field => {
            if (!field.options) {
                field.options = [''];
            }
        });
    </script>
@endpush
