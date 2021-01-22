<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UST Booking System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.4.0/dist/fullcalendar.min.js"></script>
      <!-- DayPilot library -->
    <script src="/assets/js/daypilot/daypilot-all.min.js"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        $uri = service('uri');
    ?>
<div class="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header text-center">
            <a class="navbar-brand text-wrap " href="/"><h3>UST Booking System</h3></a>
        </div>
        <?php if (session()->get('isLogged')): ?>
        <ul class="list-unstyled components">
            <li class="<?= ($uri->getSegment(1) == '' ? 'active' : null) ?>">
              <a class="nav-link" href="/">Schedule</a>
            </li>
            <li class="<?= ($uri->getSegment(1) == 'about' ? 'active' : null) ?>">
              <a class="nav-link" href="/about">About</a>
            </li>
            <li class="<?= ($uri->getSegment(1) == 'facilities' ? 'active' : null) ?>">
              <a class="nav-link" href="/facilities">Facilities</a>
            </li>
        <?php if (session()->get('access') == 0):?>
            <li class="<?= ($uri->getSegment(1) == 'register' ? 'active' : null) ?>">
              <a class="nav-link" href="/admin/register">Register New User</a>
            </li>
            <li class="<?= ($uri->getSegment(1) == 'addfacility' ? 'active' : null) ?>">
              <a class="nav-link" href="/admin/addfacility">Add New Facility</a>
            </li>
        <?php endif;?>
        </ul>
        <ul class="list-unstyled components">
            <li class="nav-item">
                <a class="nav-link" href="/logout">Logout</a>
            </li>
            <!-- <li class="active">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li>
                        <a href="#">Home 1</a>
                    </li>
                    <li>
                        <a href="#">Home 2</a>
                    </li>
                    <li>
                        <a href="#">Home 3</a>
                    </li>
                </ul>
            </li> -->
            <!-- <li>
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li>
                        <a href="#">Page 1</a>
                    </li>
                    <li>
                        <a href="#">Page 2</a>
                    </li>
                    <li>
                        <a href="#">Page 3</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">Portfolio</a>
            </li>
            <li>
                <a href="#">Contact</a>
            </li> -->
        </ul>
        <?php else: ?>
        <ul class="list-unstyled components">
            <li class="nav-item">
                <a class="nav-link <?= ($uri->getSegment(1) == '' ? 'active' : null) ?>"  href="/">Home</a>
            </li>
        </ul>
        <?php endif; ?>
    </nav>
    <div id="content">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
              <button type="button" id="sidebarCollapse" class="btn btn-info">
                  <i class="fas fa-align-left"></i>
                  <span class="navbar-toggler-icon"></span>
              </button>
              <a href="#" target="_blank" rel="noopener noreferrer"></a>
          </div>
      </nav>
       


