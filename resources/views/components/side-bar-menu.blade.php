<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ route('dashboard') }}" class="app-brand-link">
      @if(!empty(getSetting('black_logo', null)))
        <img src="{{ asset('storage').'/'.getSetting('black_logo', null) }}" width="130px" class="img-fluid light-logo img-logo" alt="{{ getSetting('name', null) }}" />
      @else
        <img src="{{ asset('storage/images/default.png') }}" width="130px" class="img-fluid light-logo img-logo" alt="Default" />
      @endif
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
