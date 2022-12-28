<!-- Sidenav -->
<div id="sidenav" data-mdb-color="dark" role="navigation">
    @menu( 'admin', 0, 0 )
    <hr>
    <ul class="sidenav-menu">
      <li class="sidenav-item">
        <a class="sidenav-link">
          <i class="fas fa-cog fa-fw me-3"></i><span>{{ __('app.settings') }}</span>
        </a>
      </li>
      <li class="sidenav-item">
        <a class="sidenav-link">
          <i class="fas fa-question-circle fa-fw me-3"></i><span>{{ __('app.help') }}</span>
        </a>
      </li>
      <li class="sidenav-item">
        <a class="sidenav-link">
            <i class="fas fa-comment-alt fa-fw me-3"></i><span>{{ __('app.send_feedback') }}</span>
        </a>
      </li>
    </ul>
    <hr>
    <p class="small text-muted ps-4">© {{ date('Y') }} {{ config('apex.copyright', 'Laravel') }}</p>
    </div>
<!-- Sidenav -->
