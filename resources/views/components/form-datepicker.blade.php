@props(['name', 'label', 'value' => null, 'required' => false])

<div class="mb-3">
    <label class="form-label small fw-semibold">{{ $label }}</label>
    <div class="input-group">
        <span class="input-group-text bg-light"><i class="bi bi-calendar-date"></i></span>
        <input type="text" 
               name="{{ $name }}" 
               value="{{ $value }}" 
               class="form-control datepicker-{{ $name }}" 
               {{ $required ? 'required' : '' }}
               placeholder="DOB">
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".datepicker-{{ $name }}", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            maxDate: "today",
            disableMobile: "true",
            theme: "material_blue"
        });
    });
</script>
