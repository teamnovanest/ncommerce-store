
<form method="post" action="/update/cart/item">
  <input type="hidden" name="productid" value="{{ $row->rowId }}">
  <input type="number" class="qty"  name="qty" pattern="[0-9]" value="{{ $row->qty }}" style="width: 50px;" min="1">
  <i class="fas fa-check-square"></i>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  <button type="submit" class="btn btn-success btn-sm btn-update-qty">✔</button>
</form> 