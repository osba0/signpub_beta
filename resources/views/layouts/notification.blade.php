<div class="dropdown-menu dropdown-menu-end pe-3" aria-labelledby="notif">
    <ul id="notifUl">
        @foreach(auth()->user()->unreadNotifications as $notification)

            @if(!auth()->user()->isAdmin())
                <li class="ws-nowrap py-1">
                    <a href="/orders/{{ $notification->data['order_id'] }}" class="link-secondary">Commande n°{{ $notification->data['order_id'] }} - @php echo \App\Models\StatusOrder::getValueStatusOrder($notification->data['status']); @endphp</a>
                </li>
            @endif
            @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_SALLE_TIRAGE_ROULEAU) ||
                auth()->user()->hasRole(\App\Models\UserRole::ROLE_SALLE_TIRAGE_FEUILLE) ||
                auth()->user()->hasRole(\App\Models\UserRole::ROLE_SALLE_DECOUPE))
                <li class="ws-nowrap py-1">
                    <a href="/order-get/{{ $notification->data['order_id'] }}" class="link-secondary">New Commande #{{ $notification->data['order_id'] }}</a>
                </li>
            @endif
            @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_FINITION))
                <li class="ws-nowrap py-1">
                    <a href="/order-get/{{ $notification->data['order_id'] }}" class="link-secondary">New Commande #{{ $notification->data['order_id'] }}</a>
                </li>
            @endif
             @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_SECRETARIAT))
                @isset($notification->data['status'])
                    <li class="ws-nowrap py-1">
                        <a href="/order-get/{{ $notification->data['order_id'] }}" class="link-secondary">Commande n°{{ $notification->data['order_id'] }} - @php echo \App\Models\StatusOrder::getValueStatusOrder($notification->data['status']); @endphp</a>
                    </li>
                @endisset
                @isset($notification->data['client'])
                    <li class="ws-nowrap py-1">
                        <a href="/order-get/{{ $notification->data['order_id'] }}" class="link-secondary">New Commande #{{ $notification->data['order_id'] }} de {{ $notification->data['client'] }}</a>
                    </li>
                @endisset
            @endif
            @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_ADMIN))
                 @isset($notification->data['status'])
                    <li class="ws-nowrap py-1">
                        <a href="/order-get/{{ $notification->data['order_id'] }}" class="link-secondary">Commande n°{{ $notification->data['order_id'] }} - @php echo \App\Models\StatusOrder::getValueStatusOrder($notification->data['status']); @endphp</a>
                    </li>
                @endisset
                @isset($notification->data['client'])
                    <li class="ws-nowrap py-1">
                        <a href="/order-get/{{ $notification->data['order_id'] }}" class="link-secondary">New Commande #{{ $notification->data['order_id'] }} de {{ $notification->data['client'] }}</a>
                    </li>
                @endisset
            @endif
        @endforeach
    </ul>
</div>