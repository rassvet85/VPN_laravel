<?php
  $menuJson='{
    "menuList": [

      {
        "title": "Welcome",
        "link": "/laravel",
        "icon": "fal fa-graduation-cap",
        "filterTag": "Welcome",
        "i18n": "nav.laravel"
      },

      {
        "title": "Page Views",
        "filterTag": "pages",
        "icon": "fal fa-plus-circle",
        "i18n": "nav.pages",
        "child": [

          {
            "link": "javascript:void(0);",
            "title": "Authentication",
            "filterTag": "pages authentication",
            "icon": "",
            "i18n": "nav.pages_authentication",
            "subChild": [
              {
                "link": "/page/page_forget",
                "title": "Forget Password",
                "filterTag": "pages authentication forget password",
                "i18n": "nav.pages_authentication_forget_password"
              },
              {
                "link": "/page/page_locked",
                "title": "Locked Screen",
                "filterTag": "pages authentication locked screen",
                "i18n": "nav.pages_authentication_locked_screen"
              },
              {
                "link": "/page/page_login_alt",
                "title": "Login Alt",
                "filterTag": "pages authentication login alt",
                "i18n": "nav.pages_authentication_login_alt"
              },
              {
                "link": "/page/page_register",
                "title": "Register",
                "filterTag": "pages authentication register",
                "i18n": "nav.pages_authentication_register"
              },
              {
                "link": "/page/page_confirmation",
                "title": "Confirmation",
                "filterTag": "pages authentication confirmation",
                "i18n": "nav.pages_authentication_confirmation"
              }
            ]
          },
          {
            "link": "javascript:void(0);",
            "title": "Error Pages",
            "filterTag": "Error Pages",
            "icon": "",
            "i18n": "nav.pages_error_pages",
            "subChild": [
              {
                "link": "/page/page_error",
                "title": "General Error",
                "filterTag": "pages error pages general error",
                "i18n": "nav.pages_error_pages_general_error"
              },
              {
                "link": "/page/page_error_404",
                "title": "Server Error",
                "filterTag": "pages error pages server error",
                "i18n": "nav.pages_error_pages_server_error"
              },
              {
                "link": "/page/page_error_announced",
                "title": "Announced Error",
                "filterTag": "pages error pages announced error",
                "i18n": "nav.pages_error_pages_announced_error"
              }
            ]
          },


          {
            "link": "/page/page_search",
            "title": "Search Results",
            "filterTag": "pages search results",
            "icon": "",
            "i18n": "nav.pages_search_results"
          }
        ]
      }
    ]
  }';
         ?>

          <!-- BEGIN Left Aside -->
          <aside class="page-sidebar">
              <div class="page-logo">
                  <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
                      <img src="{{ URL::asset('/img/logo.png') }}" alt="SmartAdmin Laravel" aria-roledescription="logo">
                      <span class="page-logo-text mr-1">SmartAdmin Laravel</span>
                      <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2">Laravel 9.0</span>
                      <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
                  </a>
              </div>
              <!-- BEGIN PRIMARY NAVIGATION -->
              <nav id="js-primary-nav" class="primary-nav" role="navigation">
                  <div class="nav-filter">
                      <div class="position-relative">
                          <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                          <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                              <i class="fal fa-chevron-up"></i>
                          </a>
                      </div>
                  </div>
                  <div class="info-card">
                      <img src="{{ URL::asset('/img/demo/avatars/avatar-admin.png') }}" class="profile-image rounded-circle" alt="Dr. Codex Lantern">
                      <div class="info-card-text">
                          <a href="#" class="d-flex align-items-center text-white">
                              <span class="text-truncate text-truncate-sm d-inline-block">
                                  {{ ucfirst(auth()->user()->name) }}
                              </span>
                          </a>
                          <span class="d-inline-block text-truncate text-truncate-sm">Toronto, Canada</span>
                      </div>
                      <img src="{{ URL::asset('/img/card-backgrounds/cover-1-lg.png') }}" class="cover" alt="cover">
                      <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                          <i class="fal fa-angle-down"></i>
                      </a>
                  </div>
                  <?php
                    $decodedMenu = json_decode($menuJson);
                    ?>
                  <ul id="js-nav-menu" class="nav-menu">
                      @foreach ($decodedMenu->{'menuList'} as $key => $value)
                      @if(isset($value->onlyLi) && $value->onlyLi === "true")
                      <li class="nav-title @if(isset($value->liClass)) {{$value->liClass}} @endif">{{ $value->title }}</li>
                      @elseif(!isset($value->child))
                      <li class="@if(isset($value->liClass)) {{$value->liClass}} @endif">
                        <a href="{{ $value->link }}"  title="{{ $value->title }}" data-filter-tags="{{ $value->filterTag }}">
                          <i class="{{ $value->icon }}"></i>
                            <span class="nav-link-text" data-i18n="{{ $value->i18n }}">
                                {{ $value->filterTag }}
                            </span>
                        </a>
                       </li>
                      @else
                      <li class="@if(isset($value->liClass)) {{$value->liClass}} @endif">
                          <a href="javascript:void(0);" title="{{ $value->title }}"  data-filter-tags="{{ $value->filterTag }}">
                              <i class="{{ $value->icon }}"></i>
                              <span class="nav-link-text" data-i18n="{{ $value->i18n }}">{{ $value->title }}
                              </span>
                          </a>
                          <ul id="{{ $value->i18n }}">
                              @for ($i=0; $i < sizeof($value->child); $i++)
                                  <li class="@if(isset($value->child[$i]->liClass)) {{$value->child[$i]->liClass}} @endif">
                                      <?php
                                        $i18Var = "";
                                        $i18Var = $value->child[$i]->{'i18n'};  ?>
                                      <a href="{{ $value->child[$i]->{'link'} }}"  title="{{ $value->child[$i]->{'title'} }}" data-filter-tags="{{ $value->child[$i]->{'filterTag'} }}">
                                          <span class="nav-link-text" data-i18n="{{ $value->child[$i]->{'i18n'} }}">
                                              {{ $value->child[$i]->{'title'} }}
                                          </span>
                                          @if(isset($value->child[$i]->{'spanText'}))
                                          <span class="{{ isset(($value->child[$i]->{'spanClass'})) ? $value->child[$i]->{'spanClass'} : '' }}">{{ $value->child[$i]->{'spanText'} }}</span>
                                          @endif
                                      </a>
                                      @if(isset($value->child[$i]->{'subChild'}))
                                      <ul id="{{ $i18Var }}">
                                          @for ($k=0; $k < sizeof($value->child[$i]->{'subChild'}); $k++)
                                              <li class="@if(isset($value->child[$i]->{'subChild'}[$k]->liClass)) {{$value->child[$i]->{'subChild'}[$k]->liClass}} @endif">
                                                  <a href="{{ $value->child[$i]->{'subChild'}[$k]->link }}" title="{{ $value->child[$i]->{'subChild'}[$k]->title }}" data-filter-tags="{{ $value->child[$i]->{'subChild'}[$k]->filterTag }}">
                                                      <span class="nav-link-text" data-i18n="{{ $value->child[$i]->{'subChild'}[$k]->i18n }}">{{ $value->child[$i]->{'subChild'}[$k]->title }}</span>
                                                  </a>
                                              </li>
                                              @endfor
                                      </ul>
                                      @endif
                                  </li>
                                  @endfor
                          </ul>
                      </li>
                      @endif
                      @endforeach
                  </ul>
                  <div class="filter-message js-filter-message bg-success-600"></div>
              </nav>
              <div class="nav-footer shadow-top">
                  <a href="#" onclick="return false;" data-action="toggle" data-class="nav-function-minify" class="hidden-md-down">
                      <i class="ni ni-chevron-right"></i>
                      <i class="ni ni-chevron-right"></i>
                  </a>
                  <ul class="list-table m-auto nav-footer-buttons">
                      <li>
                          <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Chat logs">
                              <i class="fal fa-comments"></i>
                          </a>
                      </li>
                      <li>
                          <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Support Chat">
                              <i class="fal fa-life-ring"></i>
                          </a>
                      </li>
                      <li>
                          <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Make a call">
                              <i class="fal fa-phone"></i>
                          </a>
                      </li>
                  </ul>
              </div> <!-- END NAV FOOTER -->
          </aside>
          <!-- END Left Aside -->
