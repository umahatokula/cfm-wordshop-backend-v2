<form action="{{route('pins.generate')}}" method="POST">
    @csrf
    <div class="row mbn-20">

        <div class="col-12 mb-20">
            <div class="row mbn-10">
                <div class="col-sm-5 col-12 mb-10"><label for="number_to_generate">Number of PINs to generate</label>
                </div>
                <div class="col-sm-7 col-12 mb-10">
                    <input type="number" max="100" name="number_to_generate" id="number_to_generate"
                        class="form-control" placeholder="Number of PINs to generate"
                        aria-describedby="number_to_generate">
                    <small id="number_to_generate" class="text-muted">Max of 100</small>
                </div>
            </div>
        </div>

        <div class="col-12 mb-20">
            <div class="row mbn-10">
                <div class="col-sm-5 col-12 mb-10"><label for="value">Value on each PIN</label></div>
                <div class="col-sm-7 col-12 mb-10">
                    <input type="number" max="5000" name="value" id="" class="form-control"
                        placeholder="Value on each PIN" aria-describedby="value">
                    <small id="value" class="text-muted">E.g. 1000</small>
                </div>
            </div>
        </div>

        <hr>

        <div class="col-12 mb-20 text-center">
            <input type="submit" value="Generate" class="button button-primary">
            <a href="{{route('pins.listPins')}}" class="button button-danger">Cancel</a>
        </div>

</form>
