@extends('admin.layouts.masterAddEdit')

@section('card_body')
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <label for="amount">Amount</label>
                <div class="form-group {{ $errors->has('amount') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Amount" id="amount" name="amount" value="{{ old('amount') }}">
                    @if ($errors->has('amount'))
                        @foreach($errors->get('amount') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-5">
                <label for="discount">Discount</label>
                <div class="form-group {{ $errors->has('discount') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Discount" id="discount" name="discount" value="{{ old('discount') }}">
                    @if ($errors->has('discount'))
                        @foreach($errors->get('discount') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-2">
                <label for=""></label>
                <div class="form-group {{ $errors->has('discount') ? ' has-danger' : '' }}">
                    <input type="button" class="btn btn-outline-info btn-md" name="buttonAddEdit" onclick="getProductPrice()" value="view">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label for="product-price">Product Price</label>
                <div class="form-group {{ $errors->has('productPrice') ? ' has-danger' : '' }}">
                    <input type="text" class="form-control" placeholder="Amount" id="productPrice" name="productPrice" value="{{ old('productPrice') }}">
                    @if ($errors->has('productPrice'))
                        @foreach($errors->get('productPrice') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">
        function getProductPrice()
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var amount = parseFloat($('#amount').val());
            var discount = parseFloat($('#discount').val());

            $.ajax({
                type:'post',
                url:'{{ route('newProject.findProductPrice') }}',
                data:{amount:amount,discount:discount},
                success:function(data){
                    $("#productPrice").val(data.productPrice);
                }
            });
        }
    </script>
@endsection