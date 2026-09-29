<?php
// بررسی انتخاب زبان فارسی و آماده‌سازی تقویم شمسی
$is_rtl = (isset($_SESSION['lang']) && $_SESSION['lang'] === 'fa') || (isset($ceklang) && $ceklang === 'fa');

// تابع تبدیل تاریخ میلادی به شمسی
if (!function_exists('gregorian_to_jalali')) {
    function gregorian_to_jalali($gy, $gm, $gd) {
        $g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
        $days = 355666 + (365 * $gy) + ((int)(($gy2 + 3) / 4)) - ((int)(($gy2 + 99) / 100)) + ((int)(($gy2 + 399) / 400)) + $gd + $g_d_m[$gm - 1];
        $jy = -1595 + (33 * ((int)($days / 12053)));
        $days %= 12053;
        $jy += 4 * ((int)($days / 1461));
        $days %= 1461;
        if ($days > 365) {
            $jy += (int)(($days - 1) / 365);
            $days = ($days - 1) % 365;
        }
        if ($days < 186) {
            $jm = 1 + (int)($days / 31);
            $jd = 1 + ($days % 31);
        } else {
            $jm = 7 + (int)(($days - 186) / 30);
            $jd = 1 + (($days - 186) % 30);
        }
        return [$jy, $jm, $jd];
    }

    function get_current_shamsi_date() {
        $gDate = explode('-', date('Y-m-d'));
        $jDate = gregorian_to_jalali((int)$gDate[0], (int)$gDate[1], (int)$gDate[2]);
        return sprintf('%04d/%02d/%02d', $jDate[0], $jDate[1], $jDate[2]);
    }

    function to_persian_num($number) {
        $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $fa = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        return str_replace($en, $fa, (string)$number);
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $is_rtl ? 'fa' : 'en'; ?>" dir="<?= $is_rtl ? 'rtl' : 'ltr'; ?>">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($hotspotname) ? htmlspecialchars($hotspotname) : "سامانه سگال | شرکت داده‌پردازان اورین سگال"; ?></title>
  <link rel="icon" type="image/png" sizes="32x32" href="./img/favicon.png" />
  <link rel="apple-touch-icon" sizes="180x180" href="./img/segal-favicon-180.png" />
  
  <?php if ($is_rtl): ?>
    <!-- فونت بهینه وزیرمتن برای زبان فارسی -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css">
  <?php endif; ?>

  <link rel="stylesheet" href="./css/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/mikhmon-ui.<?= isset($theme) ? $theme : 'dark'; ?>.min.css">
  <link rel="stylesheet" href="./css/mikhmon-ui.css">

  <script src="./js/jquery.min.js"></script>
  <script src="./js/highcharts/highcharts.js"></script>
  <script src="./js/mikhmon.js"></script>

  <script>
    function toFaDigit(n) {
      const f = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
      return n.toString().replace(/\d/g, d => f[d]);
    }
  </script>
</head>
<body>