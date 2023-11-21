@php
    $subtotal = Session::get('subtotal');
    $tax = Session::get('tax')?Session::get('tax'):0;
    $discount = Session::get('discount')?Session::get('discount'):0;
@endphp
<thead>
<tr>
    <td>Subtotal</td>
    <td></td>
    <td class="text-end">${{$subtotal}}</td>
</tr>
</thead>
<tbody>
<tr>
    <td>Discount</td>
    <td class="text-center">:</td>
    <td class="text-end">${{$discount}}</td>
</tr>
<tr>
    <td>Tax</td>
    <td class="text-center">:</td>
    <td class="text-end">${{$tax}}</td>
</tr>
<tr>
    <td>Payable</td>
    <td class="text-center">:</td>
    <td class="text-end">${{($subtotal+$tax)- $discount}}</td>
</tr>
</tbody>