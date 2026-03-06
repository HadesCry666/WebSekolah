<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">

    <!-- Logo besar (saat sidebar normal) -->
  <div class="sidebar-brand normal-logo">
  <a href="{{ url('/dashboard') }}" class="d-flex align-items-center justify-content-center">
    <span style="font-weight: bold; font-size: 20px;">SMP SAQU</span>
  </a>
</div>


    <!-- Logo kecil (saat sidebar collapse / titik tiga ditekan) -->
    <div class="sidebar-brand sidebar-brand-sm collapsed-logo">
      <a href="{{ url('/dashboard') }}">
        <img src="{{ asset('/storage/mentahan-logo.jpg') }}" alt="Logo Kecil" style="height:35px; margin-left:5px;">
      </a>
    </div>

    <ul class="sidebar-menu">
      <li><a class="nav-link" href="{{ url('/admin/dashboard') }}"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
      <li><a class="nav-link" href="{{ url('/admin/tenaga-pendidik') }}"><i class="fas fa-users"></i><span>Tenaga Pendidik</span></a></li>
      <li><a class="nav-link" href="{{ url('/admin/ekstrakulikuler') }}"><i class="fas fa-futbol"></i><span>Ekstrakulikuler</span></a></li>
      <li><a class="nav-link" href="{{ url('/admin/pengaduan') }}"><i class="fas fa-comments"></i><span>Pengaduan</span></a></li>
      <li><a class="nav-link" href="{{ url('/admin/profil-sekolah') }}"><i class="fas fa-school"></i><span>Profil sekolah</span></a></li>
      <li><a class="nav-link" href="{{ url('/admin/informasi') }}"><i class="fas fa-info-circle"></i><span>Informasi</span></a></li>
{{-- 
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-columns"></i> <span>Layout</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="layout-default.html">Default Layout</a></li>
          <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
          <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
        </ul>
      </li> --}}

      {{-- <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-th"></i> <span>Bootstrap</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="bootstrap-alert.html">Alert</a></li>
          <li><a class="nav-link" href="bootstrap-badge.html">Badge</a></li>
          <li><a class="nav-link" href="bootstrap-breadcrumb.html">Breadcrumb</a></li>
          <li><a class="nav-link" href="bootstrap-buttons.html">Buttons</a></li>
          <li><a class="nav-link" href="bootstrap-card.html">Card</a></li>
          <li><a class="nav-link" href="bootstrap-carousel.html">Carousel</a></li>
          <li><a class="nav-link" href="bootstrap-collapse.html">Collapse</a></li>
          <li><a class="nav-link" href="bootstrap-dropdown.html">Dropdown</a></li>
          <li><a class="nav-link" href="bootstrap-form.html">Form</a></li>
          <li><a class="nav-link" href="bootstrap-list-group.html">List Group</a></li>
          <li><a class="nav-link" href="bootstrap-media-object.html">Media Object</a></li>
          <li><a class="nav-link" href="bootstrap-modal.html">Modal</a></li>
          <li><a class="nav-link" href="bootstrap-nav.html">Nav</a></li>
          <li class="active"><a class="nav-link" href="bootstrap-navbar.html">Navbar</a></li>
          <li><a class="nav-link" href="bootstrap-pagination.html">Pagination</a></li>
          <li><a class="nav-link" href="bootstrap-popover.html">Popover</a></li>
          <li><a class="nav-link" href="bootstrap-progress.html">Progress</a></li>
          <li><a class="nav-link" href="bootstrap-table.html">Table</a></li>
          <li><a class="nav-link" href="bootstrap-tooltip.html">Tooltip</a></li>
          <li><a class="nav-link" href="bootstrap-typography.html">Typography</a></li>
        </ul>
      </li> --}}

      {{-- <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-th-large"></i> <span>Components</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="components-article.html">Article</a></li>
          <li><a class="nav-link beep beep-sidebar" href="components-avatar.html">Avatar</a></li>
          <li><a class="nav-link" href="components-chat-box.html">Chat Box</a></li>
          <li><a class="nav-link beep beep-sidebar" href="components-empty-state.html">Empty State</a></li>
          <li><a class="nav-link" href="components-gallery.html">Gallery</a></li>
          <li><a class="nav-link beep beep-sidebar" href="components-hero.html">Hero</a></li>
          <li><a class="nav-link" href="components-multiple-upload.html">Multiple Upload</a></li>
          <li><a class="nav-link beep beep-sidebar" href="components-pricing.html">Pricing</a></li>
          <li><a class="nav-link" href="components-statistic.html">Statistic</a></li>
          <li><a class="nav-link" href="components-tab.html">Tab</a></li>
          <li><a class="nav-link" href="components-table.html">Table</a></li>
          <li><a class="nav-link" href="components-user.html">User</a></li>
          <li><a class="nav-link beep beep-sidebar" href="components-wizard.html">Wizard</a></li>
        </ul>
      </li> --}}

      {{-- <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="far fa-file-alt"></i> <span>Forms</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="forms-advanced-form.html">Advanced Form</a></li>
          <li><a class="nav-link" href="forms-editor.html">Editor</a></li>
          <li><a class="nav-link" href="forms-validation.html">Validation</a></li>
        </ul>
      </li> --}}
    </ul>
  </aside>
</div>

<!-- Tambahkan CSS -->
<style>
  /* Default: tampilkan hanya logo besar */
  .collapsed-logo {
    display: none;
  }

  /* Saat sidebar collapse (class body.sidebar-mini aktif di Stisla) */
  body.sidebar-mini .normal-logo {
    display: none !important;
  }

  body.sidebar-mini .collapsed-logo {
    display: block !important;
  }
</style>
