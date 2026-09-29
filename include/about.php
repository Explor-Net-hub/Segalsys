<?php
/*
 *  Copyright (C) 2018 Laksamadi Guko.
 *  Modified & Customized for Segal System
 *  Developed by Dadeh Pardazan Ovrin Segal
 */
session_start();
error_reporting(0);
if (!isset($_SESSION["mikhmon"])) {
  header("Location:../admin.php?id=login");
  exit();
}
?>

<div class="row" style="direction: rtl; text-align: right;">
  <div class="col-12">
    <div class="card" style="border-top: 4px solid #3498db;">
      <div class="card-header">
        <h3 style="margin: 0; font-size: 18px; color: #f1f2f6;">
          <i class="fa fa-info-circle" style="color: #3498db; margin-left: 8px;"></i> درباره سامانه سگال سیستم
        </h3>
      </div>
      <div class="card-body" style="line-height: 1.9; font-size: 14px;">
        <h3 style="color: #3498db; margin-top: 5px; margin-bottom: 12px; font-weight: bold;">
          سگال سیستم (نسخه مدیریت و مانیتورینگ اینترنت هات‌اسپات)
        </h3>
        
        <p style="color: #dcdde1; text-align: justify;">
          سامانه <strong>سگال سیستم</strong> یک راهکار تخصصی و بومی‌سازی‌شده جهت مدیریت متمرکز احراز هویت، کنترل حجم مصرفی اینترنت کاربران، صدور ووچرهای چاپی و نظارت بلادرنگ بر روترهای میکروتیک است. این سیستم با رابط کاربری فارسی، راست‌چین و سازگار با تقویم شمسی پیاده‌سازی شده و از روترهای نسل جدید با معماری ARM64 (نظیر hAP ax³) و محیط‌های کانتینری به طور کامل پشتیبانی می‌کند.
        </p>

        <div style="background: #1a1e27; border: 1px solid #323846; border-radius: 6px; padding: 15px 20px; margin: 20px 0;">
          <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="margin-bottom: 8px;">
              <strong style="color: #3498db;">• نام سامانه:</strong> سگال سیستم
            </li>
            <li style="margin-bottom: 8px;">
              <strong style="color: #3498db;">• توسعه و پشتیبانی فنی:</strong> داده پردازان اورین سگال
            </li>
            <li style="margin-bottom: 8px;">
              <strong style="color: #3498db;">• نسخه نرم‌افزار:</strong> <?= isset($_SESSION['v']) ? $_SESSION['v'] : '1.0.0'; ?>
            </li>
            <li style="margin-bottom: 8px;">
              <strong style="color: #3498db;">• پروتکل ارتباطی:</strong> MikroTik RouterOS API
            </li>
            <li>
              <strong style="color: #3498db;">• وب‌سایت رسمی:</strong> 
              <a href="https://ovrinsegal.ir" target="_blank" rel="noopener noreferrer" style="color: #2ecc71; text-decoration: none; font-weight: bold; border-bottom: 1px dashed #2ecc71; padding-bottom: 2px;">
                ovrinsegal.ir <i class="fa fa-external-link" style="font-size: 12px; margin-right: 4px;"></i>
              </a>
            </li>
          </ul>
        </div>

        <p style="color: #a4b0be; font-size: 13px; margin-bottom: 0;">
          تمامی حقوق مادی و معنوی این سامانه متعلق به <strong>داده پردازان اورین سگال</strong> می‌باشد.
        </p>
      </div>
    </div>
  </div>
</div>