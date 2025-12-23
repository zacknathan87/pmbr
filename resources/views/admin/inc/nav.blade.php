 <!-- Topbar -->
 <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

   <!-- Sidebar Toggle (Topbar) -->
   <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
     <i class="fa fa-bars"></i>
   </button>

   <?php if (Auth::guard('admin')->user()->level == 2) { ?>
     <div class="">
       {{__('admin.my_balance')}}: <?php echo currency_format(Auth::guard('admin')->user()->wallet->balance, 'RM') ?>
     </div>
   <?php } ?>

   <!-- Topbar Navbar -->
   <ul class="navbar-nav ml-auto">

     <!-- Nav Item - User Information -->
     <li class="nav-item dropdown no-arrow">
       <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <span class="mr-2 text-gray-600 "><?php echo Auth::guard('admin')->user()->username ?></span>
         <i class="fas fa-user-circle" style="font-size: 32px"></i>
       </a>
       <!-- Dropdown - User Information -->
       <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
         <a class="dropdown-item" href="{{ admin_url('account/change_password') }}">
           <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
           {{__('admin.change_password')}}
         </a>
         <div class="dropdown-divider"></div>
         <a class="dropdown-item" href="{{ admin_url('logout') }}">
           <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
           {{__('admin.logout')}}
         </a>
       </div>


     </li>

     <!-- Nav Item - User Information -->
     <li class="nav-item dropdown no-arrow">
       <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <img src="{{ asset('img/flags/'.App::getLocale().'.svg') }}" width="30px" />
       </a>
       <!-- Dropdown - User Information -->
       <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="languageDropdown">
         <a class="dropdown-item" href="{{ url('locale/en') }}">
           <img src="{{ asset('img/flags/en.svg') }}" width="30px" style="display:block;margin:0 auto" />
         </a>
         <a class="dropdown-item" href="{{ url('locale/cn') }}">
           <img src="{{ asset('img/flags/cn.svg') }}" width="30px" style="display:block;margin:0 auto" />
         </a>
       </div>


     </li>



   </ul>

 </nav>
 <!-- End of Topbar -->