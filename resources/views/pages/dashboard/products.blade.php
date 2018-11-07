@forelse($products as $item)
    <tr>
        <th scope="row">{{$item->id}}</th>
        <td>{{$item->title}}</td>
        <td><img width="100" src="{{$item->image}}" alt="{{$item->title}}"></td>
        <td style="width: 40%" >{{$item->description}}</td>
        <td>{{$item->first_invoice}}</td>
        <td><a href="{{$item->url}}" target="_blank">{{$item->url}}</a></td>
        <td>{{$item->price}}</td>
        <td>{{$item->amount}}</td>
        <td style="width: 30%" class="text-left">
            @foreach($item->offers as $offer)
                <p><b>id:</b> {{$offer->id}}</p>
                <p><b>price:</b> {{$offer->price}}</p>
                <p><b>amount:</b> {{$offer->amount}}</p>
                <p><b>sales:</b> {{$offer->sales}}</p>
                <p><b>article:</b> {{$offer->article}}</p>
                <hr />
            @endforeach
        </td>
        <td style="width: 30%"  class="text-left">
            @foreach($item->categories as $category)
                <p>id:{{$category->id}}</p>
                <p>title: {{$category->title}}</p>
                <p>alias: {{$category->alias}}</p>
                <p>parent: {{$category->parent}}</p>
                <hr />
            @endforeach
        </td>
    </tr>
@empty
    <tr>
        <td colspan="10">
            List of Empty
        </td>
    </tr>
@endforelse

