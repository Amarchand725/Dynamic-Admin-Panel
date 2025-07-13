<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
      <a href="{{ route('dashboard') }}" class="app-brand-link">
        <span class="app-brand-logo demo">
          @if(!empty(getSetting('black_logo', null)))
            <img src="{{ asset('storage').'/'.getSetting('black_logo', null) }}" width="130px" class="img-fluid light-logo img-logo" alt="{{ getSetting('name', null) }}" />
          @else
            <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                fill="#7367F0"
              />
              <path
                opacity="0.06"
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                fill="#161616"
              />
              <path
                opacity="0.06"
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                fill="#161616"
              />
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                fill="#7367F0"
              />
            </svg>
          @endif
        </span>
        <span class="app-brand-text demo menu-text fw-bold">{{ appAbbreviation() }}</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
      </a>
    </div>

  <div class="menu-inner-shadow"></div>
  
  <!-- Vertical Progress Bar -->
  <div class="sidebar-progress-bar">
    <div class="sidebar-progress" id="sidebar-progress"></div>
  </div>

  <div class="scroll-container" style="position: relative; overflow-y: auto; height: calc(100vh - 64px);">
    <ul class="menu-inner py-1">
      @if(isset(settings()->website_url) && !empty(settings()->website_url))
        <li class="menu-item">
          <a href="{{ settings()->website_url }}" class="menu-link" target="blank">
              <i class="menu-icon tf-icons ti ti-world"></i>
              <div>Go to Site</div>
          </a>
        </li>
      @endif
      <li class="menu-item {{ request()->is('dashboard')?'active':'' }}">
        <a href="{{ url('dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div>Dashboards</div>
        </a>
      </li>

      @can('menus-list')
      <li class="menu-item {{ request()->is('menus/settings')?'active':'' }}">
        <a href="{{ route('menus.settings') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-settings"></i>
          <div>Menus Reorder</div>
        </a>
      </li>
      @endcan

      @php 
        $menuGroups = getDynamicMenuGroups();
      @endphp 

      @foreach ($menuGroups as $menuGroup)  
        @php
          $menus = $menuGroup['has_child_menus'];
          $permissions = array_map(function ($menu) {
              $pluralMenu = str_replace('-', '_', Str::kebab(Str::plural($menu)));
              return $pluralMenu . '-list';
          }, $menus);
        @endphp

        <!-- Top-level menu item to group all dynamic menus -->
        @if(isset($menus) && !empty($menus))
          @canany($permissions)
          <li class="menu-item
              {{
                in_array(request()->path(), array_map(fn($menu) => str_replace('-', '_', Str::kebab(Str::plural($menu))), $menus)) ? 'open active' : ''
              }}
          ">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons {{ $menuGroup['icon'] ?? 'ti ti-smart-home' }}"></i>
                  <div>{{ $menuGroup['menu_label'] }}</div>
              </a>

              <ul class="menu-sub">
                @foreach ($menus as $menu)
                    @php
                      $pluralMenu = str_replace('-', '_', Str::kebab(Str::plural($menu)));
                      $permission = $pluralMenu . '-list';
                      $route = $pluralMenu; // Plural route, e.g., 'categories', 'brands', etc.
                    @endphp

                    @canany([$permission])
                        <li class="menu-item {{ request()->is($route) || request()->is($route . '/*') ? 'active' : '' }}">
                            <a href="{{ route($route . '.index') }}" class="menu-link">
                                <div>All {{ Str::title(str_replace('_', ' ', Str::plural($menu))) }}</div>
                            </a>
                        </li>
                    @endcanany
                @endforeach
              </ul>
          </li>
          @endcanany
        @endif
      @endforeach
    </ul>
  </div>
</aside>
<script>
  let scrollArea;
  document.addEventListener("DOMContentLoaded", function () {
      scrollArea = document.querySelector('#layout-menu .scroll-container');
      const progressBar = document.getElementById("sidebar-progress");

      if (scrollArea && progressBar) {
        function updateProgress() {
          const scrollTop = scrollArea.scrollTop;
          const scrollHeight = scrollArea.scrollHeight - scrollArea.clientHeight;
          const percent = scrollHeight > 0 ? (scrollTop / scrollHeight) * 100 : 0;
          progressBar.style.height = percent + "%";
        }

        scrollArea.addEventListener("scroll", updateProgress);
        updateProgress();
      } else {
        console.warn("Progress bar or scroll container not found");
      }
  });

scrollArea = document.getElementById('scrollArea'); // or querySelector('.scroll-area') depending on your HTML

if (scrollArea) {
  scrollArea.addEventListener("wheel", function (e) {
    const delta = e.deltaY;
    const up = delta < 0;
    const down = delta > 0;

    const atTop = scrollArea.scrollTop === 0;
    const atBottom = scrollArea.scrollTop + scrollArea.clientHeight >= scrollArea.scrollHeight;

    if ((up && !atTop) || (down && !atBottom)) {
      e.preventDefault();
      scrollArea.scrollTop += delta;
    }
  }, { passive: false });
}
</script>
