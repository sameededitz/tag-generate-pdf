@section('title', 'Expiry Tag Generator')
<div>
    <div class="card">
        <div class="card-header">
            Generate Expiry Tags
        </div>
        <div class="card-body">
            <form wire:submit.prevent="generatePDF">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Product Title</label>
                        <input type="text" class="form-control" wire:model.defer="title">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Bakery Address</label>
                        <input type="text" class="form-control" wire:model.defer="address">
                        @error('address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">MFG Date</label>
                        <input type="text" id="mfg_date" class="form-control" wire:model.live="mfg_date">
                        @error('mfg_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label d-flex justify-content-between align-items-center">
                            <span>EXP Date</span>
                            <small class="text-muted">(from MFG Date)</small>
                        </label>

                        <div class="input-group mb-2">
                            <input type="text" id="exp_date" class="form-control" wire:model.live="exp_date">
                            <div class="input-group-text p-0">
                                <button type="button" wire:click="setExpiry(7)"
                                    class="btn btn-sm btn-outline-secondary">+7d</button>
                                <button type="button" wire:click="setExpiry(20)"
                                    class="btn btn-sm btn-outline-secondary">+20d</button>
                                <button type="button" wire:click="setExpiry(30)"
                                    class="btn btn-sm btn-outline-secondary">+1M</button>
                            </div>
                        </div>

                        <div class="input-group">
                            <input type="number" class="form-control" placeholder="Enter days"
                                wire:model.defer="custom_days">
                            <button type="button" class="btn btn-outline-primary" wire:click="setCustomExpiry">
                                Set Expiry (+days)
                            </button>
                        </div>

                        @error('exp_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Download PDF</button>
            </form>

        </div>
    </div>
</div>
@script
    <script>
        flatpickr("#mfg_date", {
            dateFormat: "m-d-y",
            onChange: function(selectedDates, dateStr, instance) {
                @this.set('mfg_date', dateStr);
            }
        });

        flatpickr("#exp_date", {
            dateFormat: "m-d-y",
            onChange: function(selectedDates, dateStr, instance) {
                @this.set('exp_date', dateStr);
            }
        });
    </script>
@endscript
