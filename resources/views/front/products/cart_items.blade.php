<?php use App\Product; ?>
<table class="table table-bordered">
    <thead>
      <tr>
        <th>Product</th>
        <th colspan="2">Description</th>
        <th>Quantity/Update</th>
        <th>Unit Price</th>
        <th>Category/Product<br> Discount</th>
        <th>Sub Total</th>
      </tr>
    </thead>
    <tbody>
      <?php $total_price=0; ?>
      @foreach($userCartItems as$items)
      <?php $attrPrice = Product::getDiscountedAtt rPrice($items['product_id'],$items['type']); ?>
          <tr>
              <td colspan="2"> <img width="60" src="{{ asset('images/product_images/small/'.$items['product']['main_image']) }}" alt=""/></td>
              <td>
                  {{$items['product']['product_name']}}<br/>
                  Color : {{$items['product']['product_color']}}<br/>
                  Type : {{$items['type']}}

              </td>
              <td>
                  <div class="input-append">
                      <input class="span1" style="max-width:34px" value="{{ $items['quantity']}}" id="appendedInputButtons" size="16" type="text">
                      <button class="btn btnItemUpdate qtyMinus" type="button" data-cartid="{{ $items['id'] }}"><i class="icon-minus"></i>
                      </button>
                      <button class="btn btnItemUpdate qtyPlus" type="button" data-cartid="{{ $items['id'] }}"><i class="icon-plus"></i>
                      </button><button class="btn btn-danger btnItemDelete" type="button" data-cartid="{{ $items['id'] }}">
                          <i class="icon-remove icon-white"></i></button>
                  </div>
              </td>
              <td>{{$attrPrice['product_price'] }}</td>
              <td>Rs.{{$attrPrice['discount'] }}</td>

              <td>{{$attrPrice['final_price']* $items['quantity']}}</td>
          </tr>
          <?php $total_price=$total_price+ ($attrPrice['final_price']* $items['quantity']); ?>
      @endforeach


      <tr>
        <td colspan="6" style="text-align:right">Sub Total:	</td>
        <td> Rs.{{$total_price}}</td>
      </tr>
       <tr>
        <td colspan="6" style="text-align:right">Voucher Discount:	</td>
        <td> Rs.0.00</td>
      </tr>

       <tr>
        <td colspan="6" style="text-align:right"><strong>GRAND TOTAL (Rs.{{$total_price}} - Rs.0 ) =</strong></td>
        <td class="label label-important" style="display:block"> <strong> Rs.{{$total_price}}</strong></td>
      </tr>
      </tbody>
</table>
