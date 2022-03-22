<div>
    <form wire:submit.prevent="onFilterObjects">
        <div class="row mb-5">
            <div class="col-md-3">
                <select wire:model.defer="filter_month" class="form-control">
                    @foreach ($months as $index => $month)
                        <option value="{{ $index }}">{{ $month }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select wire:model.defer="filter_year" class="form-control">
                    @foreach ($years as $index => $year)
                        <option value="{{ $index }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Get</button>
            </div>
        </div>
    </form>

    <div class="row">

        <!--Order List Start-->
        <div class="col-12">
            
            <table class="table table-vertical-middle">
                <thead>
                    <tr>
                        <th class="text-center">SN</th>
                        <th>Sermon</th>
                        <th>Size</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($s3Objects as $s3Object)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $s3Object['Key'] }}</td>
                        <td>{{ round(($s3Object['Size'] / (1024 * 1024)), 2) }}mb</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!--Order List End-->
    
    </div>
</div>
