<?php
/*
 *  Copyright (C) 2018 Laksamadi Guko.
 *  Modified for Segal Persian Hotspot System
 */
if (substr($_SERVER["REQUEST_URI"], -8) == "menu.php") {
    header("Location:./");
    exit();
}

// خواندن متغیر سشن فعال
$curr_session = isset($_GET['session']) ? htmlspecialchars($_GET['session']) : (isset($session) ? $session : '');
$curr_hotspot = isset($_GET['hotspot']) ? htmlspecialchars($_GET['hotspot']) : '';
?>

<div class="sidebar" style="direction: rtl; text-align: right;">
    <!-- بخش برند و لوگو اختصاصی -->
    <div style="padding: 16px 10px; border-bottom: 1px solid #323846; text-align: center;">
        <a href="./?session=<?= $curr_session; ?>" style="text-decoration: none;">
            <img src="./img/logo.png" alt="نشان شرکت داده‌پردازان اورین سگال" style="max-height: 52px; max-width: 190px; width: 100%; height: auto; margin-bottom: 6px; display: inline-block;" onerror="this.style.display='none'">
            <h4 style="margin: 0; color: #3498db; font-size: 15px; font-weight: bold;">مدیریت هات‌اسپات سگال<br><small style="font-size: 11px; color: #d7dce3;">شرکت داده‌پردازان اورین سگال</small></h4>
        </a>
        <small style="color: #a4b0be; display: block; margin-top: 6px; font-size: 11px;">
            امروز: <?= function_exists('get_current_shamsi_date') ? to_persian_num(get_current_shamsi_date()) : date('Y/m/d'); ?>
        </small>
    </div>

    <!-- ناوبری اصلی -->
    <ul class="nav" style="list-style: none; padding: 10px 0; margin: 0;">
        <!-- داشبورد -->
        <li class="<?= empty($curr_hotspot) ? 'active' : ''; ?>">
            <a href="./?session=<?= $curr_session; ?>" style="display: block; padding: 10px 15px; color: #f1f2f6; text-decoration: none;">
                <i class="fa fa-dashboard" style="margin-left: 8px; width: 18px; text-align: center;"></i>
                <span>داشبورد مانیتورینگ</span>
            </a>
        </li>

        <!-- کاربران هات‌اسپات -->
        <li class="<?= ($curr_hotspot == 'users') ? 'active' : ''; ?>">
            <a href="./?hotspot=users&profile=all&session=<?= $curr_session; ?>" style="display: block; padding: 10px 15px; color: #f1f2f6; text-decoration: none;">
                <i class="fa fa-users" style="margin-left: 8px; width: 18px; text-align: center;"></i>
                <span>فهرست کل کاربران</span>
            </a>
        </li>

        <!-- کاربران آنلاین -->
        <li class="<?= ($curr_hotspot == 'active') ? 'active' : ''; ?>">
            <a href="./?hotspot=active&session=<?= $curr_session; ?>" style="display: block; padding: 10px 15px; color: #f1f2f6; text-decoration: none;">
                <i class="fa fa-wifi" style="margin-left: 8px; width: 18px; text-align: center; color: #2ecc71;"></i>
                <span>کاربران آنلاین (Active)</span>
            </a>
        </li>

        <!-- افزودن کاربر جدید -->
        <li class="<?= ($curr_hotspot == 'user-add') ? 'active' : ''; ?>">
            <a href="./?hotspot-user=add&session=<?= $curr_session; ?>" style="display: block; padding: 10px 15px; color: #f1f2f6; text-decoration: none;">
                <i class="fa fa-user-plus" style="margin-left: 8px; width: 18px; text-align: center;"></i>
                <span>افزودن کاربر جدید</span>
            </a>
        </li>

        <!-- صدور دسته‌ای ووچر -->
        <li class="<?= ($curr_hotspot == 'generate') ? 'active' : ''; ?>">
            <a href="./?hotspot-user=generate&session=<?= $curr_session; ?>" style="display: block; padding: 10px 15px; color: #f1f2f6; text-decoration: none;">
                <i class="fa fa-ticket" style="margin-left: 8px; width: 18px; text-align: center; color: #e67e22;"></i>
                <span>تولید و چاپ ووچر</span>
            </a>
        </li>

        <!-- پروفایل‌های کاربری و سرعت -->
        <li class="<?= ($curr_hotspot == 'user-profiles') ? 'active' : ''; ?>">
            <a href="./?hotspot=user-profiles&session=<?= $curr_session; ?>" style="display: block; padding: 10px 15px; color: #f1f2f6; text-decoration: none;">
                <i class="fa fa-pie-chart" style="margin-left: 8px; width: 18px; text-align: center;"></i>
                <span>پروفایل‌های مصرف و سرعت</span>
            </a>
        </li>

        <!-- دستگاه‌های متصل (Hosts) -->
        <li class="<?= ($curr_hotspot == 'hosts') ? 'active' : ''; ?>">
            <a href="./?hotspot=hosts&session=<?= $curr_session; ?>" style="display: block; padding: 10px 15px; color: #f1f2f6; text-decoration: none;">
                <i class="fa fa-laptop" style="margin-left: 8px; width: 18px; text-align: center;"></i>
                <span>دستگاه‌های شبکه (Hosts)</span>
            </a>
        </li>

        <!-- تخصیص IP و MAC (Bypass) -->
        <li class="<?= ($curr_hotspot == 'ipbinding') ? 'active' : ''; ?>">
            <a href="./?hotspot=ipbinding&session=<?= $curr_session; ?>" style="display: block; padding: 10px 15px; color: #f1f2f6; text-decoration: none;">
                <i class="fa fa-shield" style="margin-left: 8px; width: 18px; text-align: center;"></i>
                <span>استثناها (IP Binding)</span>
            </a>
        </li>

        <!-- مانیتورینگ زنده ترافیک -->
        <li class="<?= ($curr_hotspot == 'traffic') ? 'active' : ''; ?>">
            <a href="./?hotspot=traffic&session=<?= $curr_session; ?>" style="display: block; padding: 10px 15px; color: #f1f2f6; text-decoration: none;">
                <i class="fa fa-area-chart" style="margin-left: 8px; width: 18px; text-align: center; color: #3498db;"></i>
                <span>گراف مصرف پهنای باند</span>
            </a>
        </li>

        <!-- لاگ وقایع -->
        <li class="<?= ($curr_hotspot == 'log') ? 'active' : ''; ?>">
            <a href="./?hotspot=log&session=<?= $curr_session; ?>" style="display: block; padding: 10px 15px; color: #f1f2f6; text-decoration: none;">
                <i class="fa fa-history" style="margin-left: 8px; width: 18px; text-align: center;"></i>
                <span>لاگ وقایع سیستم</span>
            </a>
        </li>

        <!-- تنظیمات -->
        <li class="<?= ($curr_hotspot == 'settings') ? 'active' : ''; ?>" style="border-top: 1px solid #323846; margin-top: 8px; padding-top: 4px;">
            <a href="./?hotspot=settings&session=<?= $curr_session; ?>" style="display: block; padding: 10px 15px; color: #a4b0be; text-decoration: none;">
                <i class="fa fa-cog" style="margin-left: 8px; width: 18px; text-align: center;"></i>
                <span>تنظیمات روتر</span>
            </a>
        </li>

        <!-- خروج -->
        <li>
            <a href="./admin.php?id=logout" onclick="return confirm('آیا از خروج اطمینان دارید؟');" style="display: block; padding: 10px 15px; color: #e74c3c; text-decoration: none;">
                <i class="fa fa-sign-out" style="margin-left: 8px; width: 18px; text-align: center;"></i>
                <span>خروج از پنل</span>
            </a>
        </li>
    </ul>
</div>