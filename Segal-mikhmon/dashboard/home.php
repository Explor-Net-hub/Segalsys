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

  // تاریخ و ساعت سیستم میکروتیک
  $getclock = $API->comm("/system/clock/print");
  $clock = $getclock[0];
  $timezone = $getclock[0]['time-zone-name'];
  $_SESSION['timezone'] = $timezone;
  if (!empty($timezone)) {
    date_default_timezone_set($timezone);
  }

  // منابع سیستم میکروتیک
  $getresource = $API->comm("/system/resource/print");
  $resource = $getresource[0];

  // مشخصات روتربورد
  $getrouterboard = $API->comm("/system/routerboard/print");
  $routerboard = $getrouterboard[0];

  // شمارش کل کاربران هات‌اسپات
  $countallusers = $API->comm("/ip/hotspot/user/print", array("count-only" => ""));
  $uunit = "کاربر";

  // شمارش کاربران آنلاین
  $counthotspotactive = $API->comm("/ip/hotspot/active/print", array("count-only" => ""));
  $hunit = "آنلاین";

  if ($livereport == "disable") {
    $logh = "457px";
    $lreport = "style='display:none;'";
  } else {
    $logh = "350px";
    $lreport = "style='display:block;'";
  }
}
?>

<div id="reloadHome">

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
                    مدت کارکرد (Uptime): " . formatDTM($resource['uptime']);
                    $_SESSION[$session.'sdate'] = $clock['date'];
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
                    مدل دستگاه: " . $routerboard['model'] . "<br/>
                    نسخه RouterOS: " . $resource['version'];
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
                    echo "فشار پردازنده: " . to_persian_num($resource['cpu-load']) . "%<br/>
                    حافظه رم آزاد: " . formatBytes($resource['free-memory'], 2) . "<br/>
                    فضای دیسک آزاد: " . formatBytes($resource['free-hdd-space'], 2)
                    ?>
                </span>
                </div>
              </div>
            </div>
          </div> 
      </div>

        <div class="row">
          <div class="col-8">
            <div id="r_2" class="row">
            <div class="card">
              <div class="card-header"><h3><i class="fa fa-wifi"></i> مدیریت کاربران هات‌اسپات</h3></div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-3 col-box-6">
                      <div class="box bg-blue bmh-75">
                        <a onclick="cancelPage()" href="./?hotspot=active&session=<?= $session; ?>">
                          <h1><?= to_persian_num($counthotspotactive); ?>
                              <span style="font-size: 15px;"><?= $hunit; ?></span>
                            </h1>
                          <div>
                            <i class="fa fa-laptop"></i> کاربران آنلاین
                          </div>
                        </a>
                      </div>
                    </div>
                    <div class="col-3 col-box-6">
                    <div class="box bg-green bmh-75">
                      <a onclick="cancelPage()" href="./?hotspot=users&profile=all&session=<?= $session; ?>">
                            <h1><?= to_persian_num($countallusers); ?>
                              <span style="font-size: 15px;"><?= $uunit; ?></span>
                            </h1>
                      <div>
                            <i class="fa fa-users"></i> کل کاربران
                          </div>
                      </a>
                    </div>
                  </div>
                  <div class="col-3 col-box-6">
                    <div class="box bg-yellow bmh-75">
                      <a onclick="cancelPage()" href="./?hotspot-user=add&session=<?= $session; ?>">
                        <div>
                          <h1><i class="fa fa-user-plus"></i>
                              <span style="font-size: 15px;">افزودن</span>
                          </h1>
                        </div>
                        <div>
                            <i class="fa fa-user-plus"></i> کاربر جدید
                        </div>
                      </a>
                    </div>
                  </div>
                  <div class="col-3 col-box-6">
                    <div class="box bg-red bmh-75">
                      <a onclick="cancelPage()" href="./?hotspot-user=generate&session=<?= $session; ?>">
                        <div>
                          <h1><i class="fa fa-ticket"></i>
                              <span style="font-size: 15px;">تولید</span>
                          </h1>
                        </div>
                        <div>
                            <i class="fa fa-ticket"></i> صدور ووچر
                        </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </div>
            <div class="card">
              <div class="card-header"><h3><i class="fa fa-area-chart"></i> مانیتورینگ ترافیک زنده </h3></div>

              <div class="card-body">
  
                  <?php 
                  $getinterface = $API->comm("/interface/print");
                  $interface = isset($getinterface[$iface - 1]['name']) ? $getinterface[$iface - 1]['name'] : 'ether1'; 
                  ?>
                  
                  <script type="text/javascript"> 
                    var chart;
                    var sessiondata = <?= json_encode($session) ?>;
                    var interface = <?= json_encode($interface) ?>;
                    function requestDatta(session,iface) {
                      if (!iface || requestDatta.busy) return;
                      requestDatta.busy = true;
                      $.ajax({
                        url: './traffic/traffic.php',
                        data: {session: session, iface: iface},
                        dataType: "json",
                        timeout: 2500,
                        success: function(data) {
                          var midata = data;
                          if (midata.length === 2 && chart) {
                            var TX=parseInt(midata[0].data);
                            var RX=parseInt(midata[1].data);
                            var x = (new Date()).getTime(); 
                            var shift = chart.series[0].data.length > 19;
                            chart.series[0].addPoint([x, TX], false, shift);
                            chart.series[1].addPoint([x, RX], false, shift);
                            chart.redraw();
                          }
                        },
                        complete: function() { requestDatta.busy = false; },
                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                          console.error("Status: " + textStatus + " error: " + errorThrown); 
                        }       
                      });
                    }	

                    $(document).ready(function() {
                        Highcharts.setOptions({
                          global: { useUTC: false }
                        });

                        chart = new Highcharts.Chart({
                          chart: {
                            renderTo: 'trafficMonitor',
                            animation: Highcharts.svg,
                            type: 'areaspline',
                            events: {
                              load: function () {
                                setInterval(function () {
                                  requestDatta(sessiondata,interface);
                                }, 3000);
                              }				
                            }
                          },
                          title: {
                            text: 'کارت شبکه: ' + interface
                          },
                          xAxis: {
                            type: 'datetime',
                            tickPixelInterval: 120,
                            labels: {
                              formatter: function() {
                                var d = new Date(this.value);
                                return toFaDigit(('0' + d.getHours()).slice(-2) + ':' + ('0' + d.getMinutes()).slice(-2) + ':' + ('0' + d.getSeconds()).slice(-2));
                              }
                            }
                          },
                          yAxis: {
                              title: { text: 'پهنای باند' },
                              labels: {
                                formatter: function () {      
                                  var bytes = this.value;                          
                                  var sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
                                  if (bytes == 0) return '0 bps';
                                  var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                                  return toFaDigit(parseFloat((bytes / Math.pow(1024, i)).toFixed(2))) + ' ' + sizes[i];                    
                                }
                              }       
                          },
                          series: [{
                            name: 'آپلود (TX)',
                            color: '#e74c3c',
                            data: []
                          }, {
                            name: 'دانلود (RX)',
                            color: '#2ecc71',
                            data: []
                          }],
                          tooltip: {
                            shared: true,
                            useHTML: true,
                            formatter: function () {
                              var s = '<div style="direction:rtl; text-align:right;"><b>زمان: </b>' + Highcharts.dateFormat('%H:%M:%S', new Date(this.x)) + '<br/>';
                              $.each(this.points, function () {
                                var bytes = this.y;
                                var sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
                                var val = '0 bps';
                                if (bytes > 0) {
                                  var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                                  val = parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
                                }
                                s += '<span style="color:' + this.series.color + '">●</span> ' + this.series.name + ': <b>' + toFaDigit(val) + '</b><br/>';
                              });
                              s += '</div>';
                              return s;
                            }
                          }
                        });
                    });
                  </script>
                  <div id="trafficMonitor" style="direction: ltr;"></div>
                </div> 
              </div>
            </div>  
            <div class="col-4">
              <div id="r_3" class="row">
              <div class="card">
                <div class="card-header">
                  <h3><a onclick="cancelPage()" href="./?hotspot=log&session=<?= $session; ?>" title="مشاهده لاگ کامل" ><i class="fa fa-align-justify"></i> لاگ وقایع روتر</a></h3>
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
                        <tr>
                          <td colspan="3" class="text-center">
                            <div id="loader"><i><i class='fa fa-circle-o-notch fa-spin'></i> در حال بارگذاری وقایع...</i></div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              </div>
            </div>
</div>
</div>