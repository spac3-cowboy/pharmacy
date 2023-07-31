@extends("Layout.MainLayout")



@section("title", "Sold Medicines Repost")

@section("main")
    <div class="card shadow-none border">
        <div class="card-header bg-pitla-blue d-flex justify-content-between">
            <span>Top Sold Medicine Report</span>
        </div>
        <div class="card-body p-1 bordered">
            <div class="row my-3">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="from">From</label>
                        <input type="date" class="form-control" id="from"/>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="to">To</label>
                        <input type="date" class="form-control" id="to"/>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group text-end">
                        <label class="d-block " for="">Filter</label>
                        <button id="filter" class="btn btn-primary form-control w-50">Submit</button>
                    </div>
                </div>
{{--                <div class="col-lg-12">--}}
{{--                    <div class="form-group text-end">--}}
{{--                        <label class="d-block" for=""></label>--}}
{{--                        <br>--}}
{{--                        <button class="btn btn-success form-control w-25">Download</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
            <div class="row">
                <div class="col-12" >
                    <div class="card border border-danger shadow-none" style="max-width: 200px">
                        <div class="card-body p-1">
                            <strong>Total Sales</strong> <br>
                            <span class="badge badge-secondary-lighten" id="total-sales-value"></span>
                        </div>
                    </div>
                </div>
            </div>
            @include("ui.report.widgets.TablePaginatedTopSoldMedicineReport")
        </div>
    </div>
@endsection


