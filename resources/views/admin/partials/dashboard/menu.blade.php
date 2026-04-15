<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.feedback.index') }}" class="app-brand-link">
            <span class="app-brand-text fw-bolder fs-4 text-dark">VOID</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <hr class="my-0">
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1 pt-3">

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Контент</span>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
            <a href="{{ route('admin.feedback.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-envelope"></i>
                <div>Заявки</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">
            <a href="{{ route('admin.properties.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-building-house"></i>
                <div>Объекты</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <a href="{{ route('admin.categories.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div>Категории</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <a href="{{ route('admin.settings.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div>Настройки сайта</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase"><span class="menu-header-text">SEO</span></li>

        <li class="menu-item {{ request()->routeIs('admin.seo.*') ? 'active' : '' }}">
            <a href="{{ route('admin.seo.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-purchase-tag"></i>
                <div>Мета-теги</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.robots.*') ? 'active' : '' }}">
            <a href="{{ route('admin.robots.edit') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bot"></i>
                <div>Robots.txt</div>
            </a>
        </li>

    </ul>
</aside>
