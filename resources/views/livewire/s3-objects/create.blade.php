<div>
    <div class="row">
        <div class="col-xlg-12 col-md-12 col-12 mb-30">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    
            <form wire:submit.prevent="save">
                <div class="row mbn-20">
    
                    <div class="col-12 mb-20">
                        <div class="row mbn-10">
                            <div class="col-sm-3 col-12 mb-10"><label for="is_active">  Sermon Date</label>
                            </div>
                            <div class="col-sm-9 col-12 mb-10">
                                <input type="date" wire:model="sermon_date" class="form-control" />
                            </div>
                        </div>
                    </div>
    
                    <div class="col-12 mb-20">
                        <div class="row mbn-10">
                            <div class="col-sm-3 col-12 mb-10"><label for="sku">Sermon</label>
                            </div>
                            <div class="col-sm-9 col-12 mb-10">
                                <input class='form-control' id="sermon" placeholder='sermon' type="file" wire:model="sermon">
                                <small>@error('sermon') <span class="text-danger">{{ $message }}</span> @enderror</small>
 
                                <div wire:loading wire:target="sermon">Uploading...</div>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-12 mb-20">

                        <div wire:loading>
                            <input type="submit" value="Cancel" class="button button-danger">
                            <input type="submit" value="Uploading file..." class="button button-warning">
                        </div>

                        <div wire:loading.remove>
                            <input type="submit" value="Cancel" class="button button-danger">
                            <input type="submit" value="Submit" class="button button-primary">
                        </div>

                    </div>
    
                </div>
            </form>
        </div>
    </div>
</div>
