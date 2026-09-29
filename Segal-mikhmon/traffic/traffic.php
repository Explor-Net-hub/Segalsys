<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
if (empty($_SESSION['mikhmon'])) { http_response_code(401); echo json_encode(['error' => 'ابتدا وارد شوید']); exit; }
$session = $_GET['session'] ?? '';
$interface = $_GET['iface'] ?? '';
if (!preg_match('/^[a-zA-Z0-9_-]+$/D', $session) || $interface === '') { http_response_code(400); echo json_encode(['error' => 'نشست یا رابط شبکه نامعتبر است']); exit; }
include('../include/config.php');
if (!isset($data[$session])) { http_response_code(404); echo json_encode(['error' => 'نشست یافت نشد']); exit; }
include('../include/readcfg.php');
include_once('../lib/routeros_api.class.php');
$API = new RouterosAPI();
$API->debug = false;
if (!$API->connect($iphost, $userhost, decrypt($passwdhost))) { http_response_code(503); echo json_encode(['error' => 'ارتباط با روتر برقرار نشد']); exit; }
$traffic = $API->comm('/interface/monitor-traffic', ['interface' => $interface, 'once' => '']);
$API->disconnect();
if (!isset($traffic[0]['tx-bits-per-second'], $traffic[0]['rx-bits-per-second'])) { http_response_code(502); echo json_encode(['error' => 'داده ترافیک دریافت نشد']); exit; }
echo json_encode([['name' => 'آپلود', 'data' => (int)$traffic[0]['tx-bits-per-second']], ['name' => 'دانلود', 'data' => (int)$traffic[0]['rx-bits-per-second']]]);
