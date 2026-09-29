<?php
/*
 *  Copyright (C) 2018 Laksamadi Guko.
 *  Modified for Segal Persian Hotspot System
 */
session_start();
error_reporting(0);
if (!isset($_SESSION["mikhmon"])) {
  header("Location:../admin.php?id=login");
  exit();
} else {
  $session = $_GET['session'];
  $load = $_GET['load'];

  // زبان
  include_once('../lang/fa.php');

  // کانفیگ و ارتباط میکروتیک
  include('../include/config.php');
  include('../include/readcfg.php');
  include_once('../lib/routeros_api.class.php');
  include_once('../lib/formatbytesbites.php');
  
  $API = new RouterosAPI();
  $API->debug = false;

  if ($load == "sysresource") {
    $API->connect($iphost, $userhost, decrypt($passwdhost));

    $getclock = $API->comm("/system/clock/print");
    $clock = $getclock[0];
    $timezone = $getclock[0]['time-zone-name'];
    if (!empty($timezone)) {
      date_default_timezone_set($timezone);
    }

    $getresource = $API->comm("/system/resource/print");
    $resource = $getresource[0];

    $getrouterboard = $API->comm("/system/routerboard/print");
    $routerboard = $getrouterboard[0];
    ?>
    
    <div id="r_1" class="row">
      <div class="col-4">
        <div class="box bmh-75 box-bordered">
          <div class="box-group">
            <div class="box-group-icon"><i class="fa fa-calendar"></i></div>
              <div class="box-group-area">
              <span>زمان و تاریخ سیستم:<br>
                    <?php 
                    $shamsi_now = function_exists('get_current_shamsi_date') ? get_current_shamsi_date() : date('Y/m/d');
                    echo "امروز: " . to_persian_num($shamsi_now) . " - " . $clock['time'] . "<br>
                    مدت کارکرد: " . formatDTM($resource['uptime']);
                    ?>
                </span>
              </div>
            </div>
          </div>
        </div>
      <div class="col-4">
        <div class="box bmh-75 box-bordered">
          <div class="box-group">
          <div class="box-group-icon"><i class="fa fa-info-circle"></i></div>
              <div class="box-group-area">
                <span>
                    <?php
                    echo "نام بورد: " . $resource['board-name'] . "<br/>
                    مدل: " . $routerboard['model'] . "<br/>
                    RouterOS: " . $resource['version'];
                    ?>
                </span>
              </div>
            </div>
          </div>
        </div>
    <div class="col-4">
      <div class="box bmh-75 box-bordered">
        <div class="box-group">
          <div class="box-group-icon"><i class="fa fa-server"></i></div>
              <div class="box-group-area">
                <span>
                    <?php
                    echo "پردازنده: " . to_persian_num($resource['cpu-load']) . "%<br/>
                    حافظه رم آزاد: " . formatBytes($resource['free-memory'], 2) . "<br/>
                    دیسک آزاد: " . formatBytes($resource['free-hdd-space'], 2);
                    ?>
                </span>
                </div>
              </div>
            </div>
          </div> 
      </div>

<?php 
  } else if ($load == "hotspot") {
    $API->connect($iphost, $userhost, decrypt($passwdhost));
    $countallusers = $API->comm("/ip/hotspot/user/print", array("count-only" => ""));
    $counthotspotactive = $API->comm("/ip/hotspot/active/print", array("count-only" => ""));
?>
    
    <div id="r_2" class="card">
      <div class="card-header"><h3><i class="fa fa-wifi"></i> مدیریت کاربران هات‌اسپات</h3></div>
        <div class="card-body">
          <div class="row">
            <div class="col-3 col-box-6">
              <div class="box bg-blue bmh-75">
                <a href="./?hotspot=active&session=<?= $session; ?>">
                  <h1><?= to_persian_num($counthotspotactive); ?> <span style="font-size: 15px;">آنلاین</span></h1>
                  <div><i class="fa fa-laptop"></i> کاربران متصل لحظه‌ای</div>
                </a>
              </div>
            </div>
            <div class="col-3 col-box-6">
            <div class="box bg-green bmh-75">
              <a href="./?hotspot=users&profile=all&session=<?= $session; ?>">
                <h1><?= to_persian_num($countallusers); ?> <span style="font-size: 15px;">کاربر</span></h1>
                <div><i class="fa fa-users"></i> کل کاربران تعریف‌شده</div>
              </a>
            </div>
          </div>
          <div class="col-3 col-box-6">
            <div class="box bg-yellow bmh-75">
              <a href="./?hotspot-user=add&session=<?= $session; ?>">
                <div><h1><i class="fa fa-user-plus"></i> <span style="font-size: 15px;">ثبت</span></h1></div>
                <div><i class="fa fa-user-plus"></i> افزودن کاربر جدید</div>
              </a>
            </div>
          </div>
          <div class="col-3 col-box-6">
            <div class="box bg-red bmh-75">
              <a href="./?hotspot-user=generate&session=<?= $session; ?>">
                <div><h1><i class="fa fa-ticket"></i> <span style="font-size: 15px;">صدور</span></h1></div>
                <div><i class="fa fa-ticket"></i> تولید دسته جمعی اکانت</div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php 
  } else if ($load == "logs") {
    $API->connect($iphost, $userhost, decrypt($passwdhost));
    $getlog = $API->comm("/log/print", array("?topics" => "hotspot,info,debug"));
    $log = array_reverse($getlog);
    $logh = ($livereport == "disable") ? "457px" : "350px";
?>
  
    <div id="r_3" class="row">
      <div class="card">
        <div class="card-header">
          <h3><a href="./?hotspot=log&session=<?= $session; ?>" title="مشاهده لاگ"><i class="fa fa-align-justify"></i> لاگ وقایع روتر</a></h3>
        </div>
        <div class="card-body">
          <div style="padding: 5px; height: <?= $logh; ?>;" class="mr-t-10 overflow">
            <table class="table table-sm table-bordered table-hover" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>زمان</th>
                  <th>کاربر (IP)</th>
                  <th>پیام</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $total_logs = min(20, count($log));
                for ($i = 0; $i < $total_logs; $i++) {
                  $time = $log[$i]['time'];
                  $msg = $log[$i]['message'];
                  echo "<tr>";
                  echo "<td>" . to_persian_num($time) . "</td>";
                  echo "<td>" . htmlspecialchars($log[$i]['topics']) . "</td>";
                  echo "<td>" . htmlspecialchars($msg) . "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
<?php 
  }
}
?>