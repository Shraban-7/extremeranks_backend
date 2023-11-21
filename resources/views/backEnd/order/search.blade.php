@if($orders->count() > 0)
<table class="table">
	@foreach($orders as $key=>$value)
	<tr>
		<td><a href="{{url('admin/order/details/'.$value->id)}}">ID-{{$value->order_id}} - ${{$value->total}}</a></td>
	</tr>
	@endforeach
</table>
@endif