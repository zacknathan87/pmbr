<?php
$menus =  App\Models\AdminMenu::getMenus(0);
?>



<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ admin_url('dashboard') }}">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-dice"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Admin</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <?php

  $admin_level = Auth::guard('admin')->user()->level;
  foreach ($menus as $menu) {

    if (in_array($admin_level, explode(",", $menu->allow_level)) || empty($menu->allow_level)) {

      $path = !empty($menu->path) ? admin_url($menu->path) : '#';
      $submenu = App\Models\AdminMenu::getMenus($menu->id);

      $collapsed = (!empty($submenu->toArray())) ? ' collapsed' : '';
      $submenuAttr = (!empty($submenu->toArray())) ? ' data-toggle="collapse" data-target="#menu' . $menu->id . '"' : '';

      $menuClass = classActivePath($menu->code, 2);
      $submenuClass = classActivePath($menu->code, 2) == 'active' ? 'show' : '';


      echo '<li class="nav-item ' . $menuClass . '">';


      echo '<a class="nav-link ' . $collapsed . '" ' . $submenuAttr . ' href="' . $path . '">
    <i class="' . $menu->icon . '"></i>
    <span>' . __('admin.'.$menu->name_code) . '</span></a>
    ';

      if ((!empty($submenu->toArray()))) {

        echo '<div id="menu' . $menu->id . '" class="collapse ' . $submenuClass . '" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">';
        foreach ($submenu as $sm) {
          echo '<a class="collapse-item ' . classActivePath($sm->code, 2) . '" href="' . admin_url($sm->path) . '">' . __('admin.'.$sm->name_code) . '</a>';
        }
        echo '</div></div>';
      }

      echo '</li>';
    }
  }
  ?>


  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->