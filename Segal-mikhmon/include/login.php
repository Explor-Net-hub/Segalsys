<?php
/*
 *  Copyright (C) 2018 Laksamadi Guko.
 *  Modified & Customized for Segal System
 *  Developed by Dadeh Pardazan Ovrin Segal
 */
session_start();
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ورود به سامانه سگال | شرکت داده‌پردازان اورین سگال</title>
  <link rel="icon" type="image/png" sizes="32x32" href="img/favicon.png" />
  <link rel="apple-touch-icon" sizes="180x180" href="img/segal-favicon-180.png" />
  
  <!-- فونت بهینه وزیرمتن -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css">
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/mikhmon-ui.dark.min.css">
  <link rel="stylesheet" href="css/mikhmon-ui.css">

  <style>
    * {
      font-family: 'Vazirmatn', Tahoma, sans-serif !important;
      direction: rtl;
      box-sizing: border-box;
    }
    body {
      background-color: #1e222d;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }
    .login-container {
      width: 100%;
      max-width: 400px;
      padding: 20px;
    }
    .login-card {
      background: #262b37;
      border: 1px solid #323846;
      border-top: 4px solid #3498db;
      border-radius: 8px;
      padding: 30px 25px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
      text-align: center;
    }
    .login-logo {
      max-height: 88px;
      max-width: min(100%, 300px);
      height: auto;
      margin-bottom: 15px;
      display: inline-block;
    }
    .login-title {
      color: #f1f2f6;
      font-size: 20px;
      font-weight: bold;
      margin: 0 0 5px 0;
    }
    .login-subtitle {
      color: #a4b0be;
      font-size: 13px;
      margin-bottom: 25px;
      display: block;
    }
    .form-group {
      margin-bottom: 18px;
      text-align: right;
    }
    .form-group label {
      display: block;
      color: #dcdde1;
      font-size: 13px;
      margin-bottom: 6px;
    }
    .form-control-custom {
      width: 100%;
      height: 42px;
      background-color: #1a1e27;
      border: 1px solid #323846;
      border-radius: 5px;
      color: #fff;
      padding: 0 12px;
      font-size: 14px;
      transition: border-color 0.2s;
    }
    .form-control-custom:focus {
      outline: none;
      border-color: #3498db;
    }
    .btn-login-submit {
      width: 100%;
      height: 42px;
      background-color: #3498db;
      border: none;
      border-radius: 5px;
      color: #ffffff;
      font-size: 15px;
      font-weight: bold;
      cursor: pointer;
      margin-top: 10px;
      transition: background-color 0.2s;
    }
    .btn-login-submit:hover {
      background-color: #2980b9;
    }
    .error-msg {
      background-color: rgba(231, 76, 60, 0.15);
      border: 1px solid #e74c3c;
      color: #ff6b6b;
      padding: 10px;
      border-radius: 5px;
      font-size: 13px;
      margin-top: 15px;
      text-align: center;
    }
    .login-footer {
      margin-top: 25px;
      padding-top: 15px;
      border-top: 1px solid #323846;
      font-size: 12px;
      color: #a4b0be;
    }
    .login-footer a {
      color: #2ecc71;
      text-decoration: none;
      font-weight: bold;
    }
    .login-footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="login-container">
  <div class="login-card">
    <!-- لوگو اختصاصی سگال -->
    <div>
      <img src="img/logo.png" alt="نشان شرکت داده‌پردازان اورین سگال" class="login-logo" onerror="this.src='img/favicon.png'">
    </div>
    
    <div class="login-title">سامانه سگال</div>
    <span class="login-subtitle">سامانه مدیریت و احراز هویت هات‌اسپات</span>

    <form autocomplete="off" action="" method="post">
      <div class="form-group">
        <label for="_username"><i class="fa fa-user"></i> نام کاربری مدیر:</label>
        <input class="form-control-custom" type="text" name="user" id="_username" placeholder="نام کاربری را وارد کنید" required autofocus>
      </div>

      <div class="form-group">
        <label for="_password"><i class="fa fa-lock"></i> کلمه عبور:</label>
        <input class="form-control-custom" type="password" name="pass" id="_password" placeholder="کلمه عبور را وارد کنید" required>
      </div>

      <input class="btn-login-submit" type="submit" name="login" value="ورود به پنل مدیریت">

      <?php if (!empty($error)): ?>
        <div class="error-msg">
          <i class="fa fa-exclamation-triangle"></i> <?= htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>
    </form>

    <div class="login-footer">
      توسعه و پشتیبانی فنی: شرکت داده‌پردازان اورین سگال<br>
      وب‌سایت رسمی: <a href="https://ovrinsegal.ir" target="_blank" rel="noopener noreferrer">ovrinsegal.ir</a>
    </div>
  </div>
</div>

</body>
</html>