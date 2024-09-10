<aside>
    <div class="inner-box">
        <div class="user-panel-sidebar">
                        <h5 class="collapse-title no-border">
                            Visit Store&nbsp;
                        </h5>
                <div class="#">
                    <div class="panel-collapse collapse show" id="#">
                        <ul class="acc-list">
                            <li>
                                <a href="{{ auth()->check() ? 'https://shop.ezead.com/login?u=' . auth()->user()->id . '&r=ezead.com' : 'https://shop.ezead.com/' }}" target="_blank">
                                    <i class="fas fa-store"></i>
                                    <span>
                                        My Store
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            @if (isset($userMenu) && !empty($userMenu))
                @php
                    $userMenu = $userMenu->groupBy('group');
                @endphp
                @foreach ($userMenu as $group => $menu)
                    @php
                        $boxId = str($group)->slug();
                    @endphp
                    <div class="collapse-box">
                        <h5 class="collapse-title no-border">
                            {{ $group }}&nbsp;
                            <a href="#{{ $boxId }}" data-bs-toggle="collapse" class="float-end"><i
                                    class="fa fa-angle-down"></i></a>
                        </h5>
                        @foreach ($menu as $key => $value)
                            <div class="panel-collapse collapse show" id="{{ $boxId }}">
                                <ul class="acc-list">
                                    <li>
                                        <a {!! isset($value['isActive']) && $value['isActive'] ? 'class="active"' : '' !!} href="{{ $value['url'] }}">
                                            <i class="{{ $value['icon'] }}"></i> {{ $value['name'] }}
                                            @if (isset($value['countVar']) && !empty($value['countVar']))
                                                <span
                                                    class="badge badge-pill{{ !empty($value['countCustomClass']) ? $value['countCustomClass'] . ' hide' : '' }}">
                                                    {{ \App\Helpers\Number::short(data_get($stats, $value['countVar']) ?? 0) }}
                                                </span>
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</aside>
